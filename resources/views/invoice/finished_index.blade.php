@extends("layouts.site")

@section("title", "Invoice")

@section("content")
<div class="container">
    <div class="large-container">

        @component("components.panel")

        @slot("title")
        <span class="glyphicon glyphicon-list"> </span>
        Daftar Seluruh Invoice Selesai
        @endslot

        @if(null !== Request::session()->get("message"))
        <div class="alert alert-success">
            {{ Request::session()->get("message") }}
        </div>  
        @endif

        <div style="text-align: right; padding: 6px">
            <a href="{{ route("invoice.create") }}" class="btn btn-default btn-xs">
                Tambahkan Invoice Baru
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th> No. </th>
                        <th> Nama Pelanggan </th>
                        <th> Alamat Pelanggan </th>
                        <th> Waktu / Tanggal </th>
                        <th> No. Telepon Pelanggan </th>
                        <th> Nama Penanggungjawab </th>
                        <th> Kendali </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $invoice->customer_name }} </td>
                        <td> {{ $invoice->customer_address }} </td>
                        <td> {{ $invoice->localDate() }} </td>
                        <td> {{ $invoice->customer_phone }} </td>
                        <td> {{ $invoice->user ? $invoice->user->name : "" }} </td>
                        <td>
                            <a class="btn btn-default btn-xs" href="{{ route("invoice.show", ["id" => $invoice->id]) }}">
                                Kelola
                                <span class="glyphicon glyphicon-list"></span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endcomponent
    </div>
</div>

@endsection