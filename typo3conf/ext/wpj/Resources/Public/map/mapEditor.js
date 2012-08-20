
/*
	WpjMapEditor

*/

var WpjMapEditor = {
  	map: null,
  	strokeColor: '#888888',
  	strokeColorHighlight: '#eeeeee',
	mapPolygons: null, // array
	selectedPolygone: null,
	mode: null,
}

WpjMapEditor.init = function(map_){
	this.map = map_;
	this.mapPolygons = new Array();
	
/*
	this.mapPolygons[0] = new google.maps.Polygon({
		map : this.map,
        strokeColor   : this.initialColor,
        strokeOpacity : 0.7,
        strokeWeight  : 2,
		fillColor 	: "#888888",
        path:[
			new google.maps.LatLng(50.9759, 11.33681),			
			new google.maps.LatLng(50.9789, 11.33631),
			new google.maps.LatLng(50.9759, 11.33781),
		]
       });
*/
	
	// start selection mode   
	WpjMapEditor.startSelecting();
	
	
	
}		
WpjMapEditor.startDrawing = function(){
	if (WpjMapEditor.selectedPolygone) WpjMapEditor.selectedPolygone.runEdit(true);
	$('#editorMode').text('zeichnen');
	
	// eventhandler
	google.maps.event.clearListeners(WpjMapEditor.map , 'click');
	google.maps.event.addListener(WpjMapEditor.map , 'click', WpjMapEditor.drawClickHandler);

	jQuery.each(WpjMapEditor.mapPolygons, function(index, polygone){
		google.maps.event.clearListeners(polygone , 'click');
	});
	WpjMapEditor.mode = "draw";
	$('#btnEnableSelection img').css('background-color', '#fff');
	$('#btnEnableDrawing img').css('background-color', '#ddd');
}
WpjMapEditor.startSelecting = function(){
	// stop editing all polygones
	jQuery.each(WpjMapEditor.mapPolygons, function(index, polygone){
		polygone.stopEdit();
	});
	
	$('#editorMode').text('markieren');
	
	// eventhandler
	google.maps.event.clearListeners(WpjMapEditor.map , 'click');
	google.maps.event.addListener(WpjMapEditor.map , 'click', WpjMapEditor.selectionClickHandler);
	jQuery.each(WpjMapEditor.mapPolygons, function(index, polygone){
		google.maps.event.addListener(polygone , 'click', WpjMapEditor.selectionClickHandler);
	});
	WpjMapEditor.mode = "select";
	$('#btnEnableDrawing img').css('background-color', '#fff');
	$('#btnEnableSelection img').css('background-color', '#ddd');
}
WpjMapEditor.drawClickHandler = function(event){
	if (WpjMapEditor.selectedPolygone){
		// extend polygone
		var path = WpjMapEditor.selectedPolygone.getPath();
		path.push(event.latLng);
	}else{
		// create new polygone
		WpjMapEditor.createPolygone();
		var path = WpjMapEditor.selectedPolygone.getPath();
		path.push(event.latLng);
		WpjMapEditor.selectedPolygone.setPath( path );
	}
	// update polygone
	WpjMapEditor.selectedPolygone.stopEdit();
	WpjMapEditor.selectedPolygone.runEdit();
}

WpjMapEditor.createPolygone = function(){
	var mapPolygon = new google.maps.Polygon({
		map: WpjMapEditor.map,
		strokeColor: WpjMapEditor.strokeColor,
		strokeOpacity: 0.7,
		strokeWeight: 3,
		fillColor: WpjMapEditor.getRandomColor(),
	});
	WpjMapEditor.mapPolygons.push(mapPolygon);
	WpjMapEditor.selectedPolygone = mapPolygon;
}
		
WpjMapEditor.setSelectedPolygone = function(polygone){
	if (WpjMapEditor.selectedPolygone) {
		WpjMapEditor.selectedPolygone.setOptions({
			strokeColor: WpjMapEditor.strokeColorHighlight,
	        strokeWeight  : 1,
	        strokeOpacity : 0.7,
		});
	}
	WpjMapEditor.selectedPolygone = polygone;
	if (polygone) {
		WpjMapEditor.selectedPolygone.setOptions({
			strokeColor: WpjMapEditor.strokeColor,
	        strokeWeight  : 2,
	        strokeOpacity : 1.0,
		});
		if ($('#roomSelectBox').val()) $('#btnAssign').show();
	} else {
		$('#btnAssign').hide();
	}
}

WpjMapEditor.selectionClickHandler = function(event){
	WpjMapEditor.setSelectedPolygone( (this instanceof google.maps.Map) ? null : this );
	
}
WpjMapEditor.getRandomColor = function(){
	return '#'+Math.floor(Math.random()*0x66+0x88).toString(16)+Math.floor(Math.random()*0x66+0x88).toString(16)+Math.floor(Math.random()*0x66+0x88).toString(16);
}

WpjMapEditor.assignSelectedPolygoneToRoomOption = function(roomOption){
	if (WpjMapEditor.selectedPolygone) {
		$.data(roomOption, 'polygone', WpjMapEditor.selectedPolygone);
		$(roomOption).css('background', WpjMapEditor.selectedPolygone.fillColor);
	} else {
		$.data(roomOption, 'polygone', null);
		$(roomOption).css('background', 'transparent');
	}
	WpjMapEditor.saveRoomOption(roomOption);
}

WpjMapEditor.saveRoomOption = function(roomOption){
	var polygone = $(roomOption).data('polygone');
	if (polygone) {	
		
		// calculate center of polygone for marker
		var bounds = new google.maps.LatLngBounds();
		polygone.getPath().forEach (function(latLng){
		  bounds.extend(latLng);
		});
		var center = bounds.getCenter();
		
		var encodedPath = google.maps.geometry.encoding.encodePath( WpjMapEditor.zoomPathOut(polygone.getPath()) );
		$('#room-messages').fadeIn().text('...');
		$.ajax({
			url: savePolygoneUrl,
			type: 'POST',
			data: ({
				'tx_wpj_pi1[place][__identity]': $('#roomSelectBox').val(),
				'tx_wpj_pi1[place][coordinates]': encodedPath,
				'tx_wpj_pi1[place][lat]': center.lat(),
				'tx_wpj_pi1[place][lng]': center.lng(),
			}),
			success: function(result){
				$('#room-messages').text('ist gespeichert');
				$('#room-messages').delay(4000).fadeOut();
			}
		});
	}
}
/*
	According to http://code.google.com/intl/de-DE/apis/maps/documentation/utilities/polylinealgorithm.html
	GMaps uses a 5 digits resolution for encoding polylines 
	this is acceptable up to zoom 18
	we need a much higher resolution, so we transform the path by zooming
	
*/
WpjMapEditor.zoomPathOut = function(sourcePath){ // before saving
	var newlatLng;
	var path = new google.maps.MVCArray();
	sourcePath.forEach (function(sourceLatLng){
		newlatLng = new google.maps.LatLng(
			(sourceLatLng.lat()-51)*20, 
			(sourceLatLng.lng()-11)*20
		);
		path.push(newlatLng);
	});	
	return path;
}

WpjMapEditor.zoomPathIn = function(path){ // after loading
	var sourcelatLng;
	var sourcePath = new google.maps.MVCArray();
	path.forEach (function(latLng){
		sourcelatLng = new google.maps.LatLng(
			latLng.lat()/20+51, 
			latLng.lng()/20+11
		);
		sourcePath.push(sourcelatLng);
	});	
	return sourcePath;
}

WpjMapEditor.deletePolygone = function(polygone){
	polygone.stopEdit();
	polygone.setMap(null);
}






