@extends("layouts.site")

@section("title", "Tambahkan Invoice Baru")

@section("extra-head")
    <link rel="stylesheet" type="text/css" href="{{ asset("css/bootstrap-datetimepicker.min.css") }}">
@endsection

@section("content")
<div class="container">
    <div class="row small-container">
        <div class="col-md-12">
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

                    <div class="form-group {{ $errors->has("transaction_date") ? "has-error" : "" }}">
                        <label class="control-label"> Tanggal Transaksi </label>
                        <input class="date-control form-control" type="text" name="transaction_date"
                            value="{{ Date::now()->format("d-m-Y H:i:s") }}"
                            >
                        @if ( $errors->has("transaction_date") )
                            <span class="help-block"> {{ $errors->first("transaction_date") }} </span>
                        @endif
                    </div>

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
</div>
@endsection

@section("script")
    <script type="text/javascript" src="{{ asset("js/moment-with-locales.js") }}"></script>
    <script type="text/javascript" src="{{ asset("js/bootstrap-datetimepicker.min.js") }}"></script>

    <script>
        $("input.date-control").datetimepicker({
            locale: moment.locale("id"),
            format: "DD-MM-YYYY HH:mm:ss"
        });
    </script>
@endsection