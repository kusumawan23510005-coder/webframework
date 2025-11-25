<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <h1>Form Ubah Data User</h1>
    <a href="/user">Kembali</a>
    <br><br>

    <!-- 
        PERBAIKAN: 
        1. Tag <form> (bukan <from>)
        2. action mencantumkan ID user ($data->user_id)
    -->
    <form method="post" action="/user/ubah_simpan/{{ $data->user_id }}">
    
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Username</label>
        <!-- Tambahkan value="{{ $data->username }}" agar data lama muncul -->
        <input type="text" name="username" placeholder="Masukan Username" value="{{ $data->username }}">
        <br>

        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukan Nama" value="{{ $data->nama }}">
        <br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Masukan Password Baru">
        <br>

        <label>Level ID</label>
        <input type="number" name="level_id" placeholder="Masukan ID level" value="{{ $data->level_id }}" min="1" max="3">
        <br><br>
        
        <!-- Perbaikan attribute class -->
        <input type="submit" class="btn btn-success" value="Simpan">

    </form>
</body>
</html>