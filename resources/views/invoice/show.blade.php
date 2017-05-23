@extends("layouts.site")

@section("title", "Detail Invoice")

@section("content")
<div class="container">
    <div class="large-container">

        @component("components.panel")

        @slot("title")
        <span class="glyphicon glyphicon-list"> </span>
        Detail Invoice
        @endslot

        @if(null !== Request::session()->get("message"))
        <div class="alert alert-success">
            {{ Request::session()->get("message") }}
        </div>  
        @endif

        @endcomponent
    </div>
</div>

@endsection