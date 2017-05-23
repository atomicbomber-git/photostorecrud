@extends("layouts.site")

@section("title", "Tambahkan Invoice Baru")

@section("content")
<div class="container">
    <div class="small-container">
        
        @component("components.panel")
            @slot("title")
                <span class="glyphicon glyphicon-plus"> </span>
                Tambahkan Invoice Baru 
            @endslot

            <form id="invoice-add-form" method="POST" action="{{ route("invoice.store") }}">
                
                @component("components.form-group", [
                    "name" => "customer_name",
                    "label" => "Nama Pelanggan:",
                    "type" => "text",
                    "field_type" => "input"
                ]) @endcomponent

                @component("components.form-group", [
                    "name" => "customer_phone",
                    "label" => "No. Telepon Pelanggan:",
                    "type" => "phone",
                    "field_type" => "input"
                ]) @endcomponent

                @component("components.form-group", [
                    "name" => "customer_address",
                    "label" => "Alamat Pelanggan:",
                    "field_type" => "textarea"
                ]) @endcomponent

                {{ csrf_field() }}
            </form>

                @slot("footer")
                <div style="text-align: right">
                    <button type="submit" form="invoice-add-form" class="btn btn-primary">
                        Buat Invoice
                        <span class="glyphicon glyphicon-ok"></span>
                    </button>
                </div>
                @endslot
        @endcomponent
    </div>
</div>
@endsection