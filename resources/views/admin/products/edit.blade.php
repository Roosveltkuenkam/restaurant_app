@extends('layouts.admin')

@section('content')
<div class="admin-page">

  <div class="page-header">
    <h2>Modifier le produit</h2>
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

  @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif

  <div class="form-panel">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-grid">
        <div class="form-row">
          <label>Nom</label>
          <input class="input" name="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-row">
          <label>Catégorie</label>
          <select class="select" name="menu_category_id" required>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" @selected(old('menu_category_id', $product->menu_category_id)===$c->id)>{{ $c->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-row">
          <label>Prix de base (XAF)</label>
          <input class="input" type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}" required>
        </div>

        <div class="form-row">
          <label>SKU (optionnel)</label>
          <input class="input" name="sku" value="{{ old('sku', $product->sku) }}">
        </div>

        <div class="form-row">
          <label>Description (optionnel)</label>
          <textarea class="input" name="description">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-row">
          <label>Image (optionnel)</label>
          <input class="input" type="file" name="image" accept="image/*">

          @if(!empty($product->image_path))
            <div class="helper" style="margin-top:8px;">
              <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}"
                   style="width:120px;height:120px;object-fit:cover;border-radius:14px;border:1px solid #e7e5d3;">
              <div style="margin-top:8px;">
                <label style="display:flex;align-items:center;gap:8px;font-weight:800;">
                  <input type="checkbox" name="remove_image" value="1">
                  Supprimer l’image actuelle
                </label>
              </div>
            </div>
          @endif
        </div>
      </div>

      <div class="form-actions">
        <label style="display:flex;align-items:center;gap:8px;font-weight:800;">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
          Actif
        </label>

        <button class="btn primary" type="submit">Mettre à jour</button>
      </div>
    </form>
  </div>

</div>
@endsection
