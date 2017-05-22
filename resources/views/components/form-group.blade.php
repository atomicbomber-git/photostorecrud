<div class="form-group {{ $errors->has($name) ? "has-error" : "" }}">
    <label class="control-label"> {{ $label }} </label>
    
    @if ($field_type === "input")
        <input class="form-control" type="{{ $type }}" name="{{ $name }}" value="{{ isset($value) ? $value : old($name) }}"></input>
    @elseif($field_type === "textarea")
        <textarea class="form-control" name="{{ $name }}" value="{{ old($name) }}">{{ isset($value) ? $value : old($name) }}</textarea>
    @endif

    @if ($errors->has($name))
        <span class="help-block"> {{ $errors->first($name) }} </span>
    @endif
</div>