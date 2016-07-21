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

			<input type="hidden" name="textpost" value="{{ $textpost }}" id="textpost-field">

			
			<input class="wide-field" type="text" name="title" placeholder="Title" value="{{ old('title') }}">
			<p class="user-error">{{ $errors->first('title') }}</p>

			<div class="post-type-field" id="link-input">
				<input class="wide-field" type="text" name="url" placeholder="url" value="{{ old('url') }}">
				<p class="user-error">{{ $errors->first('url') }}</p>	
			</div>
			
			<div class="post-type-field" id="text-input">
				<textarea class="wide-field" name="body" placeholder="Text">{{ old('body') }}</textarea><br/>
				<p class="user-error">{{ $errors->first('body') }}</p>	
			</div>
			

			<input class="wide-field" type="text" name="subreddit" placeholder="Choose a subreddit" value="{{ old('subreddit') }}">
			<p class="user-error">{{ $errors->first('subreddit') }}</p><br/>

			<br/>
			<button type="submit" class="user-submit">Submit post</button>
		</form>
	</div>
@stop