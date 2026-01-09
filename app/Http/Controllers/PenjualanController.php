<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\BarangModel;
use App\Models\StokModel; // Pastikan Model Stok di-import
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Penting untuk Transaction

class PenjualanController extends Controller
{
    // --- 1. HALAMAN DAFTAR PENJUALAN ---
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list'  => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar Transaksi Penjualan'
        ];

        return view('penjualan.index', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'activeMenu' => 'penjualan'
        ]);
    }

    // --- 2. DATA TABLES (JSON) ---
    public function list(Request $request)
    {
        $penjualan = PenjualanModel::with('user')
            ->select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'tanggal_penjualan', 'total_harga')
            ->orderBy('tanggal_penjualan', 'desc');

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('kasir', function ($row) {
                return $row->user->nama ?? 'Unknown';
            })
            ->editColumn('total_harga', function ($row) {
                return 'Rp ' . number_format($row->total_harga, 0, ',', '.');
            })
            ->editColumn('tanggal_penjualan', function ($row) {
                return Carbon::parse($row->tanggal_penjualan)->format('d-m-Y H:i');
            })
            ->addColumn('aksi', function ($row) {
                $btn  = '<button onclick="modalAction(\'' . url('/penjualan/' . $row->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // --- 3. SHOW DETAIL (MODAL) ---
    public function show_ajax($id)
    {
        $penjualan = PenjualanModel::with(['user', 'details.barang'])->find($id);

        if ($penjualan) {
            return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
        }
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
    }

    // --- 4. HALAMAN TRANSAKSI BARU (KASIR) ---
    // --- 4. HALAMAN TRANSAKSI BARU (KASIR) ---
    public function create()
    {
        // PERBAIKAN: Definisi Breadcrumb dan Page Title (Ini yang bikin error sebelumnya)
        $breadcrumb = (object) [
            'title' => 'Transaksi Penjualan',
            'list'  => ['Home', 'Penjualan', 'Transaksi']
        ];

        $page = (object) [
            'title' => 'Transaksi Penjualan Baru'
        ];

        // Ambil data barang yang stoknya ada
        $barang = BarangModel::with('kategori')
            ->where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        return view('penjualan.create', [
            'barang'     => $barang,
            'breadcrumb' => $breadcrumb, // Wajib ada
            'page'       => $page,       // Wajib ada
            'activeMenu' => 'penjualan'
        ]);
    }

    // --- 5. PROSES SIMPAN TRANSAKSI ---
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|max:100',
            'details' => 'required|array',
        ]);

        try {
            DB::beginTransaction(); // Mulai Transaksi Database

            // A. SIMPAN HEADER PENJUALAN
            $penjualan = PenjualanModel::create([
                'user_id' => $request->user_id,
                'pembeli' => $request->pembeli,
                'penjualan_kode' => 'PJ' . date('YmdHis') . rand(100, 999),
                'tanggal_penjualan' => now(),
                'total_harga' => 0 // Sementara 0, nanti diupdate
            ]);

            $total_harga = 0;

            // B. SIMPAN DETAIL & UPDATE STOK
            foreach ($request->details as $item) {
                $barang = BarangModel::find($item['barang_id']);

                if (!$barang) continue;

                // Cek stok lagi biar aman
                if ($barang->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$barang->nama_barang} kurang. Sisa: {$barang->stok}");
                }

                $subtotal = $barang->harga_jual * $item['jumlah'];
                $total_harga += $subtotal;

                // 1. Simpan Detail
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id'    => $barang->barang_id,
                    'jumlah'       => $item['jumlah'],
                    'harga_jual'   => $barang->harga_jual,
                    'subtotal'     => $subtotal
                ]);

                // 2. Catat di Kartu Stok (Barang Keluar)
                StokModel::create([
                    'barang_id' => $barang->barang_id,
                    'tanggal'   => now(),
                    'jumlah'    => $item['jumlah'],
                    'tipe'      => 'keluar'
                ]);

                // 3. Update Master Barang (Kurangi Stok)
                $barang->decrement('stok', $item['jumlah']);
            }

            // C. UPDATE TOTAL HARGA DI HEADER
            $penjualan->update(['total_harga' => $total_harga]);

            DB::commit(); // Simpan Permanen

            return response()->json([
                'status' => true,
                'message' => 'Transaksi Berhasil Disimpan',
                'redirect' => url('/penjualan')
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada error
            return response()->json([
                'status' => false,
                'message' => 'Gagal: ' . $e->getMessage()
            ]);
        }
    }
}
