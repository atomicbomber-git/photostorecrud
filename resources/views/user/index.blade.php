@extends('layouts.site')

@section("title", "Daftar Seluruh Pengguna")

@section('content')
<div class="container">
    <div class="medium-container">
        @component("components.panel")
            @slot("title")
            <span class="glyphicon glyphicon-user"></span>
            Daftar Seluruh Pengguna
            @endslot

        @if(null !== Request::session()->get("message"))
            <div class="alert alert-success"> {{ Request::session()->get("message") }} </div>
        @endif

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
        @endforeach

        <div class="well well-sm">
            <strong> Keterangan: </strong> Baris yang berwarna biru melambangkan data pengguna Anda sendiri
        </div>
        
        <div style="text-align: right; padding: 6px">
            <a href="{{ route("user.create") }}" class="btn btn-default btn-xs">
                Tambahkan Pengguna Baru
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th> No. </th>
                        <th> Nama Lengkap (Asli) </th>
                        <th> Nama Pengguna </th>
                        <th> Status </th>
                        <th> Kendali </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="{{ Auth::user()->id === $user->id ? "success" : "" }}">
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $user->name }} </td>
                        <td> {{ $user->username }} </td>
                        <td>
                            @if ($user->privilege === "CLERK")
                                <span class="label label-default"> Karyawan </span>
                            @elseif($user->privilege === "MANAGER")
                                <span class="label label-warning"> Manajer </span>
                            @elseif($user->privilege === "ADMINISTRATOR")
                                <span class="label label-danger"> Administrator </span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-default btn-xs" href="{{ route("user.edit", ["id" => $user->id]) }}">
                                Sunting
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>

                            @if (Auth::id() != $user->id)
                            <form style="display: inline-block;" method="POST" action="{{ route("user.destroy", ["id" => $user->id]) }}">
                                <button class="btn btn-danger btn-xs"> 
                                    Hapus
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                                {{ csrf_field() }}
                                {{ method_field("DELETE") }}
                            </form>
                            @endif
                                
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @endcomponent
    </div>
</div>
@endsection
