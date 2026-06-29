<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Contract\ProductServiceContract;
=======
>>>>>>> 36494942b4e1901ebea6344515955376fda8ecbf
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
<<<<<<< HEAD
    public function __construct(
        protected ProductServiceContract $productService
    ) {}

    public function index(Request $request)
    {
        $filters = array_filter([
            'is_active' => true,
            'category'  => $request->query('category'),
            'min_price' => $request->query('min_price'),
            'max_price' => $request->query('max_price'),
        ], fn($v) => $v !== null && $v !== '');

        $products = collect($this->productService->listProducts($filters))
            ->map(fn($p) => (object) $p);

=======
    public function index()
    {
        $products = Product::all();
>>>>>>> 36494942b4e1901ebea6344515955376fda8ecbf
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
<<<<<<< HEAD
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'nullable|string|max:100',
            'stock'       => 'nullable|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $this->productService->createProduct($validated);
=======
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        Product::create($validated);
>>>>>>> 36494942b4e1901ebea6344515955376fda8ecbf

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

<<<<<<< HEAD
    public function show(string $id)
    {
        $product = (object) $this->productService->getProduct((int) $id);
        return view('products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = (object) $this->productService->getProduct((int) $id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'nullable|string|max:100',
            'stock'       => 'nullable|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $updated = $this->productService->updateProduct((int) $id, $validated);

        if (!$updated) {
            return back()->withErrors(['general' => 'Gagal memperbarui produk.']);
        }
=======
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
>>>>>>> 36494942b4e1901ebea6344515955376fda8ecbf

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

<<<<<<< HEAD
    public function destroy(string $id)
    {
        $deleted = $this->productService->deleteProduct((int) $id);

        if (!$deleted) {
            return back()->withErrors(['general' => 'Gagal menghapus produk.']);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

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

        return view('products.index', compact('products'));
    }
}
=======
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
>>>>>>> 36494942b4e1901ebea6344515955376fda8ecbf
