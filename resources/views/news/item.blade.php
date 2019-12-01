<div class="blog-post">
    <h2 class="blog-post-title"><a href="/news/{{ $oneNews->slug }}">{{ $oneNews->title }}</a></h2>

    @include('tags.items', ['tags' => $oneNews->tags])

    <p class="blog-post-meta">{{ $oneNews->created_at->toformattedDateString() }}</p>
    <p>{{ $oneNews->abstract }}</p>
</div>
