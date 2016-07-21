
<div class="post-title-div">
	<div class="votes-section">
		<img class="vote-arrow upvote" src="/img/inactive-upvote.png"/>
		<p class="vote-counter">0</p>
		<img class="vote-arrow downvote" src="/img/inactive-downvote.png"/>
	</div>
	<div class="post-section">
		<a href="{{ $post['href'] }}" class="post-link">{{ $post->title }}</a>
		<p class="submission-info">Submitted {{ $post->timeSincePosted() }} <a href="#">{{ $post->user['name'] }}</a> to {{ $post->subreddit['name'] }}</p>
		<a href="#" class="link-to-comments">#comments</a>
	</div>
</div>
