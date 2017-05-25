@extends("layouts.site")

@section("title", "Laporan")

@section("extra-head")
    <link rel="stylesheet" type="text/css" href="{{ asset("css/bootstrap-datepicker3.min.css") }}">
@endsection

@section("content")
<div class="container">
    <div class="medium-container">

        @component("components.panel")

        @slot("title")
        <span class="glyphicon glyphicon-book"> </span>
        Cetak Laporan
        @endslot

        @if(null !== session("message"))
        <div class="alert alert-success">
            {{ session("message") }}
        </div>  
        @endif

        <div class="alert alert-info">
            <strong> Keterangan: </strong>
            Samakan tanggal mulai dan tanggal akhir untuk mendapatkan
            laporan untuk hari tunggal.
        </div>

        <form id="print-report-form" method="GET" action="{{ route("report.pdf") }}">
            <div class="form-group {{ $errors->has("start_date") ? "has-error" : "" }}">
                <label class="control-label"> Tanggal Mulai: </label>
                <input class="date-control form-control" name="start_date" value="{{ old("start_date") ? old("start_date") : $today }}">
                @if ($errors->has("start_date"))
                    <span class="help-block"> {{ $errors->first("start_date") }} </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has("end_date") ? "has-error" : "" }}">
                <label class="control-label"> Tanggal Akhir: </label>
                <input class="date-control form-control" name="end_date" value="{{ old("start_date") ? old("start_date") : $today }}">
                @if ($errors->has("end_date"))
                    <span class="help-block"> {{ $errors->first("end_date") }} </span>
                @endif
            </div>
        </form>

        @slot("footer")
        <div style="text-align: right">
            <button form="print-report-form" class="btn btn-primary btn-sm">
                Cetak Laporan
                <span class="glyphicon glyphicon-print"></span>
            </button>
        </div>
        @endslot

        @endcomponent
    </div>
</div>

@endsection

@section("script")
    <script type="text/javascript" src="{{ asset("js/bootstrap-datepicker.min.js") }}"></script>

    <script>
        $("input.date-control").datepicker({
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            language: "id"
        });
    </script>
@endsection