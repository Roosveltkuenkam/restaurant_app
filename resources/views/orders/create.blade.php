@extends('layouts.admin')

@section('title','Créer commande')

@section('content')
<div class="block">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;">
        <h3 style="margin:0;">Créer une commande</h3>
        <a href="{{ route('orders.index') }}" style="text-decoration:none;background:#eee;padding:8px 12px;border-radius:8px;">
            ← Retour
        </a>
    </div>

    @if($errors->any())
        <div style="margin-top:10px;background:#fee2e2;padding:10px;border-radius:10px;">
            <strong>Erreurs :</strong>
            <ul style="margin:6px 0 0 18px;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('orders.store') }}" style="margin-top:14px;">
        @csrf

        <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;">
            <div>
                <label style="font-weight:700;font-size:13px;">Branch</label>
                <select name="branch_id" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
                    <option value="">-- choisir --</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" @selected(old('branch_id')===$b->id)>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="font-weight:700;font-size:13px;">Channel</label>
                <select name="channel" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
                    @foreach(['TAKEAWAY','DINE_IN','DELIVERY'] as $ch)
                        <option value="{{ $ch }}" @selected(old('channel','TAKEAWAY')===$ch)>{{ $ch }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="font-weight:700;font-size:13px;">Table (si DINE_IN)</label>
                <select name="restaurant_table_id" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
                    <option value="">-- aucune --</option>
                    @foreach($tables as $t)
                        <option value="{{ $t->id }}" @selected(old('restaurant_table_id')===$t->id)>
                            {{ $t->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="font-weight:700;font-size:13px;">Currency</label>
                <input name="currency" value="{{ old('currency','XAF') }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
            </div>
        </div>

        <hr style="margin:16px 0;border:none;border-top:1px solid #eee;">

        <h3 style="margin:0 0 10px 0;">Items</h3>

        {{-- MVP: 1 item obligatoire (on fera multi-items après) --}}
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:12px;">
            <div>
                <label style="font-weight:700;font-size:13px;">Produit</label>
                <select name="items[0][product_id]" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
                    <option value="">-- choisir --</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" @selected(old('items.0.product_id')===$p->id)>
                            {{ $p->name }} — {{ number_format((float)$p->base_price,0,'.',' ') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="font-weight:700;font-size:13px;">Quantité</label>
                <input type="number" step="0.01" min="0.01" name="items[0][qty]"
                       value="{{ old('items.0.qty',1) }}"
                       style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
            </div>
        </div>

        <div style="margin-top:12px;">
            <label style="font-weight:700;font-size:13px;">Option item id (test rapide)</label>
            <input name="items[0][options][0][option_item_id]" placeholder="uuid option_item (facultatif)"
                   value="{{ old('items.0.options.0.option_item_id') }}"
                   style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;">
            <div style="display:flex;gap:12px;margin-top:8px;">
                <input type="number" step="0.01" min="0.01" name="items[0][options][0][qty]"
                       value="{{ old('items.0.options.0.qty',1) }}"
                       style="width:160px;padding:10px;border:1px solid #ddd;border-radius:10px;">
                <div style="color:#666;font-size:12px;display:flex;align-items:center;">
                    (On rendra ça “checkbox options” propre juste après)
                </div>
            </div>
        </div>

        <button type="submit"
                style="margin-top:16px;padding:10px 14px;border-radius:10px;background:#111;color:#fff;border:none;cursor:pointer;">
            Créer la commande
        </button>
    </form>
</div>
@endsection
