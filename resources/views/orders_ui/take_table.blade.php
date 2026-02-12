@extends('layouts.admin')

@section('content')
<div class="container orders-screen">
  <div class="topbar">
    <h2>Table {{ $table->table_number }}</h2>

    <div class="service-tabs">
      <button class="tab active" data-service="CUISINE">Cuisine</button>
      <button class="tab" data-service="PIZZERIA">Pizzeria</button>
      <button class="tab" data-service="BAR">Bar</button>
    </div>
  </div>

  <div class="content">
    {{-- LEFT: bon de commande --}}
    <div class="left-panel">
      <h4>Bon de commande</h4>
      <div id="cart"></div>

      <div class="total">
        Total: <span id="total">0</span> XAF
      </div>

      <button id="btnSave" class="btn-save">Save</button>
      <div id="saveResult" class="muted"></div>
    </div>

    {{-- RIGHT: catalogue --}}
    <div class="right-panel">
      <div id="categories" class="cats"></div>
      <div id="products" class="products-grid"></div>
    </div>
  </div>
</div>

<script>
const BRANCH_ID = @json($branchId);
const TABLE_ID = @json($table->id);
const USER_ID = @json($userId);

// panier local
let cart = []; // [{product_id, qty, options:[]}]
let catalog = {categories:[], products:[]};
let currentService = 'CUISINE';
let currentCategory = null;

function money(n){ return Number(n).toFixed(0); }

function renderCart(){
  const el = document.getElementById('cart');
  if(cart.length === 0){
    el.innerHTML = `<div class="muted">Aucun item</div>`;
  } else {
    el.innerHTML = cart.map((it,idx) => {
      const p = catalog.products.find(x => x.id === it.product_id);
      const name = p ? p.name : 'Produit';
      return `
        <div class="cart-row">
          <div>
            <b>${name}</b><br/>
            <small>qty: ${it.qty}</small>
          </div>
          <div class="cart-actions">
            <button onclick="decQty(${idx})">-</button>
            <button onclick="incQty(${idx})">+</button>
            <button onclick="removeItem(${idx})">x</button>
          </div>
        </div>
      `;
    }).join('');
  }

  // total (MVP: base_price * qty)
  let total = 0;
  cart.forEach(it=>{
    const p = catalog.products.find(x => x.id === it.product_id);
    if(p) total += Number(p.base_price) * Number(it.qty);
  });
  document.getElementById('total').innerText = money(total);
}

function incQty(i){ cart[i].qty += 1; renderCart(); }
function decQty(i){ cart[i].qty = Math.max(1, cart[i].qty - 1); renderCart(); }
function removeItem(i){ cart.splice(i,1); renderCart(); }

function renderCategories(){
  const el = document.getElementById('categories');
  el.innerHTML = catalog.categories.map(c => `
    <button class="cat ${currentCategory===c.id?'active':''}" onclick="setCategory('${c.id}')">
      ${c.name}
    </button>
  `).join('');
}

function setCategory(id){
  currentCategory = id;
  renderCategories();
  renderProducts();
}

function renderProducts(){
  const el = document.getElementById('products');
  const prods = catalog.products.filter(p => !currentCategory || p.menu_category_id === currentCategory);

  el.innerHTML = prods.map(p => `
    <div class="product-card">
      <div class="pname">${p.name}</div>
      <div class="pprice">${money(p.base_price)} XAF</div>
      <button class="btn-add" onclick="addToCart('${p.id}')">+</button>
    </div>
  `).join('');
}

function addToCart(productId){
  const found = cart.find(x => x.product_id === productId);
  if(found){ found.qty += 1; }
  else { cart.push({product_id: productId, variant_id: null, qty: 1, options: []}); }
  renderCart();
}

async function loadCatalog(service){
  currentService = service;
  currentCategory = null;

  const res = await fetch(`/orders-ui/table/${TABLE_ID}/catalog?service=${service}`, {
    headers: {'Accept':'application/json'}
  });
  catalog = await res.json();
  // default category = first
  if(catalog.categories.length) currentCategory = catalog.categories[0].id;

  renderCategories();
  renderProducts();
  renderCart();
}

document.querySelectorAll('.tab').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    document.querySelectorAll('.tab').forEach(x=>x.classList.remove('active'));
    btn.classList.add('active');
    loadCatalog(btn.dataset.service);
  });
});

document.getElementById('btnSave').addEventListener('click', async ()=>{
  if(cart.length === 0){
    document.getElementById('saveResult').innerText = 'Panier vide.';
    return;
  }

  // payload API create order
  const payload = {
    branch_id: BRANCH_ID,
    opened_by_user_id: USER_ID,
    channel: "DINE_IN",
    restaurant_table_id: TABLE_ID,
    currency: "XAF",
    items: cart.map(it => ({
      product_id: it.product_id,
      variant_id: it.variant_id,
      qty: it.qty,
      options: it.options || []
    }))
  };

  const r = await fetch(`/api/v1/orders`, {
    method: 'POST',
    headers: {
      'Accept':'application/json',
      'Content-Type':'application/json'
    },
    body: JSON.stringify(payload)
  });

  const out = await r.json();
  if(!r.ok){
    document.getElementById('saveResult').innerText = JSON.stringify(out);
    return;
  }

  document.getElementById('saveResult').innerText = `Commande créée: ${out.data.order_number}`;
  cart = [];
  renderCart();
});

// init
loadCatalog('CUISINE');
</script>

<style>
/* =========================
   TAKE TABLE - Don Salvadore
   ========================= */

:root{
  --bg: #f5f4e7;
  --panel: #ffffff;
  --panel-soft: #f2f0dc;
  --line: #d9d6c1;
  --text: #2c2c2c;
  --muted: #7b7b7b;

  --primary: #7b7a10;      /* olive */
  --primary-dark: #5f5e0c;

  --brown: #5b3b36;
  --shadow: 0 10px 20px rgba(0,0,0,.07);
  --radius: 14px;
}

.orders-screen{
  background: var(--bg);
  padding: 18px;
  border-radius: 18px;
}

/* Top bar inside content (Table title + tabs) */
.orders-screen .topbar{
  background: var(--panel);
  border: 1px solid var(--line);
  border-radius: var(--radius);
  padding: 14px 16px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: var(--shadow);
  gap: 12px;
}

.orders-screen .topbar h2{
  margin: 0;
  font-size: 20px;
  font-weight: 700;
  color: var(--text);
  display: flex;
  align-items: center;
  gap: 8px;
}

.service-tabs{
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.service-tabs .tab{
  border: 1px solid var(--line);
  background: #efeedb;
  color: #333;
  padding: 8px 14px;
  border-radius: 999px;
  font-weight: 600;
  cursor: pointer;
  transition: .15s ease-in-out;
}

.service-tabs .tab:hover{
  transform: translateY(-1px);
}

.service-tabs .tab.active{
  background: var(--primary);
  color: #fff;
  border-color: transparent;
}

/* Main content: left panel + right panel */
.orders-screen .content{
  display: grid;
  grid-template-columns: 340px 1fr;
  gap: 16px;
  margin-top: 16px;
}

/* Left panel (bon de commande) */
.left-panel{
  background: var(--panel);
  border: 1px solid var(--line);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  padding: 14px;
  min-height: 520px;
  display: flex;
  flex-direction: column;
}

.left-panel h4{
  margin: 0 0 12px 0;
  font-size: 16px;
  font-weight: 800;
  color: var(--text);
}

#cart{
  flex: 1;
  overflow: auto;
  padding-right: 4px;
}

.cart-row{
  border: 1px solid #e7e5d3;
  background: #fbfaf0;
  border-radius: 12px;
  padding: 10px 10px;
  margin-bottom: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
}

.cart-row b{
  font-size: 14px;
}

.cart-row small{
  color: var(--muted);
}

.cart-actions{
  display: flex;
  gap: 6px;
}

.cart-actions button{
  width: 30px;
  height: 30px;
  border-radius: 10px;
  border: 1px solid var(--line);
  background: #fff;
  cursor: pointer;
  font-weight: 700;
  transition: .12s ease-in-out;
}

.cart-actions button:hover{
  transform: translateY(-1px);
  background: #f3f3f3;
}

/* Total + Save */
.total{
  padding-top: 10px;
  margin-top: 10px;
  border-top: 1px dashed var(--line);
  font-weight: 800;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

#total{
  color: var(--primary-dark);
}

.btn-save{
  margin-top: 12px;
  width: 100%;
  background: var(--primary);
  border: none;
  color: #fff;
  padding: 10px 14px;
  border-radius: 12px;
  font-weight: 800;
  cursor: pointer;
  box-shadow: 0 10px 18px rgba(123, 122, 16, .22);
  transition: .15s ease-in-out;
}

.btn-save:hover{
  background: var(--primary-dark);
  transform: translateY(-1px);
}

.muted{
  color: var(--muted);
  font-size: 12px;
  margin-top: 8px;
  word-break: break-word;
}

/* Right panel (catalogue) */
.right-panel{
  background: var(--panel);
  border: 1px solid var(--line);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  padding: 14px;
  min-height: 520px;
  display: flex;
  flex-direction: column;
}

/* Categories */
.cats{
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  margin-bottom: 12px;
}

.cats .cat{
  border: 1px solid var(--line);
  background: #efeedb;
  color: #333;
  padding: 7px 12px;
  border-radius: 999px;
  font-weight: 700;
  cursor: pointer;
  transition: .15s ease-in-out;
}

.cats .cat:hover{
  transform: translateY(-1px);
}

.cats .cat.active{
  background: #2c2c2c;
  color: #fff;
  border-color: transparent;
}

/* Products grid */
.products-grid{
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 12px;
  overflow: auto;
  padding-right: 4px;
  flex: 1;
}

.product-card{
  border: 1px solid #e7e5d3;
  background: #fbfaf0;
  border-radius: 14px;
  padding: 12px;
  min-height: 110px;
  position: relative;
  box-shadow: 0 8px 14px rgba(0,0,0,.05);
}

.product-card .pname{
  font-weight: 800;
  color: var(--text);
  font-size: 14px;
  margin-bottom: 6px;
}

.product-card .pprice{
  color: var(--muted);
  font-weight: 700;
  font-size: 13px;
}

.product-card .btn-add{
  position: absolute;
  right: 10px;
  top: 10px;
  width: 28px;
  height: 28px;
  border-radius: 10px;
  border: none;
  background: #f3f3f3;
  cursor: pointer;
  font-weight: 900;
  transition: .12s ease-in-out;
}

.product-card .btn-add:hover{
  background: var(--primary);
  color: #fff;
  transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 1100px){
  .orders-screen .content{
    grid-template-columns: 1fr;
  }

  .products-grid{
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}

@media (max-width: 780px){
  .products-grid{
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}
</style>

@endsection
