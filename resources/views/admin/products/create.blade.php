@extends('layouts.admin')

@section('content')
<div class="admin-page">

  <div class="page-header">
    <h2>Ajouter un produit</h2>
    <div class="header-actions">
      <a class="btn" href="{{ route('admin.products.index', ['branch_id' => $branchId]) }}">← Retour</a>
    </div>
  </div>

  @if($errors->any())
    <div class="alert error">
      <b>Erreurs :</b>
      <ul>
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="form-panel">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
      @csrf

      <input type="hidden" name="branch_id" value="{{ $branchId }}">

      <div class="form-grid">
        <div class="form-row">
          <label>Nom</label>
          <input class="input" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-row">
          <label>Catégorie</label>
          <select class="select" name="menu_category_id" required>
            <option value="">Choisir...</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" @selected(old('menu_category_id')===$c->id)>{{ $c->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-row">
          <label>Prix de base (XAF)</label>
          <input class="input" type="number" step="0.01" name="base_price" value="{{ old('base_price', 0) }}" required>
        </div>

        <div class="form-row">
          <label>SKU (optionnel)</label>
          <input class="input" name="sku" value="{{ old('sku') }}">
        </div>

        <div class="form-row">
          <label>Description (optionnel)</label>
          <textarea class="input" name="description">{{ old('description') }}</textarea>
        </div>

        <div class="form-row">
          <label>Image (optionnel)</label>
          <input class="input" type="file" name="image" accept="image/*">
          <div class="helper">Max 2MB. JPG/PNG/WebP.</div>
        </div>
      </div>

      <div class="form-actions">
        <label style="display:flex;align-items:center;gap:8px;font-weight:800;">
          <input type="checkbox" name="is_active" value="1" checked>
          Actif
        </label>

        <button class="btn primary" type="submit">Enregistrer</button>
      </div>
    </form>
  </div>

</div>
@endsection
