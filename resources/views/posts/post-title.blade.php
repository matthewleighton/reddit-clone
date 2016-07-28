<div class="post-title-div">
	@include('votes-section')
	<div class="post-section">
		<p><a href="{{ $post->postHref() }}" class="post-link">{{ $post->title }}</a> <span class="link-info">{{ $post->linkInfo() }}</span></p>
		<p class="submission-info">Submitted {{ $post->timeSincePosted() }} by <a href="#">{{ $post->user['name'] }}</a> to <a href="{{ appRoot() }}r/{{ $post->subreddit['name'] }}" > {{ $post->subreddit['name'] }}</a></p>

		@yield('textpost-body')
		
		<a href="{{ $post->commentsHref() }}" class="link-to-comments">{{ $post->commentsLinkText() }}</a>
	</div>
</div>
