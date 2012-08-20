
/*
 *	functions for the map view
 */

$(document).ready(function(){
	var center = new google.maps.LatLng(50.975938140707335, 11.336810389701828);
	$("#map_canvas").css({
				width: '100%', 
				height: 600
			});
	WpjMap.init('#map_canvas', center, 16);
	WpjMap.setGuiHandler();
});


var WpjMap = {
	map: null,
	overlay: null,
	markerCluster: null
}

WpjMap.init = function(selector, latLng, zoom) {
	
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
		{ featureType: "poi.government", 
			elementType: "all", stylers: [ { saturation: 100 }, { hue: "#ff00f6" }, { lightness: 0 }, { gamma: 1.03 } ] }, 
	] 
	
	var styledMapOptions = {
		name: "Weimarpedia",
		maxZoom: 60,
		minZoom: 10,
	};
	
	this.map = new google.maps.Map($(selector)[0], mapOptions);
	var wpjMapType = new google.maps.StyledMapType(mapStyle, styledMapOptions);
	this.map.mapTypes.set(WPJ_MAPTYPE_ID, wpjMapType);
	
	// show custom tool-divs on map
	this.map.controls[google.maps.ControlPosition.TOP_LEFT].push( $('#searchbox')[0] );
	this.map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push( $('#legendbox')[0] );
	this.map.controls[google.maps.ControlPosition.RIGHT_TOP].push( $('#resultsbox')[0] );
	this.map.controls[google.maps.ControlPosition.RIGHT_TOP].push( $('#debugbox')[0] );
	
	// wait until map is loaded to get bounds
	google.maps.event.addListener(this.map, 'tilesloaded', WpjMap.loadPlaces);
	
	google.maps.event.addListener(this.map, 'zoom_changed', WpjMap.updatePlaces);
	google.maps.event.addListener(this.map, 'dragend', WpjMap.updatePlaces);
	
	
	
	$('.closeBoxBtn').click(function(){
		if($(this).next().css('display') != 'block') {
			$(this).next().slideDown('fast');
		} else {
			$(this).next().slideUp('fast');
		}
	})
	
}


WpjMap.setGuiHandler = function(){
	
	
}

WpjMap.loadPlaces = function(){
	google.maps.event.clearListeners(WpjMap.map, 'tilesloaded'); // execute only the first time, map is loaded 
	WpjMap.markerCluster = new MarkerClusterer(WpjMap.map, []);
	WpjMap.updatePlaces();
}

WpjMap.updatePlaces = function(){
	
	
	var bounds = WpjMap.map.getBounds();
	$.ajax({
		url: loadPlacesUrl,
		type: 'POST',
		dataType: 'json',
		data: ({
			'tx_wpj_pi1[sLat]': bounds.getSouthWest().lat(),
			'tx_wpj_pi1[wLng]': bounds.getSouthWest().lng(),
			'tx_wpj_pi1[nLat]': bounds.getNorthEast().lat(),
			'tx_wpj_pi1[eLng]': bounds.getNorthEast().lng(),
			'tx_wpj_pi1[zoom]':  WpjMap.map.getZoom(),
			'tx_wpj_pi1[layerBuildings]':  ($('#layerBuildings').attr('checked')) ? true:false,
			'tx_wpj_pi1[layerObjects]':  ($('#layerObjects').attr('checked')) ? true:false,
			'tx_wpj_pi1[layerPersons]':  ($('#layerPersons').attr('checked')) ? true:false,
			
		}),
		success: function(result){
			var places = result['places'];
			$('#debugbox').text("geladen: \n" + places.length + " Ort(e)");
			
			WpjMap.markerCluster.clearMarkers();
			if (places.length>0) {
                var markersArray = [];
                for (i=0; i<places.length; i++) {
                    loc = new google.maps.LatLng(places[i].lat, places[i].lng);

                    marker = new google.maps.Marker({
                        position: loc,
                        map: WpjMap.map,
                        html: places[i].name+"\nUID" + places[i].uid,
                        uid: places[i].uid
                    });

                    markersArray.push(marker);

                    infowindow = new google.maps.InfoWindow({
                        content: "..."
                    });

                    google.maps.event.addListener(marker, 'click', google.maps.InfoWindow.openInfoWindow);
                }
				
          		WpjMap.markerCluster.addMarkers(markersArray);
                console.log(WpjMap.markerCluster.markers_.length);
            }
		}
	});
}

WpjMap.showArticles = function(results){
	console.log(results);
	$('#resultsHolder').html(results);
	$('#resultsHolder').slideDown('fast');
}

google.maps.InfoWindow.openInfoWindow = function() {
    //infowindow.open(WpjMap.map, this);
    //infowindow.setContent(this.html);
    
    $('#resultsHolder').append("<h3>Artikel für " + this.html + "werden geladen.</h3>");
	$('#resultsHolder').slideDown('fast');
    
    $.ajax({
		url: loadPlaceArticlesUrl,
		type: 'POST',
		data: ({
			'tx_wpj_pi1[placeUid]': this.uid
			
		}),
		success: WpjMap.showArticles
  })
}
