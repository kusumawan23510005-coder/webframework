<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

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
            ->with(['kategori', 'supplier'])
            ->orderBy('kode_barang', 'asc'); // <--- TAMBAHAN: Mengurutkan A-Z

        return DataTables::of($barangs)
            ->addIndexColumn() // Menambahkan nomor urut (DT_RowIndex)
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

    // --- FUNGSI IMPORT ---
    public function import()
    {
        return view('barang.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_barang');
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            $count = 0;
            $skipped = 0;

            // ARRAY PENCATAT SEMENTARA (Agar tidak duplikat di file yang sama)
            $processedKode = [];
            $processedNama = [];

            foreach ($data as $baris => $value) {
                if ($baris > 1) { // Lewati header

                    $kodeBarang = trim($value['C']);
                    $namaBarang = trim($value['D']);

                    if (empty($kodeBarang) || empty($namaBarang)) continue;

                    // --- CEK 1: Apakah ada di DATABASE? ---
                    $dbKode = BarangModel::where('kode_barang', $kodeBarang)->exists();
                    $dbNama = BarangModel::where('nama_barang', $namaBarang)->exists();

                    // --- CEK 2: Apakah ada di ANTRIAN SAAT INI (File Excel yg sama)? ---
                    $dupKode = in_array($kodeBarang, $processedKode);
                    $dupNama = in_array($namaBarang, $processedNama);

                    // JIKA SALAH SATU TRUE -> SKIP
                    if ($dbKode || $dbNama || $dupKode || $dupNama) {
                        $skipped++;
                        continue; // Lewati baris ini
                    }

                    // Jika Lolos semua seleksi, catat ke antrian
                    $processedKode[] = $kodeBarang; // Catat kode ini sudah diproses
                    $processedNama[] = $namaBarang; // Catat nama ini sudah diproses

                    $insert[] = [
                        'kategori_id' => $value['A'],
                        'supplier_id' => $value['B'],
                        'kode_barang' => $kodeBarang,
                        'nama_barang' => $namaBarang,
                        'harga_beli'  => $value['E'],
                        'harga_jual'  => $value['F'],
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                    $count++;
                }
            }

            if (count($insert) > 0) {
                BarangModel::insert($insert);
            }

            return response()->json([
                'status' => true,
                'message' => "Selesai. Masuk: $count data. Gagal/Duplikat: $skipped data."
            ]);
        }
        return redirect('/');
    }

    // --- FUNGSI EXPORT EXCEL ---
    public function export_excel()
    {
        // 1. Ambil data barang (PERBAIKAN: Select kode_barang & nama_barang)
        $barang = BarangModel::select('kategori_id', 'kode_barang', 'nama_barang', 'harga_beli', 'harga_jual')
            ->orderBy('kategori_id')
            ->with('kategori')
            ->get();

        // 2. Load Library Excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 3. Set Header Kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga Beli');
        $sheet->setCellValue('E1', 'Harga Jual');
        $sheet->setCellValue('F1', 'Kategori');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); // Bold Header

        // 4. Isi Data (Looping)
        $no = 1;
        $baris = 2;
        foreach ($barang as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->kode_barang); // PERBAIKAN: Gunakan kode_barang
            $sheet->setCellValue('C' . $baris, $value->nama_barang); // PERBAIKAN: Gunakan nama_barang
            $sheet->setCellValue('D' . $baris, $value->harga_beli);
            $sheet->setCellValue('E' . $baris, $value->harga_jual);
            $sheet->setCellValue('F' . $baris, $value->kategori->kategori_nama);
            $baris++;
            $no++;
        }

        // 5. Auto Size Kolom (PERBAIKAN: Loop range kolom, bukan data barang)
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Barang');

        // 6. Download File
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Barang ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    // --- FUNGSI EXPORT PDF ---
    public function export_pdf()
    {
        // PERBAIKAN: Gunakan kode_barang dan nama_barang
        $barang = BarangModel::select('kategori_id', 'kode_barang', 'nama_barang', 'harga_beli', 'harga_jual')
            ->orderBy('kategori_id')
            ->orderBy('kode_barang') // PERBAIKAN: Order by kode_barang
            ->with('kategori')
            ->get();

        $pdf = Pdf::loadView('barang.export_pdf', ['barang' => $barang]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);

        return $pdf->stream('Data Barang ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
