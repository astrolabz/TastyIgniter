<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Igniter\Cart\Models\Menu;
use Illuminate\Http\Request;

class FishMenuController extends Controller
{
    /**
     * Get menu items with fish-specific filters
     */
    public function index(Request $request)
    {
        $query = Menu::where('menu_status', 1);

        // Filter by category
        if ($request->has('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // Filter by catch method
        if ($request->has('catch_method')) {
            $query->where('catch_method', $request->catch_method);
        }

        // Filter by origin region
        if ($request->has('origin_region')) {
            $query->where('origin_region', 'LIKE', '%' . $request->origin_region . '%');
        }

        // Filter by allergens (items WITHOUT specified allergens)
        if ($request->has('exclude_allergens')) {
            $allergenCodes = explode(',', $request->exclude_allergens);
            $query->whereDoesntHave('allergens', function ($q) use ($allergenCodes) {
                $q->whereIn('code', $allergenCodes);
            });
        }

        // Filter by freshness
        if ($request->has('freshness')) {
            switch ($request->freshness) {
                case 'today':
                    $query->whereDate('freshness_date', today());
                    break;
                case 'fresh':
                    $query->where('freshness_date', '>=', today());
                    break;
                case 'catch_of_day':
                    $query->where('is_catch_of_day', true);
                    break;
            }
        }

        // Search by name or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('menu_name', 'LIKE', "%{$search}%")
                  ->orWhere('menu_description', 'LIKE', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'menu_name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        $allowedSorts = ['menu_name', 'menu_price', 'freshness_date', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Eager load relationships
        $query->with(['categories', 'allergens', 'menu_options']);

        // Pagination
        $perPage = min($request->get('per_page', 20), 100);
        $items = $query->paginate($perPage);

        // Transform the data
        $items->getCollection()->transform(function ($item) {
            return [
                'menu_id' => $item->menu_id,
                'menu_name' => $item->menu_name,
                'menu_description' => $item->menu_description,
                'menu_price' => $item->menu_price,
                'menu_photo' => $item->menu_photo,
                'freshness_date' => $item->freshness_date,
                'freshness_status' => $item->getFreshnessStatusAttribute(),
                'is_fresh' => $item->getIsFreshAttribute(),
                'is_catch_of_day' => (bool) $item->is_catch_of_day,
                'catch_method' => $item->catch_method,
                'origin_region' => $item->origin_region,
                'storage_temp' => $item->storage_temp,
                'preparation_notes' => $item->preparation_notes,
                'allergens' => $item->allergens->map(function ($allergen) {
                    return [
                        'code' => $allergen->code,
                        'name' => $allergen->getLocalizedNameAttribute(),
                        'icon_class' => $allergen->icon_class,
                    ];
                }),
                'categories' => $item->categories->pluck('name'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $items,
            'filters_applied' => [
                'category_id' => $request->category_id,
                'catch_method' => $request->catch_method,
                'origin_region' => $request->origin_region,
                'exclude_allergens' => $request->exclude_allergens,
                'freshness' => $request->freshness,
                'search' => $request->search,
            ],
        ]);
    }

    /**
     * Get a single menu item with full details
     */
    public function show($menuId)
    {
        $item = Menu::with(['categories', 'allergens', 'menu_options', 'stockLedgers'])
            ->findOrFail($menuId);

        return response()->json([
            'success' => true,
            'data' => [
                'menu_id' => $item->menu_id,
                'menu_name' => $item->menu_name,
                'menu_description' => $item->menu_description,
                'menu_price' => $item->menu_price,
                'menu_photo' => $item->menu_photo,
                'menu_status' => $item->menu_status,
                'freshness_date' => $item->freshness_date,
                'freshness_status' => $item->getFreshnessStatusAttribute(),
                'is_fresh' => $item->getIsFreshAttribute(),
                'is_catch_of_day' => (bool) $item->is_catch_of_day,
                'catch_method' => $item->catch_method,
                'origin_region' => $item->origin_region,
                'storage_temp' => $item->storage_temp,
                'preparation_notes' => $item->preparation_notes,
                'current_stock' => $item->getCurrentStock(),
                'allergens' => $item->allergens->map(function ($allergen) {
                    return [
                        'id' => $allergen->id,
                        'code' => $allergen->code,
                        'name_en' => $allergen->name_en,
                        'name_nl' => $allergen->name_nl,
                        'localized_name' => $allergen->getLocalizedNameAttribute(),
                        'icon_class' => $allergen->icon_class,
                    ];
                }),
                'categories' => $item->categories,
                'options' => $item->menu_options,
            ],
        ]);
    }

    /**
     * Get catch of the day items
     */
    public function catchOfDay()
    {
        $items = Menu::where('menu_status', 1)
            ->where('is_catch_of_day', true)
            ->where('freshness_date', '>=', today())
            ->with(['categories', 'allergens'])
            ->get();

        $items->transform(function ($item) {
            return [
                'menu_id' => $item->menu_id,
                'menu_name' => $item->menu_name,
                'menu_description' => $item->menu_description,
                'menu_price' => $item->menu_price,
                'menu_photo' => $item->menu_photo,
                'freshness_date' => $item->freshness_date,
                'origin_region' => $item->origin_region,
                'catch_method' => $item->catch_method,
                'allergens' => $item->allergens->pluck('code'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }
}
