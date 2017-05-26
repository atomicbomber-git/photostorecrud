@extends("layouts.site")

@section("title", "Detail Invoice")

@section("extra-head")
    <link rel="stylesheet" type="text/css" href="{{ asset("css/bootstrap-datetimepicker.min.css") }}">
@endsection

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

                <div class="form-group {{ $errors->has("transaction_date") ? "has-error" : "" }}">
                    <label class="control-label"> Tanggal Transaksi </label>
                    <input class="date-control form-control" type="text" name="transaction_date"
                        value="{{ old("transaction_date") ?? $invoice->transaction_date->format("d-m-Y H:i:s") }}"
                        >
                    @if ( $errors->has("transaction_date") )
                        <span class="help-block"> {{ $errors->first("transaction_date") }} </span>
                    @endif
                </div>

                    @slot("footer")
                    <div style="text-align: right">
                        <button type="submit" form="invoice-update-form" class="btn btn-primary btn-sm">
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
            
            <div>
                @component("components.panel")

                    @slot("title")
                    <span class="glyphicon glyphicon-pencil"> </span>
                    Kelola Item Invoice
                    @endslot

                <fieldset>
                    <legend> Tambahkan Item ke Invoice </legend>
                    <form id="invoice-item-add-form" method="POST" action="{{ route("invoice.item.store", ["id" => $invoice->id]) }}">
                        <div class="form-group">
                            <label class="control-label"> Nama Item: </label>
                            <select class="form-control" name="item_id">
                                @foreach ($items as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group {{ $errors->has("quantity") ? "has-error" : "" }}">
                            <label class="control-label"> Jumlah: </label>
                            <input class="form-control" type="number" name="quantity">
                            @if ($errors->has("quantity"))
                                <span class="help-block"> {{ $errors->first("quantity") }} </span>
                            @endif
                        </div>

                        {{ csrf_field() }}

                        <div style="text-align: right;" class="form-group">
                            <button class="btn btn-primary btn-sm">
                                Tambahkan Item ke Invoice
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </div>
                    </form>
                </fieldset>

                <fieldset>
                    <legend> Daftar Item Invoice </legend>
                    
                    @if($errors->has("update_quantity"))
                    <div class="alert alert-danger">
                        {{ $errors->first("update_quantity") }}
                    </div>
                    @endif

                    @if ($errors->has("invoice_item"))
                        @foreach ($errors->get("invoice_item") as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <table class="table table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th> No. </th>
                                <th> Nama Item </th>
                                <th class="numeric"> Stock </th>
                                <th class="numeric"> Jumlah </th>
                                <th class="numeric"> Harga </th>
                                <th class="numeric"> Subtotal </th>
                                <th class="control"> Kendali </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoiceitems as $invoiceitem)
                            <tr>
                                <td> {{ $loop->iteration }}. </td>
                                <td> {{ $invoiceitem->item->name }} </td>
                                <td class="numeric"> {{ $invoiceitem->item->stock }} </td>
                                <td>
                                    <form id="update-quantity-form" action="{{ route("invoice.item.update_quantity", ["id" => $invoiceitem->id]) }}" method="POST">
                                        <input style="max-width: 50px" class="numeric" type="number" name="update_quantity" value="{{ $invoiceitem->quantity }}">
                                        {{ csrf_field() }}
                                        {{ method_field("PATCH") }}
                                    </form>
                                </td>
                                <td class="numeric"> {{ $invoiceitem->item->formattedPrice() }} </td>
                                <td class="numeric success"> {{ $invoiceitem->formattedSubtotal() }} </td>
                                <td class="control">
                                    <button form="update-quantity-form" class="btn btn-default btn-xs">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                        Perbaharui
                                    </button>
                                    <form class="inline-form" method="POST" action="{{ route("invoice.item.destroy", ["id" => $invoiceitem->id]) }}">
                                        <button class="btn btn-danger btn-xs"> 
                                            <span class="glyphicon glyphicon-trash"></span>
                                            Hapus
                                        </button>
                                        {{ csrf_field() }}
                                        {{ method_field("DELETE") }}
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align: right;">
                                    Total:
                                </th>
                                <th class="numeric success">
                                    {{ $total }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    <div style="text-align: right;">
                        <form style="display: inline-block;" method="POST" action="{{ route("invoice.destroy", ["id" => $invoice->id]) }}">
                            <button class="btn btn-danger btn-sm">
                                Hapus Invoice
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                            {{ csrf_field() }}
                            {{ method_field("DELETE") }}
                        </form>
                        <form style="display: inline-block;" method="POST" action="{{ route("invoice.finish", ["id" => $invoice->id]) }}">
                            <button class="btn btn-primary btn-sm">
                                Tandai Sebagai Selesai
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                            {{ csrf_field() }}
                            {{ method_field("PATCH") }}
                        </form>
                    </div>
                </fieldset>

                @endcomponent
            </div>
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