@extends("layouts.site")

@section("title")
    Tambahkan Barang Baru
@endsection

@section("content")
<div class="container">
    <div class="small-container">
        
        @component("components.panel")
            @slot("title")
                <span class="glyphicon glyphicon-plus"> </span>
                Tambahkan Barang Baru
            @endslot

            <form id="item-add-form" enctype="multipart/form-data" method="POST" action="{{ route("item.store") }}">
                
                @component("components.form-group", [
                    "name" => "name",
                    "label" => "Nama:",
                    "type" => "text",
                    "field_type" => "input"
                ]) @endcomponent

                <div class="form-group {{ $errors->has("category_id") ? "has-error" : "" }}">
                    <label class="control-label"> Tipe: </label>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}"> {{ $category->name }} </option>
                        @endforeach
                    </select>
                    @if ($errors->has("category_id"))
                        <span class="help-block"> {{ $errors->first("category_id") }} </span>
                    @endif
                </div>

                @component("components.form-group", [
                    "name" => "description",
                    "label" => "Deskripsi:",
                    "field_type" => "textarea"
                ]) @endcomponent

                @component("components.form-group", [
                    "name" => "price",
                    "label" => "Harga:",
                    "type" => "number",
                    "field_type" => "input"
                ]) @endcomponent

                @component("components.form-group", [
                    "name" => "stock",
                    "label" => "Stok:",
                    "type" => "number",
                    "field_type" => "input"
                ]) @endcomponent

                <div class="input-group {{ $errors->has("image") ? "has-error" : "" }}">
                    <label class="control-label"> Foto: </label>
                    <input name="image" type="file" accept="img/*">

                    @if ($errors->has("image"))
                        <span class="help-block"> {{ $errors->first("image") }} </span>
                    @endif
                </div>

                {{ csrf_field() }}
            </form>

                @slot("footer")
                <div style="text-align: right">
                    <button type="submit" form="item-add-form" class="btn btn-primary">
                        Simpan
                        <span class="glyphicon glyphicon-ok"></span>
                    </button>
                </div>
                @endslot
        @endcomponent
    </div>
</div>
@endsection