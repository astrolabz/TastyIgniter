<?php

namespace App\Providers;

use App\Models\AllergenLabel;
use App\Models\StockLedger;
use Igniter\Cart\Models\Menu;
use Illuminate\Support\ServiceProvider;

class MenuItemExtensionProvider extends ServiceProvider
{
    public function boot(): void
    {
        Menu::extend(function ($model) {
            // Add allergens relationship
            $model->belongsToMany['allergens'] = [
                AllergenLabel::class,
                'table' => 'menu_item_allergen',
                'foreignKey' => 'menu_item_id',
                'otherKey' => 'allergen_label_id',
            ];

            // Add stock ledgers relationship
            $model->hasMany['stockLedgers'] = [
                StockLedger::class,
                'foreignKey' => 'menu_item_id',
            ];

            // Add accessor for current stock
            $model->addDynamicMethod('getCurrentStock', function () use ($model) {
                return StockLedger::getCurrentStock($model->menu_id);
            });

            // Add accessor for is fresh
            $model->addDynamicMethod('getIsFreshAttribute', function () use ($model) {
                if (!$model->freshness_date) {
                    return false;
                }
                $freshnessDate = \Carbon\Carbon::parse($model->freshness_date);
                return $freshnessDate->isToday() || $freshnessDate->isFuture();
            });

            // Add accessor for freshness status
            $model->addDynamicMethod('getFreshnessStatusAttribute', function () use ($model) {
                if (!$model->freshness_date) {
                    return 'unknown';
                }
                $freshnessDate = \Carbon\Carbon::parse($model->freshness_date);
                if ($freshnessDate->isToday()) {
                    return 'today';
                }
                if ($freshnessDate->isYesterday()) {
                    return 'yesterday';
                }
                if ($freshnessDate->isFuture()) {
                    return 'future';
                }
                return 'expired';
            });
        });
    }

    public function register(): void
    {
        //
    }
}
