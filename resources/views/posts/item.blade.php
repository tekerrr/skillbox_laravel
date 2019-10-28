<div class="blog-post">
    <h2 class="blog-post-title"><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></h2>
    <p class="blog-post-meta">{{ $post->created_at->toformattedDateString() }}</p>
    <p>{{ $post->abstract }}</p>
</div>
