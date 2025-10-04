<?php

namespace App\Console\Commands;

use Igniter\Cart\Models\Menu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class FreshnessAlertsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'freshness:check {--notify : Send notifications for expired items}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired or expiring menu items and send alerts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking freshness status...');
        
        $sendNotifications = $this->option('notify');
        
        // Get items with freshness_date set
        $menuItems = Menu::where('menu_status', 1)
            ->whereNotNull('freshness_date')
            ->get();
        
        $this->info("Checking {$menuItems->count()} items with freshness dates...");
        
        $expired = collect();
        $expiringToday = collect();
        $expiringTomorrow = collect();
        
        foreach ($menuItems as $item) {
            $freshnessDate = \Carbon\Carbon::parse($item->freshness_date);
            
            if ($freshnessDate->isPast() && !$freshnessDate->isToday()) {
                $expired->push($item);
            } elseif ($freshnessDate->isToday()) {
                $expiringToday->push($item);
            } elseif ($freshnessDate->isTomorrow()) {
                $expiringTomorrow->push($item);
            }
        }
        
        $this->newLine();
        
        // Display expired items
        if ($expired->count() > 0) {
            $this->error("⚠ {$expired->count()} EXPIRED ITEMS:");
            foreach ($expired as $item) {
                $daysAgo = \Carbon\Carbon::parse($item->freshness_date)->diffInDays(now());
                $this->line("  - {$item->menu_name} (expired {$daysAgo} day(s) ago)");
            }
            $this->newLine();
        }
        
        // Display items expiring today
        if ($expiringToday->count() > 0) {
            $this->warn("⚠ {$expiringToday->count()} items expiring TODAY:");
            foreach ($expiringToday as $item) {
                $this->line("  - {$item->menu_name}");
            }
            $this->newLine();
        }
        
        // Display items expiring tomorrow
        if ($expiringTomorrow->count() > 0) {
            $this->info("ℹ {$expiringTomorrow->count()} items expiring TOMORROW:");
            foreach ($expiringTomorrow as $item) {
                $this->line("  - {$item->menu_name}");
            }
            $this->newLine();
        }
        
        // Summary table
        $this->table(
            ['Status', 'Count'],
            [
                ['Expired', $expired->count()],
                ['Expiring Today', $expiringToday->count()],
                ['Expiring Tomorrow', $expiringTomorrow->count()],
                ['Total Checked', $menuItems->count()],
            ]
        );
        
        // Log results
        Log::info('Freshness check completed', [
            'expired' => $expired->count(),
            'expiring_today' => $expiringToday->count(),
            'expiring_tomorrow' => $expiringTomorrow->count(),
            'total_checked' => $menuItems->count(),
        ]);
        
        // Send notifications if enabled
        if ($sendNotifications && $expired->count() > 0) {
            $this->warn('Notification feature not yet implemented');
            // TODO: Implement notification sending
            // This would typically send email/SMS to admin users
        }
        
        return Command::SUCCESS;
    }
}
