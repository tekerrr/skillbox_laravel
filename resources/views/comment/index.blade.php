<hr>
@forelse ($comments as $comment)
    @include('comment.item')
@empty
    <p>Нет комментариев</p>
@endforelse
<hr>
<h5>Добавить комментарий</h5>
@auth
    @include('layout.errors')

    <form method="post" action="{{ $route }}">

        @csrf

        <div class="form-group">
            <textarea class="form-control" id="inputBody" rows="3" name="body">{{ old('body') }}</textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Добавить</button>
        </div>
    </form>
@else
    <p>Авторизируйтесь на сайте, чтобы оставить комментарий</p>
@endauth

