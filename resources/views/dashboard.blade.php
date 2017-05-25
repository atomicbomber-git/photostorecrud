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
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
        </div>
    </div>
</div>
@endsection
