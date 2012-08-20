/*
 *
 * Author: Frank Matuse 
 *
 */

$(document).ready(function(){

	var $window = $(window);

	$('#slides').presentation({
	  slide: '.slide', //Reference to each individual slide
	  pagerClass: 'nav-pager', //Class to put on the unordered list that contains links to each slide
	  prevNextClass: 'nav-prev-next', //Class to put on the unordered list that contains the previous and next links
	  prevText: 'zur&uuml;ck', //Text for the Previous link
	  nextText: 'weiter', //Text for the Next link
	  transition: 'fade' //Possible values are 'fade', 'show/hide', 'slide'
	});

	adjust($window);

	$window.resize(function(){
		adjust($window);
	});

});

var adjust = function(win) 
{
	if(win.height() > 700) {
		('.slide:not(".first")').css({ 'paddingTop' : '150px' });
	} else {
		$('.slide:not(".first")').css({ 'paddingTop' : '80px' });
	}
}