/** 
 * @author jens weber
 */

if(!window.Wpj){
  Wpj = {};
}

$(document).ready(function(){
	Wpj.initAdminMenu();
	Wpj.Search.init();

	// notification box fade out
	$('#notifications').delay(2000).fadeOut();

	// Germanizing the pagination
	
	$('.pagination .previous a').text('zurück');
	$('.pagination .next a').text('weiter');
	
	// gallery related stuff

	if(exhibitionBG && $('#container.exhibition').length) {
		
		var wikitools = $('#nav-wiki-tools');
		if(wikitools.length) {
			wikitools.removeClass('grid');
			$('#article-list').append(wikitools);
		}
		
		$('#container.exhibition').addClass('custom-bg');
		$('#container.exhibition').after('<div id="bg"></div>'); 
		
		var theWindow	= $(window),
		$bg				= $("#bg"),
		aspectRatio		= $bg.width() / $bg.height();

		var backgrounds = new Array(
			'2Goethe_auf_Treppe_Kopie_aw.jpg',
			'Goethe_u_Carl-August_Seite_1_aw.jpg',
			'Goethe_u_Carl-August_Seite_2_aw.jpg',
			'Goethe_u_Carl-August_Seite_3_aw.jpg',
			'Goethe_u_Carl-August_Seite_4_aw.jpg',
			'IMG_0415_aw.jpg',
			'IMG_0420_aw.jpg',
			'IMG_0427_aw.jpg',
			'Kreat_Marlene_Schiewer_aw.jpg',
			'Kreat_Seyma_Kisaaglu_aw.jpg',
			'P1000971_aw.jpg',
			'P1030677_aw.jpg',
			'P1040444_aw.jpg',
			'Tagebucheintrag_1_aw.jpg',
			'WP_Parkschule-8a_Fotostory_Seite_02_aw.jpg',
			'WP_Parkschule-8a_Fotostory_Seite_07_aw.jpg',
			'WP_Parkschule-8a_Video_Screenshot_aw.jpg',
			'Zusammen_P1000937_aw.jpg'
		);

		var rnd = Math.round( (backgrounds.length-1) * Math.random() );
		$bg.css({'background' : 'url(typo3conf/ext/wpj/Resources/Public/img/backgrounds/' + backgrounds[rnd] + ') no-repeat center center fixed'});

		function resizeBg() {
			$bg.addClass('bgheight');
			$bg.addClass('bgwidth');
		}

		theWindow.resize(function() {
			resizeBg();
		}).trigger("resize");
	}


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

// gallery related stuff

var exhibitionBG = true;

var isiPad   = navigator.userAgent.match(/iPad/i) != null;
var isiPhone = navigator.userAgent.match(/iPhone/i) != null;

if(isiPad || isiPhone) {

	var iOSVersion5 = navigator.userAgent.match(/OS 5/i) != null;

	if(!iOSVersion5) {
		exhibitionBG = false;
	}
}
