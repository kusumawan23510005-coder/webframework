<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <h1>Data user</h1>
    
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <!--<th>ID</th>
            <th>username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>-->
            <th>jumlah pengguna</th>
        
        </tr>
        {{--@foreach ($data as $d)--}}
        {{--<tr>
            <td>{{ $data->user_id }}</td>
            <td>{{ $data->username }}</td>
            <td>{{ $data->nama }}</td>
            <td>{{ $data->level_id }}</td>
        </tr>--}}

        <tr>

            <td>{{ $data }} </td>
        </tr>
      {{--@endforeach --}}
    </table>
</body>
</html>