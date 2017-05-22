@extends("layouts.site")

@section("title", "Sunting Kategori")

@section("content")
<div class="container">
    <div class="small-container">
        
        @component("components.panel")
            @slot("title")
                <span class="glyphicon glyphicon-plus"> </span>
                Sunting Kategori 
            @endslot

            <form id="edit-category-form" method="POST" action="{{ route("category.update", ["id" => $category->id]) }}">
                
                @component("components.form-group", [
                    "name" => "name",
                    "label" => "Nama Kategori:",
                    "type" => "text",
                    "value" => $category->name,
                    "field_type" => "input"
                ]) @endcomponent

                @component("components.form-group", [
                    "name" => "description",
                    "label" => "Deskripsi:",
                    "value" => $category->description,
                    "field_type" => "textarea"
                ]) @endcomponent

                {{ csrf_field() }}
                {{ method_field("PATCH") }}
            </form>

            @slot("footer")
            <div style="text-align: right">
                <button form="edit-category-form" class="btn btn-primary">
                    Setujui Perubahan
                    <span class="glyphicon glyphicon-ok"></span>
                </button>
            </div>
            @endslot

        @endcomponent
    </div>
</div>
@endsection