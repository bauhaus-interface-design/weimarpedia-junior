/** 
 * @author jens weber
 */

if(!window.Wpj){
  Wpj = {};
}

$(document).ready(function(){
	Wpj.initAdminMenu();
	Wpj.Search.init();
	
	
	// frank
	
	// notification box fade out
	$('#notifications').delay(2000).fadeOut();
		
	
});

// open/close adminMenu / cookie
Wpj.initAdminMenu = function() {
	
	var _admstate = $.cookie('_admstate');

	if(null == _admstate) {
		$.setAdminMenuState('none');
	} else {
		$.setAdminMenuState(_admstate);
		$('#admin').css({'display' : _admstate });
	}
	$('#toggle-admin-menu').click(function(){

		if($('#admin').css('display') != 'block') {
			$('#admin').slideDown('fast');
			$.setAdminMenuState('block');
		} else {
			$('#admin').slideUp('fast');
			$.setAdminMenuState('none');
		}
	})

}

$.setAdminMenuState = function(state) {
	$.cookie('_admstate', state, { expires: 365, path: '/', secure: false });
	switch(state) {
		case 'block':
			$('#toggle-admin-menu').text('Ausblenden');
			break;
		default:
			$('#toggle-admin-menu').text('Administration');
	}
}
		
		
// suggest searching with different scopes
Wpj.Search = {};
Wpj.Search.init = function(){
	if ($('#searchField').length > 0){
		
		// add links
		$('#searchField').focusin(function(){
			
			// TODO: move styles to stylesheet 
			var css = 'position:absolute;border:1px solid #888;background:#fff;left:'+ $(this).position().left + 'px; top:' + $(this).height() + ';';
			var innerHtml = "";
			$.each(['','im Lexikon','in der Galerie','in Personen','in Objekten','in Autoren'], function(index,value){
				innerHtml += '<a href="#" onclick="Wpj.Search.submit(\''+index+'\');return false;">suche <span class="searchterm-wrapper"> ' + $('#searchField').val() +'</span> '+value+'</a><br/>';
			});
			var html = '<div id="searchLinks" style="'+css+'">'+innerHtml+'</div>';
			$(this).after(html);
			if ($('#searchField').val().length < 2) $('#searchLinks').hide();
		});
		
		// update links
		$('#searchField').keyup(function(){
			if ($(this).val().length > 1) {
				$('#searchLinks').show();
				$('.searchterm-wrapper').text($(this).val());
			}
		});
		
		// remove links
		$('#searchField').focusout(function(){
			window.setTimeout("$('#searchLinks').remove()", 100);
		});

		$('#searchField').blur(function(){
			window.setTimeout("$('#searchLinks').remove()", 100);
			//$('#searchLinks').remove();
		});
		
	}
}
Wpj.Search.submit = function(scope){
	var s;
	switch (parseInt(scope)) {
		case 1: s = 'knowledge';break;
		case 2: s = 'gallery';break;
		case 3: s = 'people';break;
		case 4: s = 'objects';break;
		case 5: s = 'authors';break;
		default: s = '';
	}
	
	$('#scopeField').attr('value', s);
	
	$('form[name=demand]').submit();
}