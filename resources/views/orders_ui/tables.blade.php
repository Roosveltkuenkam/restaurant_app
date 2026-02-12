@extends('layouts.admin')

@section('content')
<div class="orders-page">

  {{-- En-tête --}}
  <div class="orders-header">
    <h2>Commandes</h2>

    <a class="btn-add"
       href="{{ route('orders.ui.tables', ['branch_id'=>$branchId]) }}">
       + Nouvelle commande
    </a>
  </div>

  {{-- Recherche --}}
  <form method="GET"
        action="{{ route('orders.ui.tables') }}"
        class="orders-search">

    <input type="hidden" name="branch_id" value="{{ $branchId }}">
    <input type="hidden" name="zone" value="{{ $zone }}">

    <input type="text"
           name="q"
           value="{{ $q }}"
           placeholder="Rechercher une table..." />

    <button type="submit" class="btn-search">
      Rechercher
    </button>
  </form>

  {{-- Onglets zones --}}
  <div class="orders-tabs">
    @foreach($zones as $key => $label)
      @if($key !== 'PAY')
        <a class="tab {{ $zone === $key ? 'active' : '' }}"
           href="{{ route('orders.ui.tables', [
              'branch_id' => $branchId,
              'zone' => $key,
              'q' => $q
           ]) }}">
           {{ $label }}
        </a>
      @endif
    @endforeach
  </div>

  {{-- Grille des tables --}}
  <div class="tables-grid">
    @forelse($tables as $t)
      <a class="table-card"
         href="{{ route('orders.ui.takeTable', $t->id) }}">

        <div class="table-title">
          Table {{ $t->table_number }}
        </div>

        <div class="table-meta">
          <div>Couverts</div>
          <div>{{ $t->capacity }}</div>

          <div>Compte</div>
          <div>—</div>
        </div>

        <span class="status-badge status-{{ strtolower($t->status) }}">
          {{ ucfirst(strtolower($t->status)) }}
        </span>

      </a>
    @empty
      <div class="muted">
        Aucune table disponible.
      </div>
    @endforelse
  </div>

</div>
@endsection
