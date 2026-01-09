<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Stok Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-sm">
                <tr>
                    <th width="30%">Nama Barang</th>
                    <td>{{ $stok->barang->nama_barang }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $stok->barang->kategori->kategori_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Stok</th>
                    <td><b>{{ $stok->stok_jumlah }}</b></td>
                </tr>
                <tr>
                    <th>Tanggal Input</th>
                    <td>{{ \Carbon\Carbon::parse($stok->stok_tanggal)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Diinput Oleh</th>
                    <td>{{ $stok->user->nama ?? '-' }}</td>
                </tr>
            </table>@empty($stok)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"><div class="alert alert-danger">Data tidak ditemukan</div></div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Stok Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-sm">
                    <tr>
                        <th width="30%">Nama Barang</th>
                        <td>{{ $stok->barang->nama_barang }}</td>
                    </tr>
                    <tr>
                        <th>Tipe Stok</th>
                        <td>{{ $stok->tipe }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <td><b>{{ $stok->jumlah }}</b></td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ \Carbon\Carbon::parse($stok->tanggal)->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@endempty
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
        </div>
    </div>
</div>