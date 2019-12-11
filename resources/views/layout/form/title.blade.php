<div class="form-group">
    <label for="inputTitle">Название</label>
    <input type="text" class="form-control" id="inputTitle" placeholder="Введите название статьи"
           name="title"
           value="{{ old('title', $default ?? '') }}">
</div>
