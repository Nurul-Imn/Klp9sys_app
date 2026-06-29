<?php

namespace App\Http\Controllers;

use App\Contract\ProductServiceContract;
use App\models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductServiceContract $productService
    ) {}

    // =========================================================================
    // INDEX — list semua produk/layanan
    // =========================================================================

    public function index(Request $request)
    {
        $filters = array_filter([
            'is_active' => true,
            'is_active' => true,  // tampilkan hanya yang aktif di halaman publik
            'category'  => $request->query('category'),
            'min_price' => $request->query('min_price'),
            'max_price' => $request->query('max_price'),
        ], fn($v) => $v !== null && $v !== '');

        $products = collect($this->productService->listProducts($filters))
            ->map(fn($p) => (object) $p);
        $products = $this->productService->listProducts($filters);

    public function index()
    {
        $product = Product::all();
        return view('products.index', compact('products'));
    }

    // =========================================================================
    // CREATE — form tambah produk (admin)
    // =========================================================================

    public function create()
    {
        return view('products.create');
    }

    // =========================================================================
    // STORE — simpan produk baru
    // =========================================================================

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'nullable|string|max:100',
            'stock'       => 'nullable|integer|min:0',                     
            'duration'    => 'nullable|integer|min:1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'nullable|boolean',
        ]);

        // Handle image upload jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $this->productService->createProduct($validated);
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // =========================================================================
    // SHOW — detail satu produk
    // =========================================================================

    public function show(string $id)
    {
        $product = (object) $this->productService->getProduct((int) $id);
        $product = $this->productService->getProduct((int) $id);

        return view('products.show', compact('product'));
    }

    // =========================================================================
    // EDIT — form edit produk (admin)
    // =========================================================================

    public function edit(string $id)
    {
        $product = (object) $this->productService->getProduct((int) $id);
        $product = $this->productService->getProduct((int) $id);

        return view('products.edit', compact('product'));
    }

    // =========================================================================
    // UPDATE — simpan perubahan produk
    // =========================================================================

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'nullable|string|max:100',
            'stock'       => 'nullable|integer|min:0',
            'duration'    => 'nullable|integer|min:1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'nullable|boolean',
        ]);

        // Handle image upload jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $updated = $this->productService->updateProduct((int) $id, $validated);

        if (!$updated) {
            return back()->withErrors(['general' => 'Gagal memperbarui produk.']);
        }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : false;

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // =========================================================================
    // DESTROY — hapus produk
    // =========================================================================

    public function destroy(string $id)
    {
        $deleted = $this->productService->deleteProduct((int) $id);

        if (!$deleted) {
            return back()->withErrors(['general' => 'Gagal menghapus produk.']);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

    // =========================================================================
    // SEARCH — cari produk berdasarkan keyword
    // =========================================================================

    public function search(Request $request)
    {
        $request->validate([
            'q'         => 'required|string|min:1|max:255',
            'category'  => 'nullable|string|max:100',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
        ]);

        $filters = array_filter([
            'is_active' => true,
            'category'  => $request->query('category'),
            'min_price' => $request->query('min_price'),
            'max_price' => $request->query('max_price'),
        ], fn($v) => $v !== null && $v !== '');

        $products = collect($this->productService->searchProducts($request->query('q'), $filters))
            ->map(fn($p) => (object) $p);
        $products = $this->productService->searchProducts(
            $request->query('q'),
            $filters
        );

        return view('products.index', compact('products'));
    }
}

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}