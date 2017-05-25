@extends("layouts.site")

@section("title", "Laporan")

@section("content")
<div class="container">
    <div class="medium-container">

        @component("components.panel")

        @slot("title")
        <span class="glyphicon glyphicon-book"> </span>
        Laporan
        @endslot

        @if(null !== session("message"))
        <div class="alert alert-success">
            {{ session("message") }}
        </div>  
        @endif

        @endcomponent
    </div>
</div>

@endsection