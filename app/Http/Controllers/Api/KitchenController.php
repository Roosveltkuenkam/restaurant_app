<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index(Request $request)
    {
        $uuid = 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

        $data = $request->validate([
            'branch_id' => ['required', $uuid],
            'status' => ['nullable', 'in:QUEUED,IN_PROGRESS,READY,SERVED'],
            'order_id' => ['nullable', $uuid],
            'limit' => ['nullable', 'integer', 'min:1', 'max:200'],
        ]);

        $q = OrderItem::query()
            ->whereHas('order', function ($qq) use ($data) {
                $qq->where('branch_id', $data['branch_id']);
            })
            ->with(['order' => function ($qq) {
                $qq->select('id', 'order_number', 'channel', 'status', 'opened_at', 'restaurant_table_id');
            }, 'options'])
            ->orderBy('created_at', 'asc');

        if (!empty($data['status'])) {
            $q->where('kitchen_status', $data['status']);
        } else {
            // par défaut: tout ce qui est “en cuisine”
            $q->whereIn('kitchen_status', ['QUEUED', 'IN_PROGRESS', 'READY']);
        }

        if (!empty($data['order_id'])) {
            $q->where('order_id', $data['order_id']);
        }

        $limit = (int) ($data['limit'] ?? 100);

        $items = $q->limit($limit)->get([
            'id',
            'order_id',
            'product_id',
            'product_variant_id',
            'product_name_snapshot',
            'variant_name_snapshot',
            'qty',
            'kitchen_notes',
            'kitchen_status',
            'created_at',
        ]);

        return response()->json([
            'data' => $items,
        ]);
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $data = $request->validate([
            'kitchen_status' => ['required', 'in:QUEUED,IN_PROGRESS,READY,SERVED'],
            'kitchen_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $orderItem->kitchen_status = $data['kitchen_status'];

        // si on envoie des notes cuisine, on remplace
        if (array_key_exists('kitchen_notes', $data)) {
            $orderItem->kitchen_notes = $data['kitchen_notes'];
        }

        $orderItem->save();

        $order = $orderItem->order()->first(); // récupère la commande

// si tous les items de la commande sont READY ou SERVED => commande READY
$remaining = \App\Models\OrderItem::where('order_id', $order->id)
    ->whereNotIn('kitchen_status', ['READY', 'SERVED'])
    ->count();

if ($remaining === 0 && in_array($order->status, [\App\Models\Order::STATUS_OPEN, \App\Models\Order::STATUS_PAID], true)) {
    $order->status = \App\Models\Order::STATUS_READY; // READY_TO_SERVE
    $order->save();
}


        return response()->json([
            'data' => $orderItem->fresh(['options']),
        ]);
    }

    public function queue(Request $request)
{
    $uuid = 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

    $data = $request->validate([
        'branch_id' => ['required', $uuid],
        'only_open_orders' => ['nullable', 'boolean'],
        'status' => ['nullable', 'in:QUEUED,IN_PROGRESS,READY,SERVED'],
        'limit_orders' => ['nullable', 'integer', 'min:1', 'max:200'],
    ]);

    $kdsStatuses = ['QUEUED', 'IN_PROGRESS', 'READY'];
    if (!empty($data['status'])) {
        $kdsStatuses = [$data['status']];
    }

    $limitOrders = (int) ($data['limit_orders'] ?? 50);

    // 1) récupérer les order_ids qui ont des items cuisine
    $orderIds = \App\Models\OrderItem::query()
        ->whereIn('kitchen_status', $kdsStatuses)
        ->whereHas('order', function ($q) use ($data) {
            $q->where('branch_id', $data['branch_id']);
            if (!empty($data['only_open_orders'])) {
                $q->whereIn('status', [\App\Models\Order::STATUS_OPEN, \App\Models\Order::STATUS_PAID]);
            }
        })
        ->select('order_id')
        ->distinct()
        ->orderBy('order_id')
        ->limit($limitOrders)
        ->pluck('order_id');

    // 2) charger commandes + items + options
    $orders = \App\Models\Order::query()
        ->whereIn('id', $orderIds)
        ->select('id','order_number','channel','status','opened_at','restaurant_table_id')
        ->orderBy('opened_at','asc')
        ->get()
        ->keyBy('id');

    $items = \App\Models\OrderItem::query()
        ->whereIn('order_id', $orderIds)
        ->whereIn('kitchen_status', $kdsStatuses)
        ->with('options')
        ->orderBy('created_at','asc')
        ->get([
            'id','order_id',
            'product_id','product_variant_id',
            'product_name_snapshot','variant_name_snapshot',
            'qty','kitchen_notes','kitchen_status','created_at'
        ])
        ->groupBy('order_id');

    // 3) construire la réponse
    $out = [];
    foreach ($orderIds as $oid) {
        $o = $orders->get($oid);
        if (!$o) continue;

        $out[] = [
            'order' => $o,
            'items' => $items->get($oid, []),
        ];
    }

    return response()->json(['data' => $out]);
}

}
