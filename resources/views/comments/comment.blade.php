<div class="comment-container {{ $comment->addChildClass() }}">
	<form class="form-closed" method="POST" action="/comments/save" >
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
		<input type="hidden" name="post_id" value="{{ $post['id'] }}">
		<input type="hidden" name="parent_id" value="{{ $comment['id'] }}">

		<span class="comment-votes">@include('votes-section')</span>
		<div class="comment-main">
			<div class="comment-info">
				<span class="minimize-btn">[-]</span><span class='maximize-btn'>[+]</span>
				<a href='#'>{{ $comment->user['name'] }}</a> {{ $comment->displayScore() }} {{ $comment->created_at->diffForHumans() }}
			</div>
			<div class="comment-body {{ $comment->permalinkClass($permalinkId) }}">
				{{ $comment['body'] }}
			</div>
			<ul class="comment-actions">
				<li><a href="{{ appRoot() }}r/{{ $subreddit['name'] . '/comments/' . $post['id'] . '/' .$comment['id'] }}">perma-link</a></li>
				@if (Auth::user())
					<li><a href="javascript:void(0)" class="comment-reply-btn">reply</a></li>
				@endif
			</ul>
		</div>
	</form>

	@foreach($comment->children as $comment)
		@include('comments.comment')
	@endforeach
</div>