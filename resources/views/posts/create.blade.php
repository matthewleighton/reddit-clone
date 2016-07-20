@extends('layout')

@section('content')
	<div id="post-creation-form">
		<h1>Submit a new post</h1>

		<div id="post-type-selector-area">
			<div class="post-type-selector selected" id="link-selector">
				<p hidden>link</p>
				Sharing a link
			</div>
			<div class="post-type-selector" id="text-selector">
				<p hidden>text</p>
				Creating a text post
			</div>
		</div>

		<form method="POST">
			

			<input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
			<input type="hidden" name="post-type" value="" id="post-type-input">

			
			<input type="text" name="title" placeholder="Title" value="{{ session('title') }}">

			<input type="text" name="url" placeholder="url" value="{{ session('url') }}" id="link-input" class="post-type-field">
			<textarea name="text" placeholder="Text" id="text-input" class="post-type-field"></textarea><br/>

			<input type="text" name="subreddit" placeholder="Choose a subreddit" value="{{ session('subreddit') }}">


			<button type="submit" class="user-submit">Submit post</button>
		</form>
	</div>
@stop