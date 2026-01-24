<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function recordPayment(
        Order $order,
        PaymentMethod $method,
        int $takenByUserId,
        float $amount,
        string $status = 'SUCCESS',
        ?string $providerReference = null,
        ?string $paidByCustomerName = null
    ): array {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be > 0');
        }

        if ((string) $method->branch_id !== (string) $order->branch_id) {
            throw new \RuntimeException('Payment method and order must belong to same branch.');
        }

        return DB::transaction(function () use ($order, $method, $takenByUserId, $amount, $status, $providerReference, $paidByCustomerName) {

            $paymentId = $this->uuidV4();
            $alreadyPaid = (float) DB::table('payments')
                ->where('order_id', $order->id)
                ->where('status', 'SUCCESS')
                    ->sum('amount');

            $grandTotal = (float) $order->grand_total;
            if ($status === 'SUCCESS' && ($alreadyPaid + $amount) > $grandTotal) {
                throw new \RuntimeException('Payment exceeds remaining balance.');
            }

            // INSERT payment (DB direct, stable)
            DB::table('payments')->insert([
                'id' => $paymentId,
                'branch_id' => $order->branch_id,
                'order_id' => $order->id,
                'payment_method_id' => $method->id,
                'status' => $status,
                'amount' => $amount,
                'currency' => $order->currency ? $order->currency : 'XAF',
                'provider_reference' => $providerReference,
                'paid_by_customer_name' => $paidByCustomerName,
                'taken_by_user_id' => $takenByUserId,
                'paid_at' => ($status === 'SUCCESS') ? now() : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // recalcul payé + update order si fully paid
            $amountPaid = 0.0;

            if ($status === 'SUCCESS') {
                $amountPaid = (float) DB::table('payments')
                    ->where('order_id', $order->id)
                    ->where('status', 'SUCCESS')
                    ->sum('amount');

                $grandTotal = (float) $order->grand_total;

                if ($amountPaid >= $grandTotal && $order->status !== Order::STATUS_PAID) {
                    DB::table('orders')
                        ->where('id', $order->id)
                        ->update([
                            'status' => Order::STATUS_PAID,
                            'closed_at' => now(),
                            'closed_by_user_id' => $takenByUserId,
                            'updated_at' => now(),
                        ]);
                }
            }

            return [
                'payment_id' => $paymentId,
                'amount_paid' => $amountPaid,
            ];
        });
    }

    private function uuidV4(): string
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
        $hex = bin2hex($data);

        return sprintf(
            '%s-%s-%s-%s-%s',
            substr($hex, 0, 8),
            substr($hex, 8, 4),
            substr($hex, 12, 4),
            substr($hex, 16, 4),
            substr($hex, 20, 12)
        );
    }
}
