@extends('layouts.admin')

@section('title','Détail commande')

@section('content')
<div class="block">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;">
        <div>
            <h3 style="margin:0;">Commande {{ $order->order_number }}</h3>
            <div style="color:#666;font-size:13px;">
                {{ $order->channel }} — {{ $order->status }} — Ouverte: {{ \Carbon\Carbon::parse($order->opened_at)->format('d/m/Y H:i') }}
            </div>
        </div>
        <a href="{{ route('orders.index') }}" style="text-decoration:none;background:#eee;padding:8px 12px;border-radius:8px;">
            ← Retour
        </a>
    </div>
</div>

<div class="block">
    <h3>Articles</h3>

    @foreach($order->items as $it)
        <div style="border-bottom:1px solid #eee;padding:10px 0;">
            <div style="display:flex;justify-content:space-between;gap:10px;">
                <div>
                    <div style="font-weight:800;">
                        {{ $it->product_name_snapshot }}
                        @if($it->variant_name_snapshot)
                            <span style="font-weight:600;color:#666;">({{ $it->variant_name_snapshot }})</span>
                        @endif
                    </div>
                    <div style="font-size:13px;color:#666;">
                        Qty: {{ $it->qty }} • Prix: {{ number_format((float)$it->unit_price_snapshot,0,'.',' ') }} {{ $order->currency }}
                    </div>

                    @if($it->options->count())
                        <div style="margin-top:6px;font-size:13px;">
                            <strong>Options:</strong>
                            <ul style="margin:6px 0 0 18px;">
                                @foreach($it->options as $op)
                                    <li>
                                        {{ $op->option_group_name_snapshot }} — {{ $op->option_item_name_snapshot }}
                                        (+{{ number_format((float)$op->option_price_snapshot,0,'.',' ') }} {{ $order->currency }})
                                        x{{ $op->qty }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div style="text-align:right;">
                    <div style="font-weight:800;">
                        {{ number_format((float)$it->line_total,0,'.',' ') }} {{ $order->currency }}
                    </div>
                    <div style="font-size:12px;color:#666;">
                        Sous-total: {{ number_format((float)$it->line_subtotal,0,'.',' ') }} • Tax: {{ number_format((float)$it->line_tax,0,'.',' ') }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="block">
    <h3>Paiements</h3>

    @if($order->payments->count() === 0)
        <div style="color:#666;">Aucun paiement.</div>
    @else
        @foreach($order->payments as $p)
            <div style="display:flex;justify-content:space-between;border-bottom:1px solid #eee;padding:8px 0;">
                <div>
                    <div style="font-weight:700;">
                        {{ $p->method->name ?? 'Méthode' }} — {{ $p->status }}
                    </div>
                    <div style="font-size:12px;color:#666;">
                        Ref: {{ $p->provider_reference ?? '—' }} • {{ $p->paid_at }}
                    </div>
                </div>
                <div style="font-weight:800;">
                    {{ number_format((float)$p->amount,0,'.',' ') }} {{ $p->currency }}
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="block">
    <h3>Totaux</h3>
    <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;max-width:520px;">
        <div>Subtotal</div><div style="text-align:right;font-weight:800;">{{ number_format((float)$order->subtotal,0,'.',' ') }} {{ $order->currency }}</div>
        <div>Taxes</div><div style="text-align:right;font-weight:800;">{{ number_format((float)$order->taxes_total,0,'.',' ') }} {{ $order->currency }}</div>
        <div>Remises</div><div style="text-align:right;font-weight:800;">{{ number_format((float)$order->discounts_total,0,'.',' ') }} {{ $order->currency }}</div>
        <div><strong>Total</strong></div><div style="text-align:right;font-weight:900;">{{ number_format((float)$order->grand_total,0,'.',' ') }} {{ $order->currency }}</div>
    </div>
</div>
@endsection
