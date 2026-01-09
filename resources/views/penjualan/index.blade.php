@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('penjualan/create') }}" class="btn btn-sm btn-primary mt-1">
                <i class="fa fa-plus"></i> Transaksi Baru
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Pembeli</th>
                    <th>Kasir</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    $(document).ready(function() {
        var dataPenjualan = $('#table_penjualan').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                "url": "{{ url('penjualan/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false},
                {data: "penjualan_kode", className: "", orderable: true, searchable: true},
                {data: "tanggal_penjualan", className: "", orderable: true, searchable: true},
                {data: "pembeli", className: "", orderable: true, searchable: true},
                {data: "kasir", className: "", orderable: true, searchable: true},
                {data: "total_harga", className: "text-right", orderable: true, searchable: false},
                {data: "aksi", className: "text-center", orderable: false, searchable: false}
            ]
        });
    });

    function modalAction(url = ''){
        // PERBAIKAN DI SINI:
        // Targetkan .modal-content di dalam #my-modal
        $('#my-modal .modal-content').load(url, function(){
            $('#my-modal').modal('show');
        });
    }
</script>
@endpush