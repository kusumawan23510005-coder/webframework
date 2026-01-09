@extends('layouts.template')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Halo, {{ auth()->user()->nama }}!!!</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        Selamat datang {{ auth()->user()->nama }}, ini adalah halaman utama dari aplikasi ini.
    </div>    
</div>
@endsection