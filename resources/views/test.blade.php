@extends('layouts.site')

@section("title", "Dashboard")

@section('content')
<div class="container">
    <form method="POST" enctype="multipart/form-data" action="{{ route("upload") }}">
        <div class="form-group">
            <label class="control-label"> Whatever Else </label>
            <input name="image" type="file" accept="image/*">
        </div>

        {{ csrf_field() }}

        <button class="btn btn-default"> Save </button>
    </form>

    <img src="{{ Storage::url("images/l5nsOflWSGr9xqQwRC24pH138tXt2RDjiqKCxDrC.jpeg") }}">
</div>
@endsection
