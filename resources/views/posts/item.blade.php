<div class="blog-post">
    <h2 class="blog-post-title"><a href="{{ route('posts.show', compact('post')) }}">{{ $post->title }}</a></h2>

    @include('tags.items', ['tags' => $post->tags])

    <p class="blog-post-meta">{{ $post->created_at->toformattedDateString() }}</p>
    <p>{{ $post->abstract }}</p>
</div>
