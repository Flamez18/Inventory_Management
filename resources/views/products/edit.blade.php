<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Inventory</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; padding: 40px; color: #333; }
        .container { max-width: 500px; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); margin: auto; }
        h1 { margin-bottom: 25px; font-size: 22px; color: #2d3436; border-left: 5px solid #0984e3; padding-left: 15px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #636e72; }
        input[type="text"], input[type="number"], select {
            width: 100%; padding: 12px; border: 1px solid #dfe6e9; border-radius: 6px; box-sizing: border-box; transition: 0.3s;
        }
        input:focus { border-color: #0984e3; outline: none; box-shadow: 0 0 0 3px rgba(9,132,227,0.1); }

        /* Styling Gambar */
        .image-section { background: #f1f2f6; padding: 15px; border-radius: 8px; margin-bottom: 18px; }
        .current-img { width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: block; margin-bottom: 10px; }
        .no-img { font-size: 12px; color: #b2bec3; font-style: italic; margin-bottom: 10px; }

        .btn { padding: 12px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; font-size: 16px; transition: 0.3s; }
        .btn-update { background-color: #0984e3; color: white; }
        .btn-update:hover { background-color: #074b83; }
        .btn-back { background: none; color: #636e72; text-decoration: none; display: inline-block; margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>

<div class="container">
    <a href="/products" class="btn-back">← Kembali ke Daftar</a>
    <h1>Edit Produk</h1>

    {{-- CRITICAL: Tambahkan enctype="multipart/form-data" agar bisa kirim gambar --}}
    <form method="POST" action="/products/{{ $product->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="name" value="{{ $product->name }}" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="image-section">
            <label>Foto Produk Saat Ini</label>
            @if($product->image)
                <img src="{{ asset('images/' . $product->image) }}" class="current-img">
            @else
                <p class="no-img">Belum ada foto yang diunggah</p>
            @endif

            <label>Ganti Foto Baru</label>
            <input type="file" name="image" accept="image/*">
            <small style="color: #636e72; font-size: 11px;">*Kosongkan jika tidak ingin mengubah gambar</small>
        </div>

        <div style="display: flex; gap: 15px;">
            <div class="form-group" style="flex: 1;">
                <label>Stok</label>
                <input type="number" name="stock" value="{{ $product->stock }}">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Unit</label>
                <input type="text" name="unit" value="{{ $product->unit }}" placeholder="Pcs/Box">
            </div>
        </div>

        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" name="location" value="{{ $product->location }}">
        </div>

        <button type="submit" class="btn btn-update">Simpan Perubahan</button>
    </form>
</div>

</body>
</html>
