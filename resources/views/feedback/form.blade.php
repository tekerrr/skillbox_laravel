@include('layout.errors')

<form method="post" action="/feedback">

    @csrf

    <div class="form-group">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control" id="inputEmail" placeholder="Введите email" name="email">
    </div>
    <div class="form-group">
        <label for="inputBody">Сообщение</label>
        <textarea class="form-control" id="inputBody" rows="3" name="body"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Отправить</button>
    </div>
</form>
