<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemOption;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\OptionItem;
use Illuminate\Support\Facades\DB;

class OrderCreator
{
    /**
     * Crée une commande (OPEN) + items/options avec snapshots et calcule les totaux.
     *
     * $items structure:
     * [
     *   [
     *     'product_id' => 'uuid',
     *     'variant_id' => 'uuid|null',
     *     'qty' => 2,
     *     'options' => [
     *        ['option_item_id' => 'uuid', 'qty' => 1],
     *     ]
     *   ]
     * ]
     */
    public function create(
        Branch $branch,
        int $openedByUserId,
        string $channel,
        ?string $restaurantTableId,
        array $items,
        string $currency = 'XAF'
    ): Order {
        return DB::transaction(function () use ($branch, $openedByUserId, $channel, $restaurantTableId, $items, $currency) {

            $order = new Order();
            $order->branch_id = $branch->id;
            $order->order_number = $this->generateOrderNumber($branch);
            $order->channel = $channel;
            $order->status = Order::STATUS_OPEN;
            $order->restaurant_table_id = $restaurantTableId;
            $order->opened_by_user_id = $openedByUserId;
            $order->opened_at = now();
            $order->currency = $currency;

            // totaux init
            $order->subtotal = 0;
            $order->discounts_total = 0;
            $order->taxes_total = 0;
            $order->service_fee = 0;
            $order->delivery_fee = 0;
            $order->grand_total = 0;

            $order->save();

            foreach ($items as $it) {
                /** @var Product $product */
                $product = Product::where('branch_id', $branch->id)
                    ->where('id', $it['product_id'])
                    ->firstOrFail();

                $variant = null;
                if (!empty($it['variant_id'])) {
                    $variant = ProductVariant::where('product_id', $product->id)
                        ->where('id', $it['variant_id'])
                        ->firstOrFail();
                }

                $qty = (float) ($it['qty'] ?? 1);

                // prix snapshot
                $variantDelta = $variant ? (float) $variant->price_delta : 0.0;
                $unitPrice = (float) $product->base_price + $variantDelta;

                // options snapshot (somme suppléments)
                $optionsTotal = 0;
                $options = $it['options'] ?? [];

                foreach ($options as $opt) {
                    $oi = OptionItem::with('group')
                        ->where('id', $opt['option_item_id'])
                        ->firstOrFail();

                    $oqty = (float) ($opt['qty'] ?? 1);
                    $optionsTotal += (float) $oi->price * $oqty;
                }

                // taxe snapshot (si tax_rule sur produit)
                $taxRate = 0.0;
                if ($product->taxRule) {
                    $taxRate = (float) $product->taxRule->rate_percent;
                }

                $lineSubtotal = ($unitPrice + $optionsTotal) * $qty;
                $lineTax = $lineSubtotal * ($taxRate / 100.0);
                $lineTotal = $lineSubtotal + $lineTax;

                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_variant_id = $variant ? $variant->id : null;
                $orderItem->variant_name_snapshot = $variant ? $variant->name : null;

                $orderItem->product_name_snapshot = $product->name;
                $orderItem->variant_name_snapshot = $variant ? $variant->name : null;

                $orderItem->unit_price_snapshot = $unitPrice; // sans options
                $orderItem->tax_rate_snapshot = $taxRate;

                $orderItem->qty = $qty;
                $orderItem->line_subtotal = $lineSubtotal;
                $orderItem->line_tax = $lineTax;
                $orderItem->line_total = $lineTotal;

                $orderItem->kitchen_status = 'QUEUED';
                $orderItem->save();

                // enregistrer snapshot options
                foreach ($options as $opt) {
                    $oi = OptionItem::with('group')
                        ->where('id', $opt['option_item_id'])
                        ->firstOrFail();

                    $o = new OrderItemOption();
                    $o->order_item_id = $orderItem->id;
                    $o->option_group_name_snapshot = $oi->group->name;
                    $o->option_item_name_snapshot = $oi->name;
                    $o->option_price_snapshot = (float) $oi->price;
                    $o->qty = (float) ($opt['qty'] ?? 1);
                    $o->save();
                }
            }

            // calcul totaux à partir des items
            $order->recalculateTotals();

            return $order->fresh(['items.options']);
        });
    }

    private function generateOrderNumber(Branch $branch): string
    {
        // Exemple simple : DS-YYYYMMDD-XXXX
        $prefix = 'DS-' . now()->format('Ymd') . '-';

        $countToday = Order::where('branch_id', $branch->id)
            ->whereDate('opened_at', now()->toDateString())
            ->count();

        return $prefix . str_pad((string) ($countToday + 1), 4, '0', STR_PAD_LEFT);
    }
}
