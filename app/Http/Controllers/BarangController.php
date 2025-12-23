<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\SupplierModel; // Jangan lupa import Supplier
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list'  => ['Home', 'Barang']
        ];
        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];
        $activeMenu = 'barang';

        // Ambil data untuk filter (opsional)
        $kategori = KategoriModel::all();

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        // Ambil data dengan 2 relasi
        $barangs = BarangModel::select('barang_id', 'kategori_id', 'supplier_id', 'kode_barang', 'nama_barang', 'stok', 'harga_beli', 'harga_jual')
            ->with(['kategori', 'supplier']);

        return DataTables::of($barangs)
            ->addIndexColumn()
            ->addColumn('kategori_nama', function ($barang) {
                return $barang->kategori->kategori_nama;
            })
            ->addColumn('supplier_nama', function ($barang) {
                return $barang->supplier->supplier_nama;
            })
            ->addColumn('aksi', function ($barang) {
                $btn  = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        // Ambil DUA data master untuk dropdown
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();

        return view('barang.create_ajax')
            ->with('kategori', $kategori)
            ->with('supplier', $supplier);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'supplier_id' => 'required|integer',
                'kode_barang' => 'required|string|min:3|unique:m_barang,kode_barang',
                'nama_barang' => 'required|string|max:100',
                'stok'        => 'required|integer',
                'harga_beli'  => 'required|numeric',
                'harga_jual'  => 'required|numeric',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validasi Gagal', 'msgField' => $validator->errors()]);
            }
            BarangModel::create($request->all());
            return response()->json(['status' => true, 'message' => 'Data berhasil disimpan']);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();

        return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori, 'supplier' => $supplier]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'supplier_id' => 'required|integer',
                'kode_barang' => 'required|max:20|unique:m_barang,kode_barang,' . $id . ',barang_id',
                'nama_barang' => 'required|max:100',
                'stok'        => 'required|integer',
                'harga_beli'  => 'required|numeric',
                'harga_jual'  => 'required|numeric',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validasi Gagal', 'msgField' => $validator->errors()]);
            }
            $check = BarangModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json(['status' => true, 'message' => 'Data berhasil diupdate']);
            }
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return redirect('/');
    }

    
    public function confirm_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {
                try {
                    $barang->delete();
                    return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['status' => false, 'message' => 'Gagal hapus, data terkait dengan data lain']);
                }
            }
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return redirect('/');
    }
}
