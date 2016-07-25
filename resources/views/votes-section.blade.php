<!--<div class="votes-section">
	<img class="vote-arrow upvote" src="/img/inactive-upvote.png"/>
	@if (!isset($comment))
		<p hidden class='vote-type'>post</p>
		<p hidden class='vote-id'>{{ $post['id'] }}</p>
		<p class="vote-counter">{{ $post['score'] }}</p>
	@else
		<p hidden class='vote-type'>comment</p>
		<p hidden class='vote-id'>{{ $comment['id'] }}</p>
	@endif
	<img class="vote-arrow downvote" src="/img/inactive-downvote.png"/>
</div>-->


@if (!isset($comment))
	{{ $comment = false }}
@endif

<div class="votes-section">

	{!! generateVoteArrow($post, $comment, 'up') !!}
	<!--<img class="vote-arrow upvote" src="/img/inactive-upvote.png"/>-->
	@if ($comment)
		<p hidden class='vote-type'>comment</p>
		<p hidden class='vote-id'>{{ $comment['id'] }}</p>
	@else
		<p hidden class='vote-type'>post</p>
		<p hidden class='vote-id'>{{ $post['id'] }}</p>
		<p class="vote-counter">{{ $post['score'] }}</p>
	@endif
	<!--<img class="vote-arrow downvote" src="/img/inactive-downvote.png"/>-->
	{!! generateVoteArrow($post, $comment, 'down') !!}
</div>