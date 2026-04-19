<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - Dashboard</title>
    {{-- Google Fonts --}}
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

        /* Dashboard Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            margin: 0;
            font-size: 13px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-card .value {
            font-size: 24px;
            font-weight: 700;
            margin: 10px 0 5px 0;
            display: block;
        }

        .stat-card .desc {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Indikator Warna untuk Stat */
        .border-primary { border-left: 4px solid var(--primary); }
        .border-success { border-left: 4px solid var(--success); }
        .border-danger { border-left: 4px solid var(--danger); }

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
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .table-header {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            background-color: var(--white);
        }

        .table-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
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
        .text-success { color: var(--success); font-weight: 600; }

    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <div>
                <h1>Inventory Dashboard</h1>
                <p style="color: var(--text-muted); margin: 5px 0 0 0;">Ringkasan dan detail stok barang Anda.</p>
            </div>
            <a href="/products/create" class="btn btn-add">+ Tambah Produk</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card border-primary">
                <h3>Total Produk</h3>
                <span class="value">{{ count($products) }}</span>
                <span class="desc">Jenis barang terdaftar</span>
            </div>
            <div class="stat-card border-success">
                <h3>Total Stok</h3>
                <span class="value">{{ number_format($products->sum('stock'), 0, ',', '.') }}</span>
                <span class="desc">Unit tersedia di gudang</span>
            </div>
            <div class="stat-card border-danger">
                <h3>Stok Menipis</h3>
                <span class="value" style="color: var(--danger);">
                    {{ $products->where('stock', '<=', 5)->count() }}
                </span>
                <span class="desc">Perlu segera di-restock</span>
            </div>
        </div>

        <div class="card">
            <div class="table-header">
                <h2>Daftar Inventaris Terkini</h2>
            </div>
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
                                    <div style="font-size: 12px; color: var(--text-muted);">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </td>
                        <td>
                            <div style="font-size: 14px;">
                                <span class="{{ $product->stock <= 5 ? 'stock-low' : 'text-success' }}">
                                    {{ $product->stock }}
                                </span>
                                <span style="color: var(--text-muted); font-size: 12px;">{{ $product->unit ?? 'Unit' }}</span>
                            </div>
                        </td>
                        <td style="font-size: 14px; color: var(--text-muted);">
                            {{ $product->location ?? 'Gudang Utama' }}
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
                        <td colspan="5" style="text-align: center; padding: 60px; color: var(--text-muted);">
                            <div style="font-size: 40px; margin-bottom: 10px;">📦</div>
                            Belum ada data produk. Klik "Tambah Produk" untuk memulai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
