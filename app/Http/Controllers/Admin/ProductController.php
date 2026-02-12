<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\MenuCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $branchId = $request->get('branch_id') ?? Branch::query()->value('id');
        $q = trim((string) $request->get('q', ''));
        $categoryId = $request->get('category_id');
        $active = $request->get('active'); // 1 / 0 / null

        $categories = MenuCategory::query()
            ->where('branch_id', $branchId)
            ->orderBy('name')
            ->get();

$products = Product::query()
    ->where('branch_id', $branchId)
    ->when($q !== '', function ($qr) use ($q) {
        $qr->where('name', 'like', "%{$q}%");
    })
    ->when($categoryId, function ($qr) use ($categoryId) {
        $qr->where('menu_category_id', $categoryId);
    })
    ->when($active !== null && $active !== '', function ($qr) use ($active) {
        $qr->where('is_active', (int) $active);
    })
    ->with(['category', 'taxRule'])
    ->orderBy('name')
    ->paginate(12);

$products->withQueryString();


        return view('admin.products.index', compact('branchId','q','categoryId','active','categories','products'));
    }

    public function create(Request $request)
    {
        $branchId = $request->get('branch_id') ?? Branch::query()->value('id');

        $categories = MenuCategory::query()
            ->where('branch_id', $branchId)
            ->orderBy('name')
            ->get();

        return view('admin.products.create', compact('branchId','categories'));
    }

    public function store(Request $request)
    {
        $uuid = 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

        $data = $request->validate([
            'branch_id' => ['required', $uuid],
            'menu_category_id' => ['required', $uuid],
            'tax_rule_id' => ['nullable', $uuid],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'], // 2MB
        ]);

        $p = new Product();
        $p->branch_id = $data['branch_id'];
        $p->menu_category_id = $data['menu_category_id'];
        $p->tax_rule_id = $data['tax_rule_id'] ?? null;
        $p->name = $data['name'];
        $p->description = $data['description'] ?? null;
        $p->base_price = $data['base_price'];
        $p->sku = $data['sku'] ?? null;
        $p->is_active = (bool) ($data['is_active'] ?? true);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $p->image_path = $path; // il faut ce champ en DB (optionnel)
        }

        $p->save();

        return redirect()
            ->route('admin.products.index', ['branch_id' => $p->branch_id])
            ->with('success', 'Produit créé avec succès.');
    }

    public function edit(Request $request, Product $product)
    {
        $branchId = $product->branch_id;

        $categories = MenuCategory::query()
            ->where('branch_id', $branchId)
            ->orderBy('name')
            ->get();

        return view('admin.products.edit', compact('product','branchId','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $uuid = 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

        $data = $request->validate([
            'menu_category_id' => ['required', $uuid],
            'tax_rule_id' => ['nullable', $uuid],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        $product->menu_category_id = $data['menu_category_id'];
        $product->tax_rule_id = $data['tax_rule_id'] ?? null;
        $product->name = $data['name'];
        $product->description = $data['description'] ?? null;
        $product->base_price = $data['base_price'];
        $product->sku = $data['sku'] ?? null;
        $product->is_active = (bool) ($data['is_active'] ?? true);

        // supprimer image
        if (!empty($data['remove_image']) && !empty($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
            $product->image_path = null;
        }

        // remplacer image
        if ($request->hasFile('image')) {
            if (!empty($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()
            ->route('admin.products.index', ['branch_id' => $product->branch_id])
            ->with('success', 'Produit mis à jour.');
    }

    public function toggle(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return back()->with('success', 'Statut du produit mis à jour.');
    }
}
