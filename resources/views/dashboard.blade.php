@extends('layouts.site')

@section("title", "Dashboard")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @component("components.panel")
                @slot("title")
                    <span class="glyphicon glyphicon-user"></span>
                    Detail Akun Anda
                @endslot

            <div>
                <h5> <strong> Nama Asli: </strong> </h5>
                <p> {{ Auth::user()->name }} </p>
            </div>

            <div>
                <h5> <strong> Nama Pengguna:</strong>  </h5>
                <p> {{ Auth::user()->username }} </p>
            </div>

            <div>
                <h5> <strong> Status:</strong>  </h5>
                <p>
                    @if (Auth::user()->isAdmin())
                    <span class="label label-danger"> Administrator </span>
                    @elseif (Auth::user()->isManager())
                    <span class="label label-warning"> Manajer </span>
                    @else
                    <span class="label label-success"> Karyawan </span>
                    @endif
                </p>
            </div>
                
            @endcomponent
        </div>
        <div class="col-md-9">
            <div class="jumbotron">
                <img width="300px" height="auto" style="display: inline-block; margin: auto;" src="{{ asset("images/small_logo.jpg") }}">
                <h3>
                    Selamat datang di Sistem Inventori dan Kasir Kawaii Photo Studio.
                </h3>
                

                </div>
            <h2>
            </h2>
        </div>
    </div>
</div>
@endsection
