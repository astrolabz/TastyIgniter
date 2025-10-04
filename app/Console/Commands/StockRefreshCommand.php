<?php

namespace App\Console\Commands;

use App\Models\StockLedger;
use Igniter\Cart\Models\Menu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class StockRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:refresh {--dry-run : Run without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset daily stock levels for all menu items';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting daily stock refresh...');
        
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('Running in DRY RUN mode - no changes will be made');
        }

        // Get all active menu items
        $menuItems = Menu::where('menu_status', 1)->get();
        
        $this->info("Processing {$menuItems->count()} menu items...");
        
        $updated = 0;
        $errors = 0;

        foreach ($menuItems as $item) {
            try {
                $currentStock = StockLedger::getCurrentStock($item->menu_id);
                
                // Log the refresh operation
                if (!$dryRun) {
                    StockLedger::create([
                        'menu_item_id' => $item->menu_id,
                        'change' => 0,
                        'reason' => 'restocking',
                        'reference' => 'Daily stock refresh',
                        'notes' => "Stock refresh at {$currentStock} units",
                    ]);
                    
                    $updated++;
                    $this->line("✓ {$item->menu_name}: Current stock {$currentStock}");
                } else {
                    $this->line("[DRY RUN] Would refresh {$item->menu_name}: Current stock {$currentStock}");
                }
                
            } catch (\Exception $e) {
                $errors++;
                $this->error("✗ Error processing {$item->menu_name}: {$e->getMessage()}");
                Log::error("Stock refresh error for menu item {$item->menu_id}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        $this->newLine();
        
        if ($dryRun) {
            $this->info("DRY RUN complete. Would have updated {$menuItems->count()} items.");
        } else {
            $this->info("Stock refresh complete!");
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Updated', $updated],
                    ['Errors', $errors],
                    ['Total', $menuItems->count()],
                ]
            );
            
            Log::info('Daily stock refresh completed', [
                'updated' => $updated,
                'errors' => $errors,
                'total' => $menuItems->count(),
            ]);
        }

        return $errors > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
