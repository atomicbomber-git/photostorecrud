@extends("layouts.site")

@section("title")
    Tambahkan Kategori Baru
@endsection

@section("content")
<div class="container">
    <div class="small-container">
        
        @component("components.panel")
            @slot("title")
                <span class="glyphicon glyphicon-plus"> </span>
                Tambahkan Kategori Baru 
            @endslot

            <form id="category-add-form" method="POST" action="{{ route("category.store") }}">
                
                @component("components.form-group", [
                    "name" => "name",
                    "label" => "Nama Kategori:",
                    "type" => "text",
                    "field_type" => "input"
                ]) @endcomponent

                @component("components.form-group", [
                    "name" => "description",
                    "label" => "Deskripsi:",
                    "field_type" => "textarea"
                ]) @endcomponent

                

                {{ csrf_field() }}
            </form>

                @slot("footer")
                <div style="text-align: right">
                    <button type="submit" form="category-add-form" class="btn btn-primary">
                        Simpan
                        <span class="glyphicon glyphicon-ok"></span>
                    </button>
                </div>
                @endslot
        @endcomponent
    </div>
</div>
@endsection