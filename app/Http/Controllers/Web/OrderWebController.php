<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\MenuCategory;
use App\Models\Product;
use App\Models\RestaurantTable;
use App\Services\OrderCreator;

class OrderWebController extends Controller
{
    public function index(Request $request)
    {
        $q = Order::query();

        // filtres
        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }
        if ($request->filled('channel')) {
            $q->where('channel', $request->string('channel'));
        }
        if ($request->filled('date')) {
            $q->whereDate('opened_at', $request->date('date'));
        }

        // si tu veux filtrer par branch (important multi-branches)
        if ($request->filled('branch_id')) {
            $q->where('branch_id', $request->string('branch_id'));
        }

        $orders = $q->orderByDesc('opened_at')
            ->paginate(12)
            ->withQueryString();

        return view('orders.index', [
            'user' => session('user'),
            'orders' => $orders,
            'filters' => $request->only(['status','channel','date','branch_id']),
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['items.options', 'payments.method']);

        return view('orders.show', [
            'user' => session('user'),
            'order' => $order,
        ]);
    }
    
public function create()
{
    $branches = Branch::orderBy('name')->get(['id','name']);
    $tables = RestaurantTable::orderBy('table_number')->get(['id','table_number','branch_id']);
    $products = Product::with(['optionGroups.items'])
        ->where('is_active', 1)
        ->orderBy('name')
        ->get(['id','branch_id','name','base_price']);

    return view('orders.create', [
        'user' => session('user'),
        'branches' => $branches,
        'tables' => $tables,
        'products' => $products,
    ]);
}

public function store(Request $request, OrderCreator $creator)
{
    $uuid = 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

    $data = $request->validate([
        'branch_id' => ['required', $uuid],
        'channel' => ['required', 'in:DINE_IN,TAKEAWAY,DELIVERY'],
        'restaurant_table_id' => ['nullable', $uuid],
        'currency' => ['nullable', 'string', 'max:10'],

        'items' => ['required','array','min:1'],
        'items.*.product_id' => ['required', $uuid],
        'items.*.qty' => ['required','numeric','min:0.01'],

        // options (facultatif)
        'items.*.options' => ['nullable','array'],
        'items.*.options.*.option_item_id' => ['required', $uuid],
        'items.*.options.*.qty' => ['nullable','numeric','min:0.01'],
    ]);

    // règle DINE_IN => table obligatoire
    if ($data['channel'] === \App\Models\Order::CHANNEL_DINE_IN && empty($data['restaurant_table_id'])) {
        return back()->withErrors(['restaurant_table_id' => 'Table requise pour DINE_IN'])->withInput();
    }

    $branch = Branch::findOrFail($data['branch_id']);

    $openedByUserId = (int) (session('user.id') ?? session('user')['id'] ?? 1);

    $order = $creator->create(
        $branch,
        $openedByUserId,
        $data['channel'],
        $data['restaurant_table_id'] ?? null,
        $data['items'],
        $data['currency'] ?? 'XAF'
    );

    return redirect()->route('orders.show', $order)->with('success', 'Commande créée.');
}

}

