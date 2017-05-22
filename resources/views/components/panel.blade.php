<div class="panel panel-default">
    <div class="panel-heading"> {{ $title }} </div>
    <div class="panel-body">
        {{ $slot }}
    </div>

    @isset($footer)
    <div class="panel-footer"> {{ $footer }} </div>
    @endisset

</div>