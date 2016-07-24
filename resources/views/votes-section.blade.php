<div class="votes-section">
	<img class="vote-arrow upvote" src="/img/inactive-upvote.png"/>
	@if (!isset($comment))
		<p class="vote-counter">{{ $post['score'] }}</p>
	@endif
	<img class="vote-arrow downvote" src="/img/inactive-downvote.png"/>
</div>