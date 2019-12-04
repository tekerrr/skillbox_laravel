<div class="blog-post">
    <h2 class="blog-post-title"><a href="{{ route('news.show', compact('news')) }}">{{ $news->title }}</a></h2>

    @include('tags.items', ['tags' => $news->tags])

    <p class="blog-post-meta">{{ $news->created_at->toformattedDateString() }}</p>
    <p>{{ $news->abstract }}</p>
</div>
