/*
 *	functions for place editing
 */

if(!window.Wpj){
  Wpj = {};
}

$(document).ready(function(){
  
	Wpj.GeocodingMap.init();
		
	$('#updateMarkerFromMapBut').click(function(event){
		// write marker-position into lat/lng-textfields 
		$('input[name="tx_wpj_pi1[place][lat]"]').attr('value', Wpj.GeocodingMap.marker.getPosition().lat());
		$('input[name="tx_wpj_pi1[place][lng]"]').attr('value', Wpj.GeocodingMap.marker.getPosition().lng());
	});
	
	$('#showPolygoneBut').click(function(event){
		var bounds = new google.maps.LatLngBounds();
		Wpj.GeocodingMap.polygone.getPath().forEach (function(latLng){
		  bounds.extend(latLng);
		});
		Wpj.GeocodingMap.map.fitBounds(bounds);
	});

});


	
	

/***************************
 *	 geocoding Map
 */

Wpj.GeocodingMap = {marker:null, map:null, polygone:null, geocoder:null};
Wpj.GeocodingMap.geocodePosition = function(pos){
	this.geocoder.geocode({
		latLng: pos
	}, function(responses){
		if (responses && responses.length > 0) {
			Wpj.GeocodingMap.updateMarkerAddress(responses[0].formatted_address);
			Wpj.GeocodingMap.updateMarkerStatus( Wpj.GeocodingMap.getResultDescription(responses[0]) );
		}
		else {
			Wpj.GeocodingMap.updateMarkerAddress('Es konnte keine Adresse bestimmt werden.');
		}
	});
}
	
Wpj.GeocodingMap.getResultDescription = function (result) {
  var bounds = result.geometry.bounds;
  var html  = '<table class="tabContent">';
      html += this.tr('Address', result.formatted_address);
      html += this.tr('Types', result.types.join(", "));
      html += this.tr('Location', result.geometry.location.toString());
      html += this.tr('Location type', result.geometry.location_type);
      if (result.partial_match) {
        html += this.tr('Partial match', 'Yes');
      }
      html += '</table>';
  return html;
}

Wpj.GeocodingMap.tr = function (key, value) {
  return '<tr>' +
           '<td class="key">' + key + (key ? ':' : '') + '</td>' +
           '<td class="value">' + value + '</td>' +
         '</tr>';
}


Wpj.GeocodingMap.updateMarkerStatus = function(str){
	$('#markerStatus').html(str);
}
	
Wpj.GeocodingMap.updateMarkerPosition = function(latLng){
	$('#info').html( [latLng.lat(), latLng.lng()].join(', ') );
}
	
Wpj.GeocodingMap.updateMarkerAddress = function(str){
	$('#address').html(str);
}
	
	
Wpj.GeocodingMap.init = function(){
	this.geocoder = new google.maps.Geocoder();
	
	var lat = parseFloat( $('input[name="tx_wpj_pi1[place][lat]"]').attr('value') );
	if (lat == 0) lat = 50.9775;
	var lng = parseFloat( $('input[name="tx_wpj_pi1[place][lng]"]').attr('value') );
	if (lng == 0) lng = 11.328989;
	var accuracy = parseInt( $('input[name="tx_wpj_pi1[place][accuracy]"]').attr('value') );
	var zoom;
	switch(accuracy){
		case 1: zoom = 1;break;
		case 2: zoom = 4;break;
		case 3: zoom = 6;break; // country
		case 4: zoom = 8;break; // state
		case 5: zoom = 10;break; // City
		case 6: zoom = 15;break;
		case 7: zoom = 17;break;
		case 8: zoom = 19;break;
		case 9: zoom = 20;break; // room
	}
	
	var latLng = new google.maps.LatLng(lat, lng);
	this.map = new google.maps.Map( $('#mapCanvas')[0], {
		zoom: zoom,
		center: latLng,
		
		streetViewControl: false,
		scrollwheel: false,
		disableDoubleClickZoom: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	
	
	this.marker = new google.maps.Marker({
		position: latLng,
		map: this.map,
		draggable: true
	});

	
	// Add dragging event listeners	
	google.maps.event.addListener(Wpj.GeocodingMap.marker, 'dragend', function(){
		Wpj.GeocodingMap.geocodePosition(Wpj.GeocodingMap.marker.getPosition());
	});
	
	
	google.maps.event.addListener(Wpj.GeocodingMap.map, 'zoom_changed', function(){
		$('#mapZoom').text(Wpj.GeocodingMap.map.getZoom());
	});
	
	// polygone
	var polygoneStr = $('input[name="tx_wpj_pi1[place][coordinates]"]').attr('value');
	if (polygoneStr != ''){
		
		var path = google.maps.geometry.encoding.decodePath( polygoneStr );
		this.polygone = new google.maps.Polygon({
			paths: path,
			strokeColor: "#7777aa",
			strokeOpacity: 0.8,
			strokeWeight: 1,
			fillColor: "#7777aa",
			fillOpacity: 0.35
		});
	
	  	this.polygone.setMap(this.map);
  	}
  	
  	Wpj.GeocodingMap.geocodePlace();
}
	
Wpj.GeocodingMap.geocodePlace = function(){
	
	this.geocoder.geocode( { 'address':geocodeSearch }, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			$('#geocodeResult').empty();
			for (var i=0;i<results.length;i++){
				var result = results[i];
				
				var li = $('<li></li>');
				
				// info
				var info = result.geometry.location;
				
				
				// titel
				var titel = ""+result.formatted_address+" ";
				$(li).append(titel);
				// link
				var link = $('<a>Koordinaten uebernehmen</a>');
				link.click(Wpj.GeocodingMap.loadCoordinates);
				link.data('result', result);
				$(li).append(link);
				
				//console.log(result);
				
				$(li).append("<p>"+info+"</p>");
				$('ul#geocodeResult').append(li);
			}
			
			
		} else {
			
		}
	});
}

Wpj.GeocodingMap.loadCoordinates = function(){
	var r = $(this).data('result');
	
	$('input[name="tx_wpj_pi1[place][lat]"]').attr('value', r.geometry.location.lat());
	$('input[name="tx_wpj_pi1[place][lng]"]').attr('value', r.geometry.location.lng());
		
	Wpj.GeocodingMap.marker.setPosition(r.geometry.location);
}