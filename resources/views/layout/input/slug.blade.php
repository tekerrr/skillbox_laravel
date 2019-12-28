<div class="form-group">
    <label for="inputSlug">Символьный код</label>
    <input type="text" class="form-control" id="inputSlug" placeholder="Введите символьный код"
           name="slug"
           value="{{ old('slug', $default ?? '') }}">
</div>
