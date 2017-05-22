@extends("layouts.site")

@section("title", "Daftar Seluruh Barang")

@section("content")
<div class="container">
    @component("components.panel")

    @slot("title")
    <span class="glyphicon glyphicon-list"> </span>
    Daftar Seluruh Barang
    @endslot

    @if(null !== Request::session()->get("message"))
    <div class="alert alert-success">
        {{ Request::session()->get("message") }}
        <a href={{route("item.restore", ["id" => Request::session()->get("deleted_item_id")])}}> Batalkan penghapusan. </a>

    </div>  
    @endif

    <div style="text-align: right; padding: 6px">
        <a href="{{ route("item.create") }}" class="btn btn-default btn-xs">
            Tambahkan Barang Baru
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </div>

    <div class="row">
        @foreach ($items as $item)
        <div class="col-md-4">
            <div class="thumbnail">
                <img src="{{ asset("storage/thumbnails/$item->image") }}">
                <div class="caption">
                    <h3> {{ $item->name }} </h3>
                    <p> {{ $item->description }} </p>
                    <p>
                        <div style="text-align: right">
                            <a class="btn btn-default btn-xs" href="{{ route("item.show", ["id" => $item->id]) }}">
                                Detail
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </a>

                            @can("manage-items")
                            <a class="btn btn-default btn-xs" href="{{ route("item.edit", ["id" => $item->id]) }}">
                                Sunting
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <form style="display: inline-block;" method="POST" action="{{ route("item.destroy", ["id" => $item->id]) }}">
                                <button class="btn btn-danger btn-xs">
                                    Nonaktifkan
                                    <span class="glyphicon glyphicon-trash"></span>
                                    {{ csrf_field() }}
                                    {{ method_field("DELETE") }}
                                </button>
                            </form>
                        @endcan
                        </div>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @endcomponent
</div>

@endsection