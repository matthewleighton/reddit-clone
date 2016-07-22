$(document).ready(function() {

	if ($("#post-creation-form").length) {
		var textpost = $('#textpost-field').val();

		if (getUrlVars()[0] == 'selfpost' || textpost == '1') {
			changePostType('text');
		}
	}

	// Selecting Post Type
	var postType = '';

	$('.post-type-selector').click(function() {
		postType = $(this).find('p').text();
		changePostType(postType);
	});

	function changePostType(postType) {
		var validPostTypes = ['link', 'text'];
		var inputId = "#" + postType + "-input";
		var selectorId = "#" + postType + "-selector"
		var textpost = postType == 'link' ? 0 : 1;
		
		if (validPostTypes.indexOf(postType) < 0) return;
		if ($(selectorId).hasClass('selected')) return;

		console.log("test?");

		$(".post-type-selector").removeClass('selected');
		$(selectorId).addClass('selected');

		$(".post-type-field").hide();
		$(inputId).show();

		$("#textpost-field").val(textpost);
	}


	$('.comment-reply-btn').click(function() {
		openCommentReplyForm(this);
	});

	$('.minimize-btn').click(function() {
		minimizeComment(this);
	});
});

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function openCommentReplyForm(element) {
	var form = $(element).parents('form:first');
	if ($(form).hasClass('form-closed')) {
		

		form.append(function() {
			var textarea = "<textarea name='body' class='child-comment-textarea comment-input' placeholder='Write a comment...' required></textarea>";
			var submitBtn = "<button type='submit' class='child-comment-submit-btn'>Save</buton>"
			var cancelBtn = "<button type='button' class='child-comment-cancel-btn'>Cancel</buton>"

			return textarea + submitBtn + cancelBtn;
		});

		$(form).removeClass('form-closed');
		$(form).addClass('form-open');

		$('.child-comment-cancel-btn').click(function() {
			closeCommentReplyForm(this);
		});
	}
}

function closeCommentReplyForm(element) {
	var form = $(element).parents('form:first');

	$(form).children('.child-comment-textarea:first').remove();
	$(form).children('.child-comment-submit-btn:first').remove();
	$(form).children('.child-comment-cancel-btn:first').remove();

	$(form).removeClass('form-open');
	$(form).addClass('form-closed');

	$('.child-comment-cancel-btn').off('click', this);
}

function minimizeComment(element) {
	var container = $(element).parents('.comment-container:first');
	$(container).find('div').not('.comment-main').not('.comment-info').not('.votes-section').hide();
	$(container).find('.votes-section').addClass('hidden-votes');

	$(container).addClass('comment-minimized');

	closeCommentReplyForm(element);
}