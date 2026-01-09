<div class="modal-header">
    <h5 class="modal-title">Detail Transaksi: {{ $penjualan->penjualan_kode }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-bordered table-sm">
        <tr>
            <th width="30%">No Nota</th>
            <td>{{ $penjualan->penjualan_kode }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <th>Kasir</th>
            <td>{{ $penjualan->user->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Pembeli</th>
            <td>{{ $penjualan->pembeli }}</td>
        </tr>
    </table>

    <h5 class="mt-4">Rincian Barang</h5>
    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th class="text-right">Harga</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->details as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->barang->nama_barang ?? 'Barang Dihapus' }}</td>
                <td class="text-right">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                <td class="text-center">{{ $item->jumlah }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total Bayar</th>
                <th class="text-right">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>