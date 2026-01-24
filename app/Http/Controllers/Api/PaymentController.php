<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request, Order $order, PaymentService $paymentService)
    {
        // ✅ UUID regex (sans dépendre de ramsey/uuid)
        $uuid = 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

        $data = $request->validate([
            'payment_method_id' => ['required', $uuid],
            'taken_by_user_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric'], // validation >0 dans PaymentService
            'status' => ['nullable', 'in:SUCCESS,PENDING,FAILED,REFUNDED,PARTIALLY_REFUNDED,CANCELLED'],
            'provider_reference' => ['nullable', 'string', 'max:255'],
            'paid_by_customer_name' => ['nullable', 'string', 'max:255'],
        ]);

        // empêcher de payer une commande annulée/void
        if (in_array($order->status, [Order::STATUS_CANCELLED, Order::STATUS_VOID], true)) {
            return response()->json([
                'message' => 'Cannot pay a cancelled/void order.'
            ], 422);
        }

        $method = PaymentMethod::where('id', $data['payment_method_id'])->firstOrFail();

        // ✅ recordPayment retourne un array: ['payment_id' => ..., 'amount_paid' => ...]
        $result = $paymentService->recordPayment(
            $order,
            $method,
            (int) $data['taken_by_user_id'],
            (float) $data['amount'],
            isset($data['status']) ? $data['status'] : 'SUCCESS',
            isset($data['provider_reference']) ? $data['provider_reference'] : null,
            isset($data['paid_by_customer_name']) ? $data['paid_by_customer_name'] : null
        );

        // Rafraîchir l'état de la commande (sans load relations Eloquent)
        $order->refresh();

        // Paiements de la commande (DB direct => stable)
        $payments = DB::table('payments')
            ->where('order_id', $order->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $grandTotal = (float) $order->grand_total;
        $amountPaid = isset($result['amount_paid']) ? (float) $result['amount_paid'] : 0.0;

        return response()->json([
            'payment_id' => $result['payment_id'],
            'order_status' => $order->status,
            'amount_paid' => $amountPaid,
            'grand_total' => $grandTotal,
            'is_fully_paid' => ($amountPaid >= $grandTotal),
            'payments' => $payments,
        ], 201);
    }
}
