<div class="form-group">
    <label for="inputTags">Теги </label>
    <input type="text" class="form-control" id="inputTags" placeholder="Введите теги (разделитель &quot;, &quot;)"
           name="tags"
           value="{{ old('tags', $default ?? '') }}">
</div>
