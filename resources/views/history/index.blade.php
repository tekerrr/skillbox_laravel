<hr>
<h5>История изменений</h5>
@forelse ($history as $author)
    <h6>{{ $author->name }}</h6>
    <p class="blog-post-meta">{{ $author->pivot->created_at->diffForHumans() }}</p>
    <p>− {{ $author->pivot->before }}</p>
    <p>+ {{ $author->pivot->after }}</p>
@empty
    <p>Нет истории изменения</p>
@endforelse
