<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockLedger;
use Igniter\Cart\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Display current stock for a menu item
     */
    public function show($menuItemId)
    {
        $menuItem = Menu::findOrFail($menuItemId);
        
        $currentStock = StockLedger::getCurrentStock($menuItemId);
        
        return response()->json([
            'success' => true,
            'data' => [
                'menu_item_id' => $menuItemId,
                'menu_name' => $menuItem->menu_name,
                'current_stock' => $currentStock,
                'freshness_date' => $menuItem->freshness_date,
                'is_fresh' => $menuItem->getIsFreshAttribute(),
                'freshness_status' => $menuItem->getFreshnessStatusAttribute(),
            ],
        ]);
    }

    /**
     * Update stock for a menu item
     */
    public function update(Request $request, $menuItemId)
    {
        $validator = Validator::make($request->all(), [
            'change' => 'required|numeric',
            'reason' => 'required|in:order,manual,spoilage,restocking',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $menuItem = Menu::findOrFail($menuItemId);
        
        try {
            if ($request->change > 0) {
                StockLedger::addStock(
                    $menuItemId,
                    abs($request->change),
                    $request->reason,
                    $request->reference,
                    $request->notes
                );
            } else {
                StockLedger::deductStock(
                    $menuItemId,
                    abs($request->change),
                    $request->reason,
                    $request->reference,
                    $request->notes
                );
            }
            
            $newStock = StockLedger::getCurrentStock($menuItemId);
            
            return response()->json([
                'success' => true,
                'message' => 'Stock updated successfully',
                'data' => [
                    'menu_item_id' => $menuItemId,
                    'previous_stock' => $newStock - $request->change,
                    'change' => $request->change,
                    'current_stock' => $newStock,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stock',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get stock history for a menu item
     */
    public function history($menuItemId)
    {
        $menuItem = Menu::findOrFail($menuItemId);
        
        $ledger = StockLedger::byMenuItem($menuItemId)
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        return response()->json([
            'success' => true,
            'data' => [
                'menu_item_id' => $menuItemId,
                'menu_name' => $menuItem->menu_name,
                'current_stock' => StockLedger::getCurrentStock($menuItemId),
                'history' => $ledger,
            ],
        ]);
    }

    /**
     * Batch update stock for multiple items
     */
    public function batchUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'updates' => 'required|array',
            'updates.*.menu_item_id' => 'required|exists:menus,menu_id',
            'updates.*.change' => 'required|numeric',
            'updates.*.reason' => 'required|in:order,manual,spoilage,restocking',
            'updates.*.reference' => 'nullable|string|max:255',
            'updates.*.notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $results = [];
        $errors = [];

        foreach ($request->updates as $update) {
            try {
                if ($update['change'] > 0) {
                    StockLedger::addStock(
                        $update['menu_item_id'],
                        abs($update['change']),
                        $update['reason'],
                        $update['reference'] ?? null,
                        $update['notes'] ?? null
                    );
                } else {
                    StockLedger::deductStock(
                        $update['menu_item_id'],
                        abs($update['change']),
                        $update['reason'],
                        $update['reference'] ?? null,
                        $update['notes'] ?? null
                    );
                }
                
                $results[] = [
                    'menu_item_id' => $update['menu_item_id'],
                    'success' => true,
                    'current_stock' => StockLedger::getCurrentStock($update['menu_item_id']),
                ];
            } catch (\Exception $e) {
                $errors[] = [
                    'menu_item_id' => $update['menu_item_id'],
                    'error' => $e->getMessage(),
                ];
            }
        }

        return response()->json([
            'success' => count($errors) === 0,
            'message' => count($errors) === 0 
                ? 'All stock updates successful' 
                : 'Some stock updates failed',
            'results' => $results,
            'errors' => $errors,
        ], count($errors) > 0 ? 207 : 200); // 207 Multi-Status
    }
}
