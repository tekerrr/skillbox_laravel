<hr>
<h5>История изменений</h5>
@forelse ($history as $author)
    <p>{{ $author->name }} - {{ $author->pivot->created_at->diffForHumans() }} = {{ $author->pivot->before }} - {{ $author->pivot->after }}</p>
@empty
    <p>Нет истории изменения</p>
@endforelse
