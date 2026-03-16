<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{

    public function index() {
    $products = Product::with('category')->get();
    $categories = Category::all();
    return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
    $categories = Category::all();
    return view('products.create', compact('categories'));
    }



    public function store(Request $request)
    {
    $data = $request->all();

    if ($request->hasFile('image')) {
        // 1. Ambil file
        $file = $request->file('image');
        // 2. Beri nama unik agar tidak bentrok
        $nama_file = time() . "_" . $file->getClientOriginalName();
        // 3. Simpan ke folder 'public/products'
        $file->move(public_path('images'), $nama_file);
        // 4. Masukkan nama file ke array data untuk disimpan di DB
        $data['image'] = $nama_file;
    }

    Product::create($data);
    return redirect('/products');
    }

    public function edit($id)
    {
    $product = Product::findOrFail($id);
    $categories = Category::all();
    return view('products.edit', compact('product','categories'));
    }

    //public function update(Request $request, $id)
    //{
    //$product = Product::findOrFail($id);
    //$product->update($request->all());
    //return redirect('/products');
    //}

    public function update(Request $request, $id)
{
    // 1. Validasi Input
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'stock' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Maks 2MB, harus gambar
    ]);

    $product = Product::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('image')) {
        // 1. Hapus foto lama jika ada di folder public/images
        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        // 2. Upload foto baru
        $file = $request->file('image');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $file->move(public_path('images'), $nama_file);
        $data['image'] = $nama_file;
    }

    $product->update($data);
    return redirect('/products')->with('success', 'Produk berhasil diupdate!');
}

    public function destroy($id)
    {
    $product = Product::findOrFail($id);
    $product->delete();
    return redirect('/products');
    }

}
