@extends("layouts.site")

@section("title", "Halaman Masuk")

@section("content")
<div class="container">
    <div class="small-container">
        @component("components.panel")
            @slot("title")
                <span class="glyphicon glyphicon-log-in"> </span> Masuk
            @endslot

            <form id="login-form" method="POST" action="{{ route("login") }}">
                <div class="form-group {{ $errors->has("username") ? "has-error" : "" }}">
                    <label class="control-label"> Nama Pengguna: </label>
                    <input value="{{ old("username") }}" class="form-control" type="text" name="username" autofocus>
                    @if ($errors->has("username"))
                        <span class="help-block"> {{ $errors->first("username") }} </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has("password") ? "has-error" : "" }}">
                    <label class="control-label"> Kata Sandi: </label>
                    <input value="{{ old("password") }}" class="form-control" type="password" name="password">
                    @if ($errors->has("password"))
                        <span class="help-block"> {{ $errors->first("password") }} </span>
                    @endif
                </div>

                @slot("footer")
                <div style="text-align: right;">
                    <button type="submit" form="login-form" class="btn btn-primary">
                        Masuk
                        <span class="glyphicon glyphicon-log-in"></span>
                    </button>
                </div>
                @endslot

                {{ csrf_field() }}
            </form>
        @endcomponent
    </div>
</div>
@endsection