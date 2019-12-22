<div class="form-group">
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" name="{{ $name }}" id="{{ $name }}" {{ isset($checked) ? 'checked' : '' }}>
        <label class="custom-control-label" for="{{ $name }}">{{ $text }}</label>
    </div>
</div>
