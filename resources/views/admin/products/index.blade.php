@extends('layouts.admin')

@section('content')
<div class="admin-page">

  <div class="page-header">
    <h2>Gestion des produits</h2>

    <div class="header-actions">
      <a class="btn" href="{{ route('orders.ui.tables', ['branch_id' => $branchId]) }}">← Retour</a>
      <a class="btn primary" href="{{ route('admin.products.create', ['branch_id' => $branchId]) }}">+ Ajouter un produit</a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif

  {{-- Filtres --}}
  <form class="filters" method="GET" action="{{ route('admin.products.index') }}">
    <input type="hidden" name="branch_id" value="{{ $branchId }}">

    <div class="form-row">
      <label>Recherche</label>
      <input class="input" type="text" name="q" value="{{ $q }}" placeholder="Nom du produit..." />
    </div>

    <div class="form-row">
      <label>Catégorie</label>
      <select class="select" name="category_id">
        <option value="">Toutes</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}" @selected($categoryId===$c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-row">
      <label>Statut</label>
      <select class="select" name="active">
        <option value="">Tous</option>
        <option value="1" @selected((string)$active==='1')>Actifs</option>
        <option value="0" @selected((string)$active==='0')>Inactifs</option>
      </select>
    </div>

    <div class="form-row">
      <button class="btn primary" type="submit">Filtrer</button>
    </div>
  </form>

  {{-- Cartes produits --}}
  <div class="cards">
    @forelse($products as $p)
      <div class="card">
        <div class="card-top">
          <div class="thumb">
            @if(!empty($p->image_path))
              <img src="{{ asset('storage/'.$p->image_path) }}" alt="{{ $p->name }}">
            @else
              <span style="font-weight:900;color:#999;">🍽️</span>
            @endif
          </div>

          <div class="pinfo">
            <p class="pname">{{ $p->name }}</p>
            <div class="psub">
              Catégorie: {{ optional($p->category)->name ?? '—' }}
              @if($p->sku) · SKU: {{ $p->sku }} @endif
            </div>
          </div>

          @if($p->is_active)
            <span class="badge ok">Actif</span>
          @else
            <span class="badge off">Inactif</span>
          @endif
        </div>

        <div class="card-body">
          <div class="meta">
            <div>Prix: {{ number_format((float)$p->base_price, 0, ',', ' ') }} XAF</div>
            <div>Taxe: {{ optional($p->taxRule)->name ?? '—' }}</div>
          </div>

          @if($p->description)
            <div class="helper">{{ \Illuminate\Support\Str::limit($p->description, 90) }}</div>
          @else
            <div class="helper">Aucune description.</div>
          @endif
        </div>

        <div class="card-actions">
          <a class="btn" href="{{ route('admin.products.edit', $p) }}">Modifier</a>

          <form method="POST" action="{{ route('admin.products.toggle', $p) }}">
            @csrf
            @method('PATCH')
            <button class="btn danger" type="submit">
              {{ $p->is_active ? 'Désactiver' : 'Activer' }}
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="alert">Aucun produit trouvé.</div>
    @endforelse
  </div>

  <div class="pagination-wrap">
    {{ $products->links() }}
  </div>

</div>
@endsection
