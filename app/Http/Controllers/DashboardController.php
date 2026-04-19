public function index()
{
    $data['total_produk'] = Produk::count();
    $data['total_stok'] = Produk::sum('stok');
    $data['stok_menipis'] = Produk::where('stok', '<', 5)->count();
    $data['produk_terbaru'] = Produk::with('kategori')->latest()->paginate(10);

    return view('dashboard.index', $data);
}
