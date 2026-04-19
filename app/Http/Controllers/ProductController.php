<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk (Dashboard + Tabel)
     */
    public function index()
    {
    // Hapus latest(), gunakan get() saja
    $products = Product::with('category')->get();
    $categories = Category::all();

    return view('products.index', compact('products', 'categories'));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // 2. Olah Upload Gambar
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $nama_file = time() . "_" . $file->getClientOriginalName();

            // Simpan ke public/images
            $file->move(public_path('images'), $nama_file);
            $data['image'] = $nama_file;
        }

        Product::create($data);

        return redirect('/products')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Form edit produk
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update produk lama
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada agar folder images tetap bersih
            if ($product->image && file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }

            // Upload foto baru
            $file = $request->file('image');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('images'), $nama_file);
            $data['image'] = $nama_file;
        }

        $product->update($data);

        return redirect('/products')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Hapus produk dan filenya
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus file fisik gambar dari folder public/images sebelum data dihapus dari DB
        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();

        return redirect('/products')->with('success', 'Produk berhasil dihapus!');
    }
}
