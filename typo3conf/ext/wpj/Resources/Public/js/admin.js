/*
 *	functions for the admin interface
 */

if(!window.Wpj){
  Wpj = {};
}

$(document).ready(function(){
	if ($('a.vote-button').length > 0) {
		$('a.vote-button').click(Wpj.VoteButtonClick);
	}
});

Wpj.VoteButtonClick = function(e){
	var article_id = $(this).attr('id').split("_").pop();
	var vote = $(this).hasClass('vote_1') ? 2 : $(this).hasClass('vote_2') ? 0 : 1;
	
	$(this).removeClass('vote_0');
	$(this).removeClass('vote_1');
	$(this).removeClass('vote_2');
	$(this).addClass('vote_'+vote);
	
	$.ajax({
		url: voteUrl,
		data: {
			'tx_wpj_pi1[article]': article_id, 
			'tx_wpj_pi1[voting]': vote
			},
		type: "POST",
		success: function(result){
			if (result == "success"){
				
			}
		},
	});
	e.preventDefault();
}
