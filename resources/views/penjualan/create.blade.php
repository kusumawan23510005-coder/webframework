@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Transaksi Penjualan Baru</h3>
    </div>
    <div class="card-body">
        <form id="form-transaksi">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Kasir</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->nama }}" readonly>
                        <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                    </div>
                    <div class="form-group">
                        <label>Nama Pembeli</label>
                        <input type="text" class="form-control" name="pembeli" id="pembeli" placeholder="Umum" value="Umum" required>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Pilih Barang</label>
                        <select class="form-control select2" id="pilih_barang" style="width: 100%;">
                            <option value="">-- Cari Barang --</option>
                            @foreach($barang as $item)
                                <option value="{{ $item->barang_id }}" 
                                        data-nama="{{ $item->nama_barang }}" 
                                        data-harga="{{ $item->harga_jual }}"
                                        data-stok="{{ $item->stok }}">
                                    {{ $item->kode_barang }} - {{ $item->nama_barang }} (Stok: {{ $item->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="number" class="form-control" id="qty" value="1" min="1">
                    </div>
                    <button type="button" class="btn btn-primary btn-block" id="btn-tambah">
                        <i class="fa fa-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </div>

                <div class="col-md-8">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="cart-table">
                            <tr>
                                <td colspan="5" class="text-center">Keranjang kosong</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total Bayar:</th>
                                <th colspan="2" id="grand-total">Rp 0</th>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <button type="submit" class="btn btn-success btn-lg float-right mt-3">
                        <i class="fa fa-save"></i> Simpan Transaksi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // 1. Inisialisasi Select2 (Dibungkus try-catch biar aman)
        try {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        } catch (e) {
            console.error("Select2 error:", e);
        }

        let cart = [];

        // 2. Event Listener Tombol Tambah
        $('#btn-tambah').on('click', function() {
            // Debugging: Cek apakah tombol bereaksi
            console.log("Tombol Tambah Ditekan..."); 

            // Ambil Value dari Input
            let barangId = $('#pilih_barang').val();
            
            // Cara mengambil data atribut yang lebih aman
            let selectedOption = $('#pilih_barang option:selected');
            let barangNama = selectedOption.data('nama');
            let barangHarga = parseFloat(selectedOption.data('harga'));
            let barangStok = parseInt(selectedOption.data('stok'));
            
            let qty = parseInt($('#qty').val());

            // Debugging: Cek data yang diambil
            console.log("Data Barang:", { id: barangId, nama: barangNama, harga: barangHarga, stok: barangStok, qty: qty });

            // Validasi Input
            if (!barangId) {
                alert("Silakan pilih barang terlebih dahulu!");
                return;
            }
            
            if (isNaN(qty) || qty <= 0) {
                alert("Jumlah minimal 1!");
                return;
            }

            if (qty > barangStok) {
                alert("Stok tidak cukup! Sisa stok: " + barangStok);
                return;
            }

            // Cek apakah barang sudah ada di cart
            let existingItemIndex = cart.findIndex(item => item.barang_id == barangId);
            
            if (existingItemIndex !== -1) {
                // Jika ada, update qty
                cart[existingItemIndex].jumlah += qty;
                
                // Cek stok lagi setelah ditambah
                if(cart[existingItemIndex].jumlah > barangStok){
                     alert("Total jumlah melebihi stok yang tersedia!");
                     cart[existingItemIndex].jumlah -= qty; // Batalkan penambahan
                     return;
                }
                cart[existingItemIndex].subtotal = cart[existingItemIndex].jumlah * cart[existingItemIndex].harga;
            } else {
                // Jika baru, push ke array
                cart.push({
                    barang_id: barangId,
                    nama: barangNama,
                    harga: barangHarga,
                    jumlah: qty,
                    subtotal: qty * barangHarga
                });
            }

            // Render ulang tabel
            renderCart();
            
            // Reset input Qty saja, Select2 jangan direset biar kasir tidak bingung
            $('#qty').val(1);
        });

        // 3. Fungsi Render Tabel Keranjang
        function renderCart() {
            let html = '';
            let grandTotal = 0;

            if(cart.length === 0){
                $('#cart-table').html('<tr><td colspan="5" class="text-center">Keranjang kosong</td></tr>');
                $('#grand-total').text('Rp 0');
                return;
            }

            cart.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${item.nama}</td>
                        <td>Rp ${new Intl.NumberFormat('id-ID').format(item.harga)}</td>
                        <td>${item.jumlah}</td>
                        <td>Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapusItem(${index})">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                grandTotal += item.subtotal;
            });

            $('#cart-table').html(html);
            $('#grand-total').text('Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal));
        }

        // 4. Fungsi Hapus Item (Global Scope)
        window.hapusItem = function(index) {
            cart.splice(index, 1);
            renderCart();
        }

        // 5. Submit Transaksi
        $('#form-transaksi').submit(function(e) {
            e.preventDefault();

            if (cart.length === 0) {
                alert("Keranjang belanja masih kosong!");
                return;
            }

            let formData = {
                user_id: $('input[name="user_id"]').val(),
                pembeli: $('#pembeli').val(),
                details: cart,
                _token: $('input[name="_token"]').val()
            };

            $.ajax({
                url: "{{ url('penjualan/store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        window.location.href = response.redirect;
                    } else {
                        alert("Gagal: " + response.message);
                    }
                },
                error: function(xhr) {
                    alert("Terjadi kesalahan server");
                    console.error(xhr);
                }
            });
        });
    });
</script>
@endpush