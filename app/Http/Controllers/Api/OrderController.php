<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use App\Services\OrderCreator;
use Illuminate\Http\Request;
use App\Models\MenuCategory;
use App\Models\Product;
use App\Models\RestaurantTable;

class OrderController extends Controller
{
    public function store(Request $request, OrderCreator $creator)
    {
        // ✅ UUID regex (sans dépendre de ramsey/uuid)
        $uuid = 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

        $data = $request->validate([
            'branch_id' => ['required', $uuid],
            'opened_by_user_id' => ['required', 'integer'], // FK users.id
            'channel' => ['required', 'in:DINE_IN,TAKEAWAY,DELIVERY'],
            'restaurant_table_id' => ['nullable', $uuid],
            'currency' => ['nullable', 'string', 'max:10'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', $uuid],
            'items.*.variant_id' => ['nullable', $uuid],
            'items.*.qty' => ['required', 'numeric', 'min:0.01'],

            'items.*.options' => ['nullable', 'array'],
            'items.*.options.*.option_item_id' => ['required', $uuid],
            'items.*.options.*.qty' => ['nullable', 'numeric', 'min:0.01'],
        ]);

        $branch = Branch::where('id', $data['branch_id'])->firstOrFail();

        // règle simple: DINE_IN => table requise
        if ($data['channel'] === Order::CHANNEL_DINE_IN && empty($data['restaurant_table_id'])) {
            return response()->json([
                'message' => 'restaurant_table_id is required for DINE_IN orders.'
            ], 422);
        }

        $order = $creator->create(
            $branch,
            (int) $data['opened_by_user_id'],
            $data['channel'],
            isset($data['restaurant_table_id']) ? $data['restaurant_table_id'] : null,
            $data['items'],
            isset($data['currency']) ? $data['currency'] : 'XAF'
        );

        return response()->json([
            'data' => $order,
        ], 201);
    }

    public function show(Order $order)
    {
        $order->load(['items.options', 'payments.method']);

        return response()->json([
            'data' => $order,
        ]);
    }
}
