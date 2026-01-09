<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokModel;
use App\Models\BarangModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class StokController extends Controller
{
    // --- 1. HALAMAN UTAMA ---
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list'  => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar Riwayat Stok Barang'
        ];

        $barang = BarangModel::select('barang_id', 'nama_barang')->orderBy('nama_barang')->get();

        return view('stok.index', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'barang'     => $barang,
            'activeMenu' => 'stok' // Fix: Agar menu sidebar aktif
        ]);
    }

    // --- 2. DATA TABLES JSON ---
    public function list(Request $request)
    {
        $stoks = StokModel::select('stok_id', 'barang_id', 'tanggal', 'jumlah', 'tipe')
            ->with('barang')
            ->orderBy('tanggal', 'desc')
            ->orderBy('stok_id', 'desc');

        if ($request->barang_id) {
            $stoks->where('barang_id', $request->barang_id);
        }

        return DataTables::of($stoks)
            ->addIndexColumn()
            ->addColumn('barang_nama', function ($stok) {
                return $stok->barang->nama_barang ?? '-';
            })
            ->editColumn('tanggal', function ($stok) {
                return Carbon::parse($stok->tanggal)->format('d-m-Y');
            })
            ->editColumn('tipe', function ($stok) {
                return $stok->tipe == 'masuk'
                    ? '<span class="badge badge-success">Masuk</span>'
                    : '<span class="badge badge-danger">Keluar</span>';
            })
            ->addColumn('aksi', function ($stok) {
                $btn  = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi', 'tipe'])
            ->make(true);
    }

    // --- 3. CREATE (FORM) ---
    public function create_ajax()
    {
        $barang = BarangModel::select('barang_id', 'nama_barang')->orderBy('nama_barang')->get();
        return view('stok.create_ajax')->with('barang', $barang);
    }

    // --- 4. STORE (SIMPAN DATA) ---
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => 'required|integer|exists:m_barang,barang_id',
                'jumlah'    => 'required|integer|min:1',
                'tanggal'   => 'required|date'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validasi Gagal', 'msgField' => $validator->errors()]);
            }

            StokModel::create([
                'barang_id' => $request->barang_id,
                'tanggal'   => $request->tanggal,
                'jumlah'    => $request->jumlah,
                'tipe'      => 'masuk' // Default Masuk
            ]);

            // UPDATE OTOMATIS: Sinkronisasi Stok Barang
            $this->updateStokBarang($request->barang_id);

            return response()->json(['status' => true, 'message' => 'Data stok berhasil disimpan']);
        }
        return redirect('/');
    }

    // --- 5. EDIT (FORM) ---
    public function edit_ajax($id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::select('barang_id', 'nama_barang')->orderBy('nama_barang')->get();
        if (!$stok) return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        return view('stok.edit_ajax', ['stok' => $stok, 'barang' => $barang]);
    }

    // --- 6. UPDATE (SIMPAN PERUBAHAN) ---
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => 'required|integer|exists:m_barang,barang_id',
                'jumlah'    => 'required|integer|min:1',
                'tanggal'   => 'required|date'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validasi Gagal', 'msgField' => $validator->errors()]);
            }

            $stok = StokModel::find($id);
            if ($stok) {
                $oldBarangId = $stok->barang_id; // Simpan ID barang lama

                $stok->update([
                    'barang_id' => $request->barang_id,
                    'tanggal'   => $request->tanggal,
                    'jumlah'    => $request->jumlah,
                    'tipe'      => 'masuk'
                ]);

                // UPDATE OTOMATIS: Sinkronisasi Stok Barang Baru
                $this->updateStokBarang($request->barang_id);

                // Jika barangnya diganti, update juga stok barang lama agar balance
                if ($oldBarangId != $request->barang_id) {
                    $this->updateStokBarang($oldBarangId);
                }

                return response()->json(['status' => true, 'message' => 'Data stok berhasil diperbarui']);
            }
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return redirect('/');
    }

    // --- 7. CONFIRM DELETE ---
    public function confirm_ajax($id)
    {
        $stok = StokModel::with('barang')->find($id);
        if (!$stok) return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        return view('stok.confirm_ajax', ['stok' => $stok]);
    }

    // --- 8. DELETE (HAPUS DATA) ---
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $barang_id = $stok->barang_id; // Simpan ID sebelum dihapus
                $stok->delete();

                // UPDATE OTOMATIS: Hitung ulang stok setelah penghapusan
                $this->updateStokBarang($barang_id);

                return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
            }
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return redirect('/');
    }

    // --- 9. SHOW DETAIL ---
    public function show_ajax($id)
    {
        $stok = StokModel::with('barang')->find($id);
        if (!$stok) return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        return view('stok.show_ajax', ['stok' => $stok]);
    }

    // --- FUNGSI PRIVAT: SINKRONISASI STOK ---
    // Menghitung total stok berdasarkan riwayat (Masuk - Keluar)
    private function updateStokBarang($barang_id)
    {
        // 1. Hitung jumlah masuk
        $masuk = StokModel::where('barang_id', $barang_id)
            ->where('tipe', 'masuk')
            ->sum('jumlah');

        // 2. Hitung jumlah keluar
        $keluar = StokModel::where('barang_id', $barang_id)
            ->where('tipe', 'keluar')
            ->sum('jumlah');

        // 3. Hitung total
        $total = $masuk - $keluar;

        // 4. Update tabel m_barang
        // Pastikan tabel m_barang memiliki kolom 'stok'
        BarangModel::where('barang_id', $barang_id)->update(['stok' => $total]);
    }
}
