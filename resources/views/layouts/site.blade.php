<!DOCTYPE html>
<html lang="id">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> @yield("title") </title>
        <link rel="stylesheet" type="text/css" href="{{ asset("css/bootstrap.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("css/custom.css") }}">
        @yield("extra-head")
    </head>

    <body>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsible-navbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand">
                        Sistem Inventaris Toko
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="collapsible-navbar">
                    <ul class="nav navbar-nav">
                        @if(Auth::check())
                        <li class="{{ Route::currentRouteName() == "dashboard" ? "active" : "" }}"> 
                            <a href="{{ route("dashboard") }}">
                                <span class="glyphicon glyphicon-home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="{{ explode(".", Route::currentRouteName())[0] === "item" ? "active" : "" }}">
                            <a href="{{ route("category.index") }}" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-list-alt"></span>
                                Barang
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{ Route::currentRouteName() == "item.index" ? "active" : "" }}"> <a href="{{ route("item.index") }}"> Semua Barang </a> </li>

                                @can("manage-items")
                                    <li class="{{ Route::currentRouteName() == "item.create" ? "active" : "" }}"> <a href="{{ route("item.create") }}"> Tambah Barang </a> </li>
                                @endcan
                            </ul>
                        </li>
                        @endif

                        @if(Auth::check())
                        <li class="{{ explode(".", Route::currentRouteName())[0] === "invoice" ? "active" : "" }}">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-usd"></span>
                                Invoice
                            </a>
                            <ul class="dropdown-menu">
                                <li> <a href="{{ route("invoice.index") }}"> Invoice Pending </a> </li>
                                <li> <a href="{{ route("invoice.finishedIndex") }}"> Invoice Selesai </a> </li>
                                <li> <a href="{{ route("invoice.create") }}"> Buat Invoice Baru </a> </li>
                            </ul>
                        </li>
                        @endif

                        @can("access-reports")
                        <li class="{{ Route::currentRouteName() == "report.index" ? "active" : "" }}">
                            <a href="{{ route("report.index") }}">
                                <span class="glyphicon glyphicon-book"></span>
                                Laporan
                            </a>
                        </li>
                        @endcan
                        
                        @can("manage-categories")
                        <li class="{{ explode(".", Route::currentRouteName())[0] === "category" ? "active" : "" }}">
                            <a href="{{ route("category.index") }}" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-list"></span>
                                Kategori
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{ Route::currentRouteName() == "category.index" ? "active" : "" }}"> <a href="{{ route("category.index") }}"> Semua Kategori </a> </li>
                                <li class="{{ Route::currentRouteName() == "category.create" ? "active" : "" }}"> <a href="{{ route("category.create") }}"> Tambah Kategori </a> </li>
                            </ul>
                        </li>
                        @endcan

                        @can("manage-users")
                        <li class="{{ explode(".", Route::currentRouteName())[0] === "user" || Route::currentRouteName() === "register" ? "active" : "" }}">

                            <a href="{{ route("user.index") }}" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-user"></span>
                                Pengguna
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{ Route::currentRouteName() == "user.index" ? "active" : "" }}"> <a href="{{ route("user.index") }}"> Semua Pengguna </a> </li>
                                <li class="{{ Route::currentRouteName() == "user.create" ? "active" : "" }}"> <a href="{{ route("register") }}"> Tambah Pengguna </a> </li>
                            </ul>
                        </li>
                        @endcan

                    </ul>

                    @if (Auth::check())
                        <form method="POST" action="{{ route("logout") }}" class="navbar-form navbar-right">
                            {{ csrf_field() }}
                            <button class="btn btn-default">
                                <span class="glyphicon glyphicon-log-out"></span>
                                Keluar
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </nav>

        @yield("content")

        <script type="text/javascript" src="{{ asset("js/jquery-3.2.1.min.js") }}"></script>
        <script type="text/javascript" src="{{ asset("js/bootstrap.min.js") }}"></script>

        @yield("script")
    </body>
</html>