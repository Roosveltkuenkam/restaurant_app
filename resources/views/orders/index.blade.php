@extends('layouts.admin')

@section('title','Commandes')

@section('content')
<div class="block">
    <h3>Commandes</h3>
        <div style="margin:10px 0;">
<a href="{{ route('orders.ui.tables') }}" style="display:inline-block;text-decoration:none;background:#111;color:#fff;padding:8px 12px;border-radius:10px;">
            + Nouvelle commande
        </a>
        </div>

    <form method="GET" action="{{ route('orders.index') }}" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:12px;">
        <select name="status" style="padding:8px;border:1px solid #ddd;border-radius:8px;">
            <option value="">Statut (tous)</option>
            @foreach(['OPEN','PAID','CANCELLED','VOID','CLOSED'] as $st)
                <option value="{{ $st }}" @selected(($filters['status'] ?? '') === $st)>{{ $st }}</option>
            @endforeach
        </select>

        <select name="channel" style="padding:8px;border:1px solid #ddd;border-radius:8px;">
            <option value="">Canal (tous)</option>
            @foreach(['DINE_IN','TAKEAWAY','DELIVERY'] as $ch)
                <option value="{{ $ch }}" @selected(($filters['channel'] ?? '') === $ch)>{{ $ch }}</option>
            @endforeach
        </select>

        <input type="date" name="date" value="{{ $filters['date'] ?? '' }}"
               style="padding:8px;border:1px solid #ddd;border-radius:8px;">

        <input type="text" name="branch_id" placeholder="branch_id (optionnel)"
               value="{{ $filters['branch_id'] ?? '' }}"
               style="padding:8px;border:1px solid #ddd;border-radius:8px;min-width:280px;">

        <button type="submit" style="padding:8px 12px;border-radius:8px;background:#111;color:#fff;border:none;cursor:pointer;">
            Filtrer
        </button>
        <a href="{{ route('orders.index') }}" style="padding:8px 12px;border-radius:8px;background:#eee;color:#111;text-decoration:none;">
            Reset
        </a>
    </form>

    <div style="overflow:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="text-align:left;border-bottom:1px solid #eee;">
                    <th style="padding:10px;">N°</th>
                    <th style="padding:10px;">Canal</th>
                    <th style="padding:10px;">Statut</th>
                    <th style="padding:10px;">Total</th>
                    <th style="padding:10px;">Ouvert</th>
                    <th style="padding:10px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $o)
                    <tr style="border-bottom:1px solid #f2f2f2;">
                        <td style="padding:10px;font-weight:700;">{{ $o->order_number }}</td>
                        <td style="padding:10px;">{{ $o->channel }}</td>
                        <td style="padding:10px;">{{ $o->status }}</td>
                        <td style="padding:10px;">{{ number_format((float)$o->grand_total, 0, '.', ' ') }} {{ $o->currency }}</td>
                        <td style="padding:10px;">{{ \Carbon\Carbon::parse($o->opened_at)->format('d/m/Y H:i') }}</td>
                        <td style="padding:10px;">
                            <a href="{{ route('orders.show',$o) }}" style="text-decoration:none;font-weight:700;">
                                Voir →
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="padding:14px;color:#666;">Aucune commande trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px;">
        {{ $orders->links() }}
    </div>
</div>
@endsection
