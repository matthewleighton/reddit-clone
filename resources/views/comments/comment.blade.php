<div class="comment-container {{ $comment->addChildClass() }}">
	<form class="comment-container form-closed" method="POST" action="/comments/save" >
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
		<input type="hidden" name="post_id" value="{{ $post['id'] }}">
		<input type="hidden" name="parent_id" value="{{ $comment['id'] }}">

		@include('votes-section')
		<div class="comment-main">
			<div class="comment-info">
				<span class="minimize-comment">[-]</span> 
				<a href='#'>{{ $comment->user['name'] }}</a> {{ $comment->displayScore() }} {{ $comment->created_at->diffForHumans() }}
			</div>
			<div class="comment-body">
				{{ $comment['body'] }}	
			</div>
			<div class="comment-actions">
				<a href="javascript:void(0)" class="comment-reply-btn">reply</a>
			</div>
		</div>
	</form>

	@foreach($comment->children as $comment)
		@include('comments.comment')
	@endforeach
</div>