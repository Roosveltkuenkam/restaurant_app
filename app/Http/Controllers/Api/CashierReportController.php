<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierReportController extends Controller
{
    public function payments(Request $request)
    {
        $uuid = 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

        $data = $request->validate([
            'branch_id' => ['required', $uuid],

            // filtres optionnels
            'date_from' => ['nullable', 'date'], // YYYY-MM-DD
            'date_to' => ['nullable', 'date'],   // YYYY-MM-DD
            'status' => ['nullable', 'in:SUCCESS,PENDING,FAILED,REFUNDED,PARTIALLY_REFUNDED,CANCELLED'],
            'payment_method_id' => ['nullable', $uuid],
            'taken_by_user_id' => ['nullable', 'integer'],

            'limit' => ['nullable', 'integer', 'min:1', 'max:500'],
        ]);

        $q = DB::table('payments as p')
            ->join('payment_methods as pm', 'pm.id', '=', 'p.payment_method_id')
            ->leftJoin('users as u', 'u.id', '=', 'p.taken_by_user_id')
            ->join('orders as o', 'o.id', '=', 'p.order_id')
            ->where('p.branch_id', $data['branch_id'])
            ->select([
                'p.id',
                'p.paid_at',
                'p.status',
                'p.amount',
                'p.currency',
                'p.provider_reference',
                'p.paid_by_customer_name',
                'p.taken_by_user_id',
                'pm.name as payment_method_name',
                'p.payment_method_id',
                'p.order_id',
                'o.order_number',
                'o.channel',
                'o.status as order_status',
                'u.name as cashier_name',
            ])
            ->orderBy('p.paid_at', 'desc');

        if (!empty($data['status'])) {
            $q->where('p.status', $data['status']);
        }

        if (!empty($data['payment_method_id'])) {
            $q->where('p.payment_method_id', $data['payment_method_id']);
        }

        if (!empty($data['taken_by_user_id'])) {
            $q->where('p.taken_by_user_id', (int) $data['taken_by_user_id']);
        }

        if (!empty($data['date_from'])) {
            $q->whereDate('p.paid_at', '>=', $data['date_from']);
        }

        if (!empty($data['date_to'])) {
            $q->whereDate('p.paid_at', '<=', $data['date_to']);
        }

        $limit = (int) ($data['limit'] ?? 200);

        return response()->json([
            'data' => $q->limit($limit)->get(),
        ]);
    }

    public function summary(Request $request)
    {
        $uuid = 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

        $data = $request->validate([
            'branch_id' => ['required', $uuid],
            'date_from' => ['nullable', 'date'], // YYYY-MM-DD
            'date_to' => ['nullable', 'date'],   // YYYY-MM-DD
            'status' => ['nullable', 'in:SUCCESS,PENDING,FAILED,REFUNDED,PARTIALLY_REFUNDED,CANCELLED'],
        ]);

        // par défaut: SUCCESS (ce qui est réellement encaissé)
        $status = $data['status'] ?? 'SUCCESS';

        $base = DB::table('payments as p')
            ->where('p.branch_id', $data['branch_id'])
            ->where('p.status', $status);

        if (!empty($data['date_from'])) {
            $base->whereDate('p.paid_at', '>=', $data['date_from']);
        }
        if (!empty($data['date_to'])) {
            $base->whereDate('p.paid_at', '<=', $data['date_to']);
        }

        // total global
        $total = (clone $base)->sum('p.amount');
        $count = (clone $base)->count();

        // totaux par jour
        $byDay = (clone $base)
            ->selectRaw('DATE(p.paid_at) as day, COUNT(*) as payments_count, SUM(p.amount) as total_amount')
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        // totaux par méthode
        $byMethod = (clone $base)
            ->join('payment_methods as pm', 'pm.id', '=', 'p.payment_method_id')
            ->selectRaw('pm.id as payment_method_id, pm.name as payment_method_name, COUNT(*) as payments_count, SUM(p.amount) as total_amount')
            ->groupBy('pm.id', 'pm.name')
            ->orderBy('total_amount', 'desc')
            ->get();

        // totaux par caissier (taken_by_user_id)
        $byCashier = (clone $base)
            ->leftJoin('users as u', 'u.id', '=', 'p.taken_by_user_id')
            ->selectRaw('p.taken_by_user_id as cashier_user_id, u.name as cashier_name, COUNT(*) as payments_count, SUM(p.amount) as total_amount')
            ->groupBy('p.taken_by_user_id', 'u.name')
            ->orderBy('total_amount', 'desc')
            ->get();

        return response()->json([
            'filters' => [
                'branch_id' => $data['branch_id'],
                'date_from' => $data['date_from'] ?? null,
                'date_to' => $data['date_to'] ?? null,
                'status' => $status,
            ],
            'totals' => [
                'payments_count' => (int) $count,
                'total_amount' => (float) $total,
            ],
            'by_day' => $byDay,
            'by_method' => $byMethod,
            'by_cashier' => $byCashier,
        ]);
    }
}
