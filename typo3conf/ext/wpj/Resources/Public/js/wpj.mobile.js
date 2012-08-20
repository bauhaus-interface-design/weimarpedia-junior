
(function(){
	var Skeleton = {
		getElementsByClassName : function(context, cls){
			if(context.getElementsByClassName){
				return context.getElementsByClassName(cls);
			}
			
			var ele = context.getElementsByTagName("*"),
				ret = [],
				current,
				classes;
			
			for(var i = 0, j = ele.length; i < j; i++){
				current = ele[i];
				classes = (current.getAttribute("className") || current.className).split(" ");
				for(var k = 0, l = classes.length; k < l; k++){
					if(classes[k] === cls){
						ret.push(current);
						break;
					}
				}
			}
			
			return ret;
		},
		
		filterTags : function(list, tags){
			var exists = false;
			
			for(var i = 0, j = list.length; i < j; i++){
				for(var k = 0, l = tags.length; k < l; k++){
					if(list[i].tagName === tags[k]){
						exists = true;
						break;
					}
				}
				if(exists === true){
					list.splice(i, 1);
				}
			}
			
			return list;
		},
		
		addClass : function(element, name){
			if(typeof element == 'object') {
				var classes = (element.getAttribute("className") || element.className).split(" "),
					exists = false;
			
				for(i = 0, j = classes.length; i < j; i++){
					if(classes[i] === name){
						exists = true;
						break;
					}
				}
				if(!exists){
					classes.push(name);
					element.className = classes.join(" ");
				}
			}
		},
		
		removeClass : function(element, name){
			if(typeof element == 'object') {
				var classes = (element.getAttribute("className") || element.className).split(" "),
					exists = false;
			
				for(var i = 0, j = classes.length; i < j; i++){
					if(classes[i] === name){
						exists = true;
						break;
					}
				}
				if(exists){
					classes.splice(i, 1);
					element.className = classes.join(" ");
				}
			}
		},
		
		swapClass : function(element, from, to){
			if(typeof element == 'object') {
				Skeleton.removeClass(element, from);
				Skeleton.addClass(element, to);
			}
		},
		
		addListener : function(element, on, fn, last){
			last = (last || false);
			var BH;
			
			if(window.addEventListener){  //AddEventListener takes precedence here
				BH = "addEventListener";
			}else if(window.attachEvent){
				BH = "attachEvent";
				on = "on" + on;
			}
			
			element[BH](on, function(e){
				var event = e || window.event;
				return fn.call(element, event);  //Force it to call the handler in the proper context (IE 7 & 8 do not)
			}, last);
		},
		
		doFancyExpensiveTabThings : function(){
			var tabs = Skeleton.filterTags(Skeleton.getElementsByClassName(document, "tabs"), ["ul"]);
			
			for(var i = 0, j = tabs.length; i < j; i++){
				(function(){  //This is necessary to isolate each individual tab set in its own scope
					var tabNum = i,
						tabList = tabs[tabNum].getElementsByTagName("li");
					
					for(var k = 0, l = tabList.length; k < l; k++){
						Skeleton.addClass(document.getElementById(tabList[k].getElementsByTagName("a")[0].href.substr(tabList[k].getElementsByTagName("a")[0].href.indexOf("#") + 1)), "hidden");
						
						Skeleton.addListener(tabList[k].getElementsByTagName("a")[0], "click", function(e){
							var contentLocation = this.href.substr(this.href.indexOf("#")),
								contentElement,
								siblings;
							
							if(contentLocation.charAt(0) === "#"){
								if(e.preventDefault){
									e.preventDefault();
								}else{
									e.returnValue = false;
									e.cancelBubble = true;
								}
								
								for(var m = 0; m < k; m++){
									Skeleton.removeClass(tabList[m].getElementsByTagName("a")[0], "active");
								}
								
								Skeleton.addClass(this, "active");
								
								contentElement = document.getElementById(contentLocation.substr(1));
								Skeleton.swapClass(contentElement, "hidden", "active");
								
								siblings = contentElement.parentNode.getElementsByTagName("li");
								for(var m = 0, n = siblings.length; m < n; m++){
									if(siblings[m] !== contentElement){
										Skeleton.swapClass(siblings[m], "active", "hidden");
									}
								}
							}
							return false;
						});
					}
				})();
			}
		}
	};
	
	window.Skeleton = Skeleton;
})();

// General Mobile Browser Detection http://detectmobilebrowsers.com/
(function(a){jQuery.browser.mobile=/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);

window.WPM = window.WPM || {};
var WPM = {
	currPage: 'map',
	overlay: null,
	markerCluster: null,
	places: null,
  DISABLE_HASH_LISTENER : 0
}

var elem = document.documentElement;
var lastIndicatorAppearance = 0;

WPM.orientation = elem && elem.clientWidth / elem.clientHeight < 1.1 ? "portrait" : "landscape";

WPM.setListeners = function() {

	window.addEventListener('orientationchange', function() {
		WPM.orientation = ['portrait',,'landscape'][window.orientation & 2];
    WPM.fixViews();
	}, false);

	window.addEventListener('resize', function() {
	    WPM.fixViews();
	}, false);

	// When ready...
	window.addEventListener("load",function() {
	  // Set a timeout...
	  setTimeout(function(){
	    // Hide the address bar!
	    window.scrollTo(0, 1);
	  }, 0);
	});

}


WPM.fixViews = function() {
	
	var winHeight = $(window).height();
	var winWidth = $(window).width();
	var mapCenter;

	if(jQuery.browser.mobile) {
	// Mobile
		$('#main, .page').css({ height : ( winHeight + 60 ) + 'px '});
		$('#map_canvas').css({ top : '45px', height : ( winHeight + 15 ) + 'px'});
	// Desktop
	} else {
		$('#main, .page').css({ height : winHeight + 'px '});
		$('#map_canvas').css({ top : '45px', height : ( winHeight - 45 ) + 'px'});
	}

	$('.page:not(.current)').css({ left : winWidth + 'px'});

	// re-center map

}


WPM.Popup = WPM.Popup || {};

WPM.Popup.setContent = function(scope,html) {
	if($('#popup-'+scope).length == 0) {
		$('body').append('<div class="modal-backdrop"></div><div id="popup-'+scope+'" class="overlay"></div>');
	}
	if($('#popup-'+scope+' .overlay-inner').length > 0) {
		$('#popup-'+scope+' .overlay-inner').remove();
	}
	$('#popup-'+scope).append('<div class="overlay-inner"><div class="clearfix"><a class="close">x</a></div><div id="popup-scroll-wrapper"><div class="scroll-content"></div></div></div>');	
	
	// in #scroll-content müsste jetzt die entsprechende Liste via Ajax geladen werden.
	$('#popup-scroll-wrapper .scroll-content').html(html);

	var scroll = new iScroll('popup-scroll-wrapper');
	
	$('#popup-' + scope + ' .close').click(function(){
		$('.modal-backdrop, #popup-' + scope).fadeOut(400);
	})
}


WPM.Popup.open = function(scope) {
	$('.modal-backdrop').height('10000px');
	$('.modal-backdrop, #popup-'+scope).fadeIn(200);
}

WPM.Popup.close = function(scope) {
	$('.modal-backdrop, #popup-'+scope).fadeOut(400);
}

WPM.View = WPM.View || {};
WPM.View.setContent = function(scope,html) {
	$('#'+scope).append(html);
}

WPM.View.load = function(scope, uid) {

	setTimeout(function () {
		WPM.View.loadingIndicator('off');
		WPM.View.show(scope);
    }, 1000);

}

WPM.View.loadingIndicator = function(s, e) {

	var t = new Date();
	var status = s || 'on';
	var error = e || null;

	if(!$('#busy').length) {
		$('body').append('<div id="busy" style="display: none;"></div>');
	}
	var busy = $('#busy');

	switch(status) {
		
		case 'on' : 
			if(t - lastIndicatorAppearance > 1000) {
				busy.fadeIn();
			}
			break;
		case 'off' : 
			if(error == 'error') {
				alert('Es ist ein Fehler aufgetreten');
		  }
			busy.fadeOut();
			break;
	}

	lastIndicatorAppearance = t;
}

WPM.View.show = function(scope) {

	var winWidth = $(window).width();
	var currView = $('section.current:first');
	var targetView = $('#' + scope);

  if(currView.attr('id') != targetView.attr('id')) {

  	var aDirection = WPM.View.getAnimationDirection(currView, targetView);

  	switch(aDirection) {
		
  		case 'left' :

  			var currViewXPosFrom = 0;
  			var currViewXPosTo = (0-winWidth);

  			var targetViewXPosFrom = winWidth;
  			var targetViewXPosTo = 0;
  			break;

  		case 'right' :

  			var currViewXPosFrom = 0;
  			var currViewXPosTo = (0+winWidth);

  			var targetViewXPosFrom = 0-winWidth;
  			var targetViewXPosTo = 0;
  			break;

  	}

  	currView.css({ left : currViewXPosFrom + 'px' });
  	targetView.css({ left : targetViewXPosFrom + 'px' });

  	targetView.addClass('current').animate(
  		{ 
  			left: targetViewXPosTo + 'px'
  		},{
  			easing : 'easeInOutSine',
  			duration : 300
  		});

  	currView.animate({ 
  			left: currViewXPosTo + 'px'
  		},{
  			easing : 'easeInOutSine',
  			duration : 300,
  			complete : function(){ $(this).removeClass('current'); }
  		});

      WPM.DISABLE_HASH_LISTENER = 0;

  }
}


WPM.View.getAnimationDirection = function(currView, targetView) {

	var currClasses = currView.attr('class');
	var targetClasses = targetView.attr('class');
	var currClassParts = currClasses.split('level-');
	var targetClassParts = targetClasses.split('level-');
	
	if( parseInt(currClassParts[1]) <  parseInt(targetClassParts[1])) {
		return 'left';
	}
	else {
		return 'right';
	}

}

WPM.setGuiHandler = function(){
	// map-view: showBuildingsBtn
	$('#showBuildingsBtn').bind('click', function(e) {
		e.preventDefault();
		// build building list from json
		WPM.Popup.setContent('places', '<h2 class="popup">Gebäude in diesem Kartenausschnitt</h2><ul class="itemlist" id="building-list"></ul>');
		// list
		for (i=0; i<WPM.places.length; i++) {
			var link = $('<a href="#"><span>' + WPM.places[i].name + '</span></a>').appendTo('#building-list');
			link.wrap('<li>');
			link.bind('click', {uid: WPM.places[i].uid}, WPM.buildingListClickHandler);
		}
		WPM.Popup.open('places');
	});
}


WPM.buildingListClickHandler = function(event){
	event.preventDefault();
	WPM.DISABLE_HASH_LISTENER = 1;
	WPM.Popup.close('places');
	WPM.HistoryAction.showPlace({uid: event.data.uid});
}


WPM.loadArticlesClickHandler = function(event){
	event.preventDefault();
	WPM.DISABLE_HASH_LISTENER = 1;
	WPM.HistoryAction.listArticles(event.data);
}


WPM.buildList = function(ul, objects, labelAttr, clickHandler) {
	// clear list
	$(ul+' li').remove();
	// hide if empty
	if (objects && objects.length > 0){
		// fill list
		for (i=0;i<objects.length;i++){
			var object = objects[i];
			var link = $('<a href="#"><span>' + object[labelAttr] + '</span></a>').appendTo(ul);
			link.wrap('<li>');
			link.bind('click', {uid: object.uid}, clickHandler);
		}
		$(ul).parent().show();
	} else {
		$(ul).parent().hide();
	}
}

WPM.buildImageList = function(ul, objects, labelAttr, imageAttr, clickHandler){
	// clear list
	$(ul+' li').remove();
	// hide if empty
	if (objects && objects.length > 0){
		// fill list
		for (i=0;i<objects.length;i++){
			var object = objects[i];
			var img = '<img src="' + object[imageAttr] + '" width="100" height="100"/>';
			var link = $('<a href="#"><span>' + img + object[labelAttr] + '</span></a>').appendTo(ul);
			link.wrap('<li>');
			link.bind('click', {uid: object.uid}, clickHandler);
		}
		$(ul).parent().show();
	} else {
		$(ul).parent().hide();
	}
}

// clickable label under the place-icon
WPM.infoBoxClickHandler = function(event) {
	event.preventDefault();
	WPM.DISABLE_HASH_LISTENER = 1;
	WPM.HistoryAction.showPlace({uid: event.data.uid});
	return false;
}


WPM.floorListClickHandler = function(event){
	event.preventDefault();
	WPM.DISABLE_HASH_LISTENER = 1;
	WPM.HistoryAction.showFloor({uid: event.data.uid});
}


WPM.roomListClickHandler = function(event){
	event.preventDefault();
	WPM.DISABLE_HASH_LISTENER = 1;
	WPM.HistoryAction.listArticles({uid: event.data.uid});
}


WPM.articleListClickHandler = function(event){
	event.preventDefault();
	WPM.DISABLE_HASH_LISTENER = 1;
	WPM.HistoryAction.showArticle({uid: event.data.uid});
}


WPM.loadPlaces = function(){
	google.maps.event.clearListeners(WPM.map, 'tilesloaded'); // call one time, when map is loaded 
	WPM.markerCluster = new MarkerClusterer(WPM.map, []);
	WPM.updatePlaces();
}


WPM.updatePlaces = function(){
	
	var bounds = WPM.map.getBounds();
	
	
	// debug
	/*marker = new google.maps.Marker({
        position: new google.maps.LatLng(bounds.getSouthWest().lat(), bounds.getSouthWest().lng()),
        map: WPM.map,
       
    });
	return;
	*/
	
	// normalize request
	// ...
	
	// check if request cached
	
	
	$.ajax({
		url: loadPlacesUrl,
		type: 'POST',
		dataType: 'json',
		data: ({
			'tx_wpj_pi1[sLat]': bounds.getSouthWest().lat(),
			'tx_wpj_pi1[wLng]': bounds.getSouthWest().lng(),
			'tx_wpj_pi1[nLat]': bounds.getNorthEast().lat(),
			'tx_wpj_pi1[eLng]': bounds.getNorthEast().lng(),
			'tx_wpj_pi1[zoom]':  WPM.map.getZoom()			
		}),
		success: function(result){
			var places = WPM.places = result['places'];
			//$('#debugbox').text("geladen: \n" + places.length + " Ort(e)");

			/*
			var infowindow = new google.maps.InfoWindow(
			{ 
				content: '...',
				pixelOffset: new google.maps.Size(40,50),
				maxWidth: 100
			});
			*/

			WPM.markerCluster.clearMarkers();
			if (places.length>0) {
                var markersArray = [];
                for (i=0; i<WPM.places.length; i++) {
                    var latlng = new google.maps.LatLng(places[i].lat, places[i].lng);

					var image = new google.maps.MarkerImage('typo3conf/ext/wpj/Resources/Public/marker/' + places[i].icon,
				      new google.maps.Size(80, 40),
				      new google.maps.Point(0, 0),
				      new google.maps.Point(40, 40),
				      new google.maps.Size(80, 40)
				      );

					var marker = new google.maps.Marker({
						position: latlng,
						icon: image,
						html: places[i].name,
						uid: places[i].uid
					});

					markersArray.push(marker);
					google.maps.event.addListener(marker, 'click', function(event) {

						var boxText = document.createElement("div");
						boxText.className = "phoney";

						var link = $('<a href="#"class="phoneytext">' + this.html + '</a>').appendTo($(boxText));
						link.bind('click', {uid: this.uid}, WPM.infoBoxClickHandler);
	
						WPM.iB.setContent(boxText);
						WPM.iB.open(WPM.map, this);

					});
                }
				
          		WPM.markerCluster.addMarkers(markersArray);
          		
				$('#showBuildingsBtn').show();
           } else {
           		$('#showBuildingsBtn').hide();
           }
		}
	});
}

WPM.initMap = function(selector, latLng, zoom) {

	var iBOptions = {
		disableAutoPan: false,
		maxWidth: 0,
		pixelOffset: new google.maps.Size(-140, 0),
		zIndex: null,
		boxStyle: {
			opacity: 0.9,
			minWidth: "280px"
		},
		closeBoxMargin: "10px 2px 2px 2px",
		closeBoxURL: '',
		infoBoxClearance: new google.maps.Size(1, 1),
		isHidden: false,
		pane: "floatPane",
		enableEventPropagation: false
	};

	WPM.iB = new InfoBox(iBOptions);

	// init map with custom options and style
	var WPJ_MAPTYPE_ID = "wpj";
	var mapOptions = {
		zoom: zoom,
		center: latLng,
		mapTypeControlOptions: {
	   		mapTypeIds: [WPJ_MAPTYPE_ID, google.maps.MapTypeId.SATELLITE]
		},
		mapTypeId: WPJ_MAPTYPE_ID,
		streetViewControl: false,
		scrollwheel: false,
		navigationControlOptions: {
		    style: google.maps.NavigationControlStyle.SMALL,
		},
		scaleControl: true, // small buttons without scale
		disableDoubleClickZoom: true,
	}
	var mapStyle = [ 
		{ featureType: "landscape", 
			elementType: "all", stylers: [ { hue: "#ff5e00" }, { lightness: -10 }, { saturation: -50 } ] },
		{ featureType: "transit", 
			elementType: "all", stylers: [ { hue: "#ffbb00" }, { lightness: 0 }, { saturation: -84 } ] },
		{ featureType: "road", 
			elementType: "all", stylers: [ { hue: "#ffc300" }, { saturation: -81 }, { lightness: 11 }, { gamma: 2.51 } ] },
		//{ featureType: "poi.government", 
		//	elementType: "all", stylers: [ { saturation: 100 }, { hue: "#ff00f6" }, { lightness: 0 }, { gamma: 1.03 } ] }, 
		{ featureType: "poi", 
			elementType: "labels", stylers: [ { visibility: "off" } ] }

	] 
	var styledMapOptions = {
		name: "Weimarpedia",
		maxZoom: 60,
		minZoom: 10,
	};
	
	var myLatlng = new google.maps.LatLng(50.97755,11.32862);
	var myOptions = {
		zoom: 14,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	// init map
	WPM.map = new google.maps.Map($(selector)[0], mapOptions);
	
	var WPMType = new google.maps.StyledMapType(mapStyle, styledMapOptions);
	WPM.map.mapTypes.set(WPJ_MAPTYPE_ID, WPMType);
	
	// show custom tool-divs on map
	WPM.map.controls[google.maps.ControlPosition.TOP_LEFT].push( $('#showBuildings')[0] );
	//WPM.map.controls[google.maps.ControlPosition.RIGHT_TOP].push( $('#debugbox')[0] );
	
	// wait until map is loaded to get bounds
	google.maps.event.addListener(this.map, 'tilesloaded', WPM.loadPlaces);
	
	// update marker if map changed
	google.maps.event.addListener(this.map, 'zoom_changed', WPM.updatePlaces);
	google.maps.event.addListener(this.map, 'dragend', WPM.updatePlaces);
	
	
	
}

WPM.setHash = function(action, options) {
  
  if(typeof action != 'undefined') {
    
    var hash = '';
    var strBrowser = navigator.userAgent.toLowerCase();

    hash += action;
    if(typeof options == 'object') {
      var pairs = [];

      for(key in options){
        if(options.hasOwnProperty(key)) {
          pairs.push(key + ',' + options[key]);
        }
      }
      
      if(pairs.length) {
        hash += '_' + pairs.join(';');
      }
    }

    if (strBrowser.indexOf('chrome') > 0 || strBrowser.indexOf('safari') > 0) {
      window.location.href = "#" + hash;
    }
    else {
      window.location.hash = "#" + hash;
    }

		window.location.hash = "#" + hash;

  }
}

WPM.getOptionsFromHash = function(fragment) {
  
  var f = fragment || '';
  var options = {};
  var pairs = f.split(';') || [];
  
  for(var i = 0; i < pairs.length; i++) {

    var kv = pairs[i].split(',');
    var key, val;

    switch(kv[0]) {
      case 'type':
        key = kv[0];
        val = kv[1];
        break;
      default :
        key = kv[0];
        val = parseFloat(kv[1]);
        break;
    }

    options[key] = val;
  }
  return options;

}

!function ($) {

	$(function(){
		initInfoBox();

		WPM.fixViews();
		WPM.setListeners();
		MBP.scaleFix();
    

		if(WPM.currPage == 'map' && typeof WPM.map == 'undefined') {
			var center = new google.maps.LatLng(50.9786688, 11.3278181); // Weimar
			WPM.initMap('#map_canvas', center, 16);
		}
		WPM.setGuiHandler();

		$('.btn.back').click(function(e) {
			e.preventDefault();
			history.back(-1);
		});

		$('body').append('<div id="busy" style="display: none;"></div>');

		$("#busy").ajaxStart(function(){
			WPM.View.loadingIndicator();
			//$(this).fadeIn();
		});
		$("#busy").ajaxSuccess(function(){
			WPM.View.loadingIndicator('off');
			$(this).fadeOut();
		});
		$("#busy").ajaxError(function(){
			WPM.View.loadingIndicator('off', 'error');
		});

    $(window).hashchange( function() {

      if(WPM.DISABLE_HASH_LISTENER == 1) {
        WPM.DISABLE_HASH_LISTENER == 0;
      } else {

			  // Set a timeout...
			  setTimeout(function(){
			    // Hide the address bar!
			    window.scrollTo(0, 1);
			  }, 0);

        var hash = location.hash.replace( /^#/, '' );

        if(hash) {

          var hashParts = hash.split('_');

          switch(hashParts[0]) {

            case 'showMap' :
              WPM.HistoryAction.showMap(WPM.getOptionsFromHash(hashParts[1]));
              break;

            case 'showPlace' :
              WPM.HistoryAction.showPlace(WPM.getOptionsFromHash(hashParts[1]));
              break;

            case 'listArticles' :
              WPM.HistoryAction.listArticles(WPM.getOptionsFromHash(hashParts[1]));
              break;

            case 'showFloor' :
			  WPM.HistoryAction.showFloor(WPM.getOptionsFromHash(hashParts[1]));
              break;

            case 'showArticle' :
              WPM.HistoryAction.showArticle(WPM.getOptionsFromHash(hashParts[1]));
	          break;

            default :
              WPM.HistoryAction.showMap({lat : 50.9786688,lng : 11.3278181, zoom : 16});
              break;
          }
        
        } else {
          WPM.DISABLE_HASH_LISTENER == 1;
          //WPM.setHash('showMap'); // Setting default hash
        }

      }
    })

    $(window).hashchange();

  });

}(window.jQuery)



// these actions can be called by event-handlers or hashtag-urls 
WPM.HistoryAction = WPM.HistoryAction || {};


// map needs to be initiated
WPM.HistoryAction.showMap = function(options) {
	if (typeof options.lat == 'number' && typeof options.lng == 'number') {
		WPM.map.setCenter( new google.maps.LatLng(options.lat, options.lng) );
	}
	if (typeof options.zoom == 'number') {
		WPM.map.setZoom(options.zoom);
	}
	WPM.View.show('map');
}

// place-view: floor-list & main article-list
WPM.HistoryAction.showPlace = function(options) {
	if (typeof options.uid == 'number') {
		$.ajax({
			url: listPlaceOptionsUrl,
			type: 'POST',
			dataType: 'json',
			data: ({
				'tx_wpj_pi1[place]': options.uid
			}),
			success: function(result){
				$('#place .sectionhead h1').text(result.name);
				$('.tabs #knowledgeArticles').bind('click', {uid: parseInt(result.uid), type: 'knowledge'}, WPM.loadArticlesClickHandler);
				$('.tabs #exhibitionArticles').bind('click', {uid:  parseInt(result.uid), type: 'exhibition'}, WPM.loadArticlesClickHandler);
				
				WPM.buildList('#overviewTab #floors-list ul', result.floors, 'name', WPM.floorListClickHandler);
				WPM.buildList('#overviewTab #article-list ul', result.articles, 'title', WPM.articleListClickHandler);
				WPM.View.show('place');

			  WPM.setHash('showPlace', options);
				Skeleton.doFancyExpensiveTabThings();
			}
		});
	}
}

// tabs exhibition and knowledge in view level-2 
WPM.HistoryAction.listArticles = function(options) {
	if (typeof options.uid == 'number') {
		if (options.type != 'knowledge' && options.type != 'exhibition') {
			//options.type = "knowledge";
		}
		$.ajax({
			url: loadPlaceArticlesUrl,
			type: 'POST',
			dataType: 'json',
			data: ({
				'tx_wpj_pi1[place]': options.uid,
				'tx_wpj_pi1[articletype]': options.type,
			}),
			success: function(result){
				var type = options.type;
				$('#' + type + 'Tab').addClass('active');
				WPM.buildList('#' + type + 'Tab ul', result.articles, 'title', WPM.articleListClickHandler);
				WPM.View.show('place');
				WPM.setHash('listArticles', options);
			}
		});
	}
}

WPM.HistoryAction.showFloor = function(options) {

	if (typeof options.uid == 'number') {
		$.ajax({
			url: loadFloorUrl,
			type: 'POST',
			dataType: 'json',
			data: ({
				'tx_wpj_pi1[place]': options.uid
			}),
			success: function(result){
				$('#floorplan .sectionhead h1').text(result.name);
				$('#floorplan #floormap img').attr('src', result.image);
				WPM.buildList('#floorplan #rooms-list ul', result.rooms, 'name', WPM.roomListClickHandler);
				WPM.buildList('#floorplan #article-list ul', result.rooms, 'name', WPM.articleListClickHandler);
				WPM.View.show('floorplan');
				WPM.setHash('showFloor', options);
			}
		});
	}
}
 

WPM.HistoryAction.listArticles = function(options) {

	if (typeof options.uid == 'number') {
		$.ajax({
			url: loadRoomUrl,
			type: 'POST',
			dataType: 'json',
			data: ({
				'tx_wpj_pi1[place]': options.uid
			}),
			success: function(result){
				
				if (result.articles.length > 1){
					// show list if more than one article
					$('#article-list-view .sectionhead h1').text(result.name);
					WPM.buildList('#article-list-view #article-list-level4 ul', result.articles, 'title', WPM.articleListClickHandler);
					WPM.View.show('article-list-view');
					WPM.setHash('listArticles', options);
					
				} else if (result.articles.length == 0) {
					// no results
					alert('Es gibt noch keine Artikel für diesen Ort.');
					return;
					
				}else {
					// jump to article-view if only one article
					WPM.HistoryAction.showArticle({uid: result.uid});
				}
				
			}
		});
	}
}



WPM.HistoryAction.showArticle = function(options) {
	if (typeof options.uid == 'number') {
		$.ajax({
			url: loadArticleUrl,
			type: 'POST',
			dataType: 'json',
			data: ({
				'tx_wpj_pi1[article]': options.uid
			}),
			success: function(result){
				
				console.log(result.body);
				
				$('#article-view .inner h3').text( result.title );
				$('#article-view .inner div.body').html( '<p>' + result.body + '</p>');
				WPM.buildImageList('#article-view .inner ul', result.medias, 'description', 'url');
				WPM.View.show('article-view');
				var scroll = new iScroll('article-scroll-wrapper');
				WPM.setHash('showArticle', options);
			}
		});
	}
}
