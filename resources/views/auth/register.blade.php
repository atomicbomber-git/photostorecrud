@extends('layouts.site')

@section("title", "Tambahkan Pengguna")

@section("content")
<div class="container">
    <div class="small-container">
        @component("components.panel")
            @slot("title")
                <span class="glyphicon glyphicon-user"> </span>
                Tambahkan Pengguna Baru
            @endslot

        <form id="register-form" method="POST" action={{ route("register") }}>
            <div class="form-group {{ $errors->has("name") ? "has-error" : "" }}">
                <label class="control-label"> Nama Lengkap </label>
                <input value="{{ old("name") }}" class="form-control" type="text" name="name" autofocus>
                @if ($errors->has("name"))
                    <span class="help-block"> {{ $errors->first("name") }} </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has("username") ? "has-error" : "" }}">
                <label class="control-label"> Nama Pengguna </label>
                <input value="{{ old("username") }}" class="form-control" type="text" name="username" autofocus>
                @if ($errors->has("username"))
                    <span class="help-block"> {{ $errors->first("username") }} </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has("privilege") ? "has-error" : "" }}">
                <label class="control-label"> Status Pengguna </label>

                <select class="form-control" name="privilege">
                    <option value="CLERK"> Pegawai </option>
                    <option value="MANAGER"> Manajer </option>
                    <option value="ADMINISTRATOR"> Administrator </option>
                </select>

                @if ($errors->has("privilege"))
                    <span class="help-block"> {{ $errors->first("privilege") }} </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has("password") ? "has-error" : "" }}">
                <label class="control-label"> Kata Sandi </label>
                <input class="form-control" type="password" name="password">
                @if ($errors->has("password"))
                    <span class="help-block"> {{ $errors->first("password") }} </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has("password_confirmation") ? "has-error" : "" }}">
                <label class="control-label"> Ulangi Kata Sandi </label>
                <input class="form-control" type="password" name="password_confirmation">
                @if ($errors->has("password_confirmation"))
                    <span class="help-block"> {{ $errors->first("password_confirmation") }} </span>
                @endif
            </div>

                @slot("footer")
                <div style="text-align: right;">
                    <button type="submit" form="register-form" class="btn btn-primary">
                        Tambahkan Pengguna
                        <span class="glyphicon glyphicon-ok"> </span>
                    </button>
                </div>
                @endslot

            {{ csrf_field() }}
        </form>

        @endcomponent
    </div>
</div>
@endsection
