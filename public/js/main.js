// Change this in production to "/reddit/".
var rootPath = "/";

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

	$('.maximize-btn').click(function() {
		maximizeComment(this);
	});

	$('.subscribe-btn').click(function() {
		if ($(this).hasClass('unsubscribed')) {
			console.log("Triggered subscribe function");
			subscribeToSubreddit(this);
		} else {
			console.log("Triggered unsubscribe function");
			unsubscribeFromSubreddit(this);
		}
	});

	$('.vote-arrow').click(function() {
		var element = this;
		var direction = $(element).hasClass('upvote') ? '1' : '0';

		var xhttp = new XMLHttpRequest();
		xhttp.open("GET", rootPath + "users/confirm/", true);
		xhttp.send();

		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText) {
					submitVote(element, direction);	
				} else {
					window.location = rootPath + "users/login";
				}
			}
		}
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
	$(container).find('ul').hide();
	$(container).find('.votes-section').addClass('hidden-votes');

	$(container).find('.minimize-btn').hide();
	$(container).find('.maximize-btn').show();

	$(container).addClass('comment-minimized');

	closeCommentReplyForm(element);
}

function maximizeComment(element) {
	console.log("Maximizing comment");

	var container = $(element).parents('.comment-container:first');

	$(container).find('div').show();
	$(container).find('ul').show();
	$(container).find('.votes-section').removeClass('hidden-votes');

	$(container).find('.maximize-btn').hide();
	$(container).find('.minimize-btn').show();

	$(container).removeClass('comment-minimized');
}

function subscribeToSubreddit(element) {
	var subredditId = $('#subscription-id').text();

	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", rootPath + "subscriptions/create/" + subredditId, true);
	xhttp.send();

	$(element).removeClass('unsubscribed');
	$(element).addClass('subscribed');
	$(element).text('ubsubscribe');
}

function unsubscribeFromSubreddit(element) {
	var subredditId = $('#subscription-id').text();

	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", rootPath + "subscriptions/destroy/" + subredditId, true);
	xhttp.send();

	$(element).removeClass('subscribed');
	$(element).addClass('unsubscribed');
	$(element).text('subscribe');
}

// Use a direction of either 1 or 0 to signify an up/down vote.
function submitVote(element, direction) {
	var id = $(element).siblings('.vote-id').text();
	var type = $(element).siblings('.vote-type').text();
	var newArrowStatus, bothArrows;

	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", rootPath + "votes/" + direction + "/" + type + "/" + id, true);
	xhttp.send();

	changeScore(element, direction);

	direction = direction == '1' ? 'up' : 'down';
	newArrowStatus = $(element).hasClass('active') ? 'inactive' : 'active';
	bothArrows = $(element).parent().children('.vote-arrow');

	var directions = ['up', 'down'];
	for (var i = 0; i < 2; i++) {
		$(bothArrows[i]).removeClass('active inactive');
		$(bothArrows[i]).attr('src', rootPath + 'img/inactive-' + directions[i] + 'vote.png');
	}

	$(element).attr('src', rootPath + 'img/' + newArrowStatus + '-' + direction + 'vote.png');

	$(element).addClass(newArrowStatus);
}

function changeScore(element, direction) {
	var containerDiv = $(element).parent();
	var scoreCounter = $(element).siblings('.vote-counter');
	var originalScore = parseInt($(scoreCounter).text());

	var arrows = $(containerDiv).children('.vote-arrow');
	var activeUpvote = $(arrows[0]).hasClass('active') ? true : false;
	var activeDownvote = $(arrows[1]).hasClass('active') ? true : false;
	
	var amount = 0;

	if (activeUpvote) {
		amount -= 1;
		if (direction == '0') {
			amount -= 1;
		}
	} else if (activeDownvote) {
		amount += 1;
		if (direction == '1') {
			amount += 1;
		}
	} else {
		if (direction == '1') {
			amount += 1;
		} else {
			amount -= 1;
		}
	}

	$(scoreCounter).text(originalScore + amount);
}

function confirmUser() {

}