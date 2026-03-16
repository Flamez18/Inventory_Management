<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    {{-- Google Fonts untuk tipografi yang lebih modern --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --background: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            margin: 0;
            padding: 40px;
            color: var(--text-main);
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        /* Button Style */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }

        .btn-add { background-color: var(--primary); color: white; }
        .btn-add:hover { background-color: var(--primary-hover); transform: translateY(-1px); }

        /* Table Card */
        .card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }

        th {
            background-color: #f1f5f9;
            padding: 16px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }

        td { padding: 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }

        /* Badge for Category */
        .badge {
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
            background-color: #e2e8f0;
            color: #475569;
        }

        /* Product Image */
        .img-product {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .placeholder {
            width: 48px;
            height: 48px;
            background-color: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: #94a3b8;
            text-align: center;
            border: 1px dashed #cbd5e1;
        }

        /* Action Buttons */
        .action-cell { display: flex; gap: 8px; }
        .btn-edit { background-color: #fef3c7; color: #92400e; }
        .btn-edit:hover { background-color: #fde68a; }

        .btn-delete { background-color: #fee2e2; color: #991b1b; }
        .btn-delete:hover { background-color: #fecaca; }

        /* Stock Status */
        .stock-low { color: var(--danger); font-weight: 600; }

    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <div>
                <h1>Stok Produk</h1>
                <p style="color: var(--text-muted); margin: 5px 0 0 0;">Kelola inventaris barang Anda dengan mudah.</p>
            </div>
            <a href="/products/create" class="btn btn-add">+ Tambah Produk</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Info Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                @if($product->image)
                                    <img src="{{ asset('images/' . $product->image) }}" class="img-product">
                                @else
                                    <div class="placeholder">No Image</div>
                                @endif
                                <div>
                                    <div style="font-weight: 600; font-size: 15px;">{{ $product->name }}</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">ID: #{{ $product->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </td>
                        <td>
                            <div style="font-size: 14px;">
                                <span class="{{ $product->stock <= 5 ? 'stock-low' : '' }}">
                                    {{ $product->stock }}
                                </span>
                                <span style="color: var(--text-muted); font-size: 12px;">{{ $product->unit }}</span>
                            </div>
                        </td>
                        <td style="font-size: 14px; color: var(--text-muted);">
                            {{ $product->location ?? '-' }}
                        </td>
                        <td>
                            <div class="action-cell">
                                <a href="/products/{{ $product->id }}/edit" class="btn btn-edit">Edit</a>
                                <form action="/products/{{ $product->id }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            Belum ada data produk tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
