<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_item_id',
        'change',
        'reason',
        'reference',
        'notes',
    ];

    protected $casts = [
        'change' => 'decimal:2',
    ];

    /**
     * Get the menu item that owns the stock ledger entry
     */
    public function menuItem()
    {
        return $this->belongsTo(\Igniter\Cart\Models\Menu::class, 'menu_item_id', 'menu_id');
    }

    /**
     * Scope to filter by reason
     */
    public function scopeByReason($query, $reason)
    {
        return $query->where('reason', $reason);
    }

    /**
     * Scope to filter by menu item
     */
    public function scopeByMenuItem($query, $menuItemId)
    {
        return $query->where('menu_item_id', $menuItemId);
    }

    /**
     * Get current stock level for a menu item
     */
    public static function getCurrentStock($menuItemId)
    {
        return static::where('menu_item_id', $menuItemId)->sum('change');
    }

    /**
     * Add stock for a menu item
     */
    public static function addStock($menuItemId, $quantity, $reason = 'restocking', $reference = null, $notes = null)
    {
        return static::create([
            'menu_item_id' => $menuItemId,
            'change' => abs($quantity),
            'reason' => $reason,
            'reference' => $reference,
            'notes' => $notes,
        ]);
    }

    /**
     * Deduct stock for a menu item
     */
    public static function deductStock($menuItemId, $quantity, $reason = 'order', $reference = null, $notes = null)
    {
        return static::create([
            'menu_item_id' => $menuItemId,
            'change' => -abs($quantity),
            'reason' => $reason,
            'reference' => $reference,
            'notes' => $notes,
        ]);
    }
}
