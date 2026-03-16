<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Inventory</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; padding: 40px; color: #333; }
        .container { max-width: 500px; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); margin: auto; }
        h1 { margin-bottom: 25px; font-size: 22px; color: #2d3436; border-left: 5px solid #28a745; padding-left: 15px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #636e72; }
        input[type="text"], input[type="number"], select, input[type="file"] {
            width: 100%; padding: 12px; border: 1px solid #dfe6e9; border-radius: 6px; box-sizing: border-box; transition: 0.3s;
        }
        input:focus, select:focus { border-color: #28a745; outline: none; box-shadow: 0 0 0 3px rgba(40,167,69,0.1); }

        .image-upload-section { background: #f1f2f6; padding: 15px; border-radius: 8px; margin-bottom: 18px; border: 1px dashed #ced4da; }

        .btn { padding: 12px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; font-size: 16px; transition: 0.3s; }
        .btn-save { background-color: #28a745; color: white; }
        .btn-save:hover { background-color: #218838; }
        .btn-back { background: none; color: #636e72; text-decoration: none; display: inline-block; margin-bottom: 20px; font-size: 14px; }
        .error-msg { color: #dc3545; font-size: 12px; margin-top: 5px; }
    </style>
</head>
<body>

<div class="container">
    <a href="/products" class="btn-back">← Kembali ke Daftar</a>
    <h1>Tambah Produk Baru</h1>

    {{-- Form tunggal dengan enctype untuk mendukung upload file --}}
    <form method="POST" action="/products" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="name" placeholder="Masukkan nama produk" value="{{ old('name') }}" required>
            @error('name') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="image-upload-section">
            <label>Foto Produk</label>
            <input type="file" name="image" accept="image/*">
            <small style="color: #636e72; font-size: 11px;">Format: JPG, PNG (Maks. 2MB)</small>
            @error('image') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; gap: 15px;">
            <div class="form-group" style="flex: 1;">
                <label>Stok Awal</label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Unit</label>
                <input type="text" name="unit" placeholder="Pcs/Box" value="{{ old('unit') }}">
            </div>
        </div>

        <div class="form-group">
            <label>Lokasi Rak/Gudang</label>
            <input type="text" name="location" placeholder="Contoh: Rak A-1" value="{{ old('location') }}">
        </div>

        <button type="submit" class="btn btn-save">Simpan ke Database</button>
    </form>
</div>

</body>
</html>
