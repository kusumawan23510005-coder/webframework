<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <h1>From Tambah Data User</h1>
    <form method="post" action="/user/tambah_simpan">
    
    {{ csrf_field() }}

    <label>Username</label>
    <input type="text" name="username" placeholder="Masukan Username">
    <br>
    <label>Nama</label>
    <input type="text" name="nama" placeholder="Masukan Nama">
    <br>
    <label>Password</label>
    <input type="password" name="password" placeholder="Masukan Password">
    <br>
    <label>Level ID</label>
    <input type="number" name="level_id" placeholder="Masukan ID level" min="1" max="3">
    <br><br>
    <input type="submit" class="btn btn-succcess" value="Simpan">

    </from>
</body>
</html>