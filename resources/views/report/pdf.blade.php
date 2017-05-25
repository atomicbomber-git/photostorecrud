<!DOCTYPE html>
<html>
    <head>
        <title> Laporan </title>

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

            table.report td.borderless {
                border: none;
            }

            table.report {
                width: 100%;
                border-collapse: collapse;
            }

            table.report th {
                background: black;
                color: white;
            }

            table.report td, table.report th {
                border: thin solid black;
                padding: 5px;
            }
        </style>

    </head>
    <body>
        <h1> Laporan </h1>
        <h2>
            @if ($start_date->eq($end_date))
                {{ $start_date->format('l, j F Y') }}
            @else
                {{ $start_date->format('l, j F Y') }} - {{ $end_date->format('l, j F Y') }}
            @endif
        </h2>

        <div style="height: 50px"></div>

        <table class="report">
            <thead>
                <tr>
                    <th> No. </th>
                    <th> Kode Invoice </th>
                    <th> Nama Pelanggan </th>
                    <th> Nama Karyawan </th>
                    <th class="numeric"> Pemasukan </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $invoice->code() }} </td>
                    <td> {{ $invoice->customer_name }} </td>
                    <td> {{ $invoice->user->name }} </td>
                    <td class="numeric"> Rp. {{ number_format($invoice->finalSum(), 2, ',', '.') }} </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="borderless"> </td>
                    <td style="font-weight: bold"> Total: </td>
                    <td style="font-weight: bold; text-align: right;"> Rp. {{ number_format($grand_total, 2, ",", ".") }} </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>