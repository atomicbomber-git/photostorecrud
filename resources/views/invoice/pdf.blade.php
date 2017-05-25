<!DOCTYPE html>
<html>
    <head>
        <title> INVOICE {{ $invoice->created_at->format("Ymdhis") }} </title>

        <style>
            h1, h2 {
                text-align: center;
                margin-top: 5px;
                margin-bottom: 5px;
            }

            .align-right {
                text-align: right;
            }

            .bold {
                font-weight: bold;
            }

            .container {
                margin-bottom: 20px;
                margin-top: 20px;
            }

            .numeric {
                text-align: right;
            }

            table.invoice td.borderless {
                border: none;
            }

            table.invoice {
                width: 100%;
                border-collapse: collapse;
            }

            table.invoice th {
                background: black;
                color: white;
            }

            table.invoice td, table.invoice th {
                border: thin solid black;
                padding: 5px;
            }
        </style>

    </head>
    <body>
        <h1> INVOICE </h1>
        <h2> NO: {{ $invoice->created_at->format("Ymdhis") }} </h2>

        <div class="container">
            <table>
                <tbody>
                    <tr>
                        <td class="align-right bold"> Hari, Tanggal: </td> <td> : </td> <td> {{ $invoice->localDate() }} </td>
                    </tr>
                    <tr>
                        <td class="align-right bold"> Nama Pelanggan: </td> <td> : </td> <td> {{ $invoice->customer_name }} </td>
                    </tr>
                    <tr>
                        <td class="align-right bold"> Alamat Pelanggan: </td> <td> : </td> <td> {{ $invoice->customer_address }} </td>
                    </tr>
                    <tr>
                        <td class="align-right bold"> No. Telp Pelanggan: </td> <td> : </td> <td> {{ $invoice->customer_phone }} </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table class="invoice">
            <thead>
                <tr>
                    <th> No. </th>
                    <th> Nama Item </th>
                    <th class="numeric"> Harga per Item </th>
                    <th class="numeric"> Jumlah </th>
                    <th class="numeric"> Subtotal </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->invoiceitems as $invoiceitems)
                <tr>
                    <td> {{ $loop->iteration }}. </td>
                    <td> {{ $invoiceitems->name }} </td>
                    <td class="numeric"> {{ "Rp. " . number_format($invoiceitems->price, 2, ",", ".") }} </td>
                    <td class="numeric"> {{ $invoiceitems->quantity }} </td>
                    <td class="numeric"> {{ "Rp. " . number_format($invoiceitems->quantity * $invoiceitems->price, 2, ",", ".") }} </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="borderless" colspan="3"></td>
                    <td class="borderless" style="text-align: right; font-weight: bold">
                        Total:
                    </td>
                    <td class="numeric" style="font-weight: bold">
                        Rp. {{ number_format($invoice->finalSum(), 2, ",", ".") }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>