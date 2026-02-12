<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RestaurantTable;
use App\Models\Branch;
use App\Models\MenuCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersUiController extends Controller
{
    // Page 1 : grille des tables
    // public function tables(Request $request)
    // {
    //     $branchId = $request->get('branch_id') ?: Branch::query()->value('id'); // MVP: 1ere branch
    //     $tables = RestaurantTable::where('branch_id', $branchId)
    //         ->where('is_active', 1)
    //         ->orderBy('table_number')
    //         ->get();

    //     return view('orders_ui.tables', compact('tables', 'branchId'));
    // }

    // Page 2 : écran de prise de commande pour une table
    public function takeTable(RestaurantTable $table, Request $request)
    {
        return view('orders_ui.take_table', [
            'table' => $table,
            'branchId' => $table->branch_id,
            'userId' => auth()->id() ?? 1, // si pas encore auth complète
        ]);
    }

    // AJAX : renvoie catégories + produits pour un service donné
    public function catalog(RestaurantTable $table, Request $request)
    {
        $service = strtoupper($request->get('service', 'CUISINE')); // CUISINE|BAR|PIZZERIA

        $categories = MenuCategory::where('branch_id', $table->branch_id)
            ->where('is_active', 1)
            ->where('service', $service)
            ->orderBy('sort_order')
            ->get(['id','name','service']);

        $products = Product::where('branch_id', $table->branch_id)
            ->where('is_active', 1)
            ->whereIn('menu_category_id', $categories->pluck('id'))
            ->orderBy('name')
            ->get(['id','name','base_price','menu_category_id']);

        return response()->json([
            'categories' => $categories,
            'products' => $products,
        ]);
    }
    public function tables(Request $request)
{
    $branchId = $request->get('branch_id') ?: Branch::query()->value('id');

    $zone = strtoupper($request->get('zone', 'INTERNO')); // default
    $q = trim((string) $request->get('q', ''));

    $zones = [
        'INTERNO' => 'Salle interne',
        'ESTERNO' => 'Salle externe',
        'MARCHEPIEDI' => 'Marciapiede',
        'ASPORTO' => 'À emporter',
        'PAY' => 'Paiement'
    ];


    $tablesQuery = RestaurantTable::query()
        ->where('branch_id', $branchId)
        ->where('is_active', 1);

    if (isset($zones[$zone]) && $zone !== 'PAY') {
        $tablesQuery->where('zone', $zone);
    }

    if ($q !== '') {
        // recherche simple sur le numéro
        $tablesQuery->where('table_number', 'like', "%{$q}%");
    }

    $tables = $tablesQuery->orderBy('table_number')->get();

    return view('orders_ui.tables', compact('tables', 'branchId', 'zones', 'zone', 'q'));
}

}
