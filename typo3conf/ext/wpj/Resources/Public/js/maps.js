
var WpjMap = {
  map: null,
  bounds: null
}

WpjMap.init = function(selector, latLng, zoom) {
  var WPJ_MAPTYPE_ID = "wpj";
  var mapOptions = {
    zoom: zoom,
    center: latLng,
    mapTypeControlOptions: {
       mapTypeIds: [WPJ_MAPTYPE_ID]
    },
    mapTypeId: WPJ_MAPTYPE_ID,
	streetViewControl: false
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
    name: "Weimarpedia"
  };

  this.map = new google.maps.Map($(selector)[0], mapOptions);
  var wpjMapType = new google.maps.StyledMapType(mapStyle, styledMapOptions);
  this.map.mapTypes.set(WPJ_MAPTYPE_ID, wpjMapType);
  this.bounds = new google.maps.LatLngBounds();
}

      
  







WpjMap.placeMarkers = function(filename) {
	$.get(filename, function(xml){
		$(xml).find("marker").each(function(){
			var name = $(this).find('name').text();
			var address = $(this).find('address').text();
			
			// create a new LatLng point for the marker
			var lat = $(this).find('lat').text();
			var lng = $(this).find('lng').text();
			var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
			
			// extend the bounds to include the new point
			WpjMap.bounds.extend(point);
			
			var marker = new google.maps.Marker({
				position: point,
				map: WpjMap.map
			});
			
			var infoWindow = new google.maps.InfoWindow();
			var html='<strong>'+name+'</strong.><br />'+address;
			google.maps.event.addListener(marker, 'click', function() {
				infoWindow.setContent(html);
				infoWindow.open(WpjMap.map, marker);
			});
			WpjMap.map.fitBounds(WpjMap.bounds);
		});
	});
}