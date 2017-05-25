@extends("layouts.site")

@section("title", "Daftar Seluruh Kategori")

@section("content")
<div class="container">
    <div class="medium-container">

        @component("components.panel")

        @slot("title")
        <span class="glyphicon glyphicon-list"> </span>
        Daftar Seluruh Kategori
        @endslot

        @if(null !== Request::session()->get("message"))
        <div class="alert alert-success">
            {{ Request::session()->get("message") }}
        </div>  
        @endif

        <div style="text-align: right; padding: 6px">
            <a href="{{ route("category.create") }}" class="btn btn-default btn-xs">
                Tambahkan Kategori Baru
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th> No. </th>
                        <th> Nama </th>
                        <th> Deskripsi </th>
                        <th class="control"> Kendali </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $category->name }} </td>
                        <td> {{ $category->description }} </td>
                        <td class="control" style="min-width: 150px">
                            <a class="btn btn-default btn-xs" href="{{ route("category.edit", ["id" => $category->id]) }}"> Sunting <span class="glyphicon glyphicon-pencil"> </span> </a>
                            
                            <form method="POST" style="display: inline-block;" action="{{ route("category.destroy", ["id" => $category->id]) }}">
                                <button class="btn btn-danger btn-xs"> Hapus <span class="glyphicon glyphicon-trash"> </span> </button>
                                {{ csrf_field() }}
                                {{ method_field("DELETE") }}
                            </form>
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