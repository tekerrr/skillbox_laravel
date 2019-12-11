<h5>{{ $comment->user->name }}</h5>
<p class="blog-post-meta">{{ $comment->created_at->toformattedDateString() }}</p>
<p>{{ $comment->body }}</p>
