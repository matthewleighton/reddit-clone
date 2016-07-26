@if (!isset($comment))
	{{ $comment = false }}
@endif

<div class="votes-section">

	{!! generateVoteArrow($post, $comment, 'up') !!}
	@if ($comment)
		<p hidden class='vote-type'>comment</p>
		<p hidden class='vote-id'>{{ $comment['id'] }}</p>
	@else
		<p hidden class='vote-type'>post</p>
		<p hidden class='vote-id'>{{ $post['id'] }}</p>
		<p class="vote-counter {{ getVoteCounterStatus($post, $comment) }}">{{ $post['score'] }}</p>
	@endif
	{!! generateVoteArrow($post, $comment, 'down') !!}
</div>