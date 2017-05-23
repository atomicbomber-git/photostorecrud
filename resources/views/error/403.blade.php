@extends('layouts.site')

@section("title", "Tidak Diizinkan")

@section('content')
<div class="container">
    <div class="small-container">
        @component("components.panel")
            @slot("title")
            <span class="glyphicon glyphicon-warning-sign"></span>
            Error
            @endslot
        <div class="alert alert-danger">
            Maaf, Anda tidak diizinkan untuk mengakses halaman ini / melakukan
            tindakan ini.
            <a href="javascript:history.back()"> Kembali </a>
        </div>
        @endcomponent
    </div>
</div>
@endsection
