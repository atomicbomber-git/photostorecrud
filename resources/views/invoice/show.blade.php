@extends("layouts.site")

@section("title", "Detail Invoice")

@section("content")
<div class="container">
    <div class="row">
        <div class="col-md-4">
            @component("components.panel")

            @slot("title")
            <span class="glyphicon glyphicon-list"> </span>
            Ubah Data Invoice
            @endslot

            @if(null !== Request::session()->get("message"))
            <div class="alert alert-success">
                {{ Request::session()->get("message") }}
            </div>  
            @endif

            <form id="invoice-update-form" method="POST" action="{{ route("invoice.update", ["id" => $invoice->id]) }}">    
                @component("components.form-group", [
                    "name" => "customer_name",
                    "label" => "Nama Pelanggan:",
                    "type" => "text",
                    "field_type" => "input",
                    "value" => $invoice->customer_name
                ]) @endcomponent

                @component("components.form-group", [
                    "name" => "customer_phone",
                    "label" => "No. Telepon Pelanggan:",
                    "type" => "phone",
                    "field_type" => "input",
                    "value" => $invoice->customer_phone
                ]) @endcomponent

                @component("components.form-group", [
                    "name" => "customer_address",
                    "label" => "Alamat Pelanggan:",
                    "field_type" => "textarea",
                    "value" => $invoice->customer_address
                ]) @endcomponent

                    @slot("footer")
                    <div style="text-align: right">
                        <button type="submit" form="invoice-update-form" class="btn btn-primary">
                            Ubah Data Invoice
                            <span class="glyphicon glyphicon-ok"></span>
                        </button>
                    </div>
                    @endslot

                {{ csrf_field() }}
                {{ method_field("PATCH") }}
            </form>

            @endcomponent
        </div>
        <div class="col-md-8">
            @component("components.panel")

            @slot("title")
            <span class="glyphicon glyphicon-plus"> </span>
            Tambahkan Item ke Invoice
            @endslot

            <form id="invoice-item-add-form" method="POST" action="{{ route("invoice.store") }}">
            </form>

            @endcomponent
        </div>
        
    </div>
</div>

@endsection