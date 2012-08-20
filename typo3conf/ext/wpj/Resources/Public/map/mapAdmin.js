
/*
 *	functions for the mapAdmin view
 */

$(document).ready(function(){
	var center = new google.maps.LatLng(50.975938140707335, 11.336810389701828);
	$("#map_canvas").css({
				width: '100%', 
				height: 900
			});
	WpjMap.init('#map_canvas', center, 16);
	WpjMap.setGuiHandler();
});


var WpjMap = {
	map: null,
	overlay: null,
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
	
	
	// historic map-overlay
	var historicMapOptions = {
	  getTileUrl: function(coord, zoom) {
	    //return "http://mt3.google.com/mapstt?" + "zoom=" + zoom + "&x=" + coord.x + "&y=" + coord.y + "";
		return "http://localhost/customMap/m_" + zoom + "_" + coord.x + "_" + coord.y + ".png";
	  },
	  tileSize: new google.maps.Size(256, 256),
	  isPng: true
	};
	var historicMapType = new google.maps.ImageMapType(historicMapOptions);
	//this.map.overlayMapTypes.insertAt(0, historicMapType);

	
	// show custom tool-divs on map
	this.map.controls[google.maps.ControlPosition.RIGHT_TOP].push( $('#overlay-tools')[0] );
	this.map.controls[google.maps.ControlPosition.RIGHT_TOP].push( $('#place-select-tools')[0] );
	this.map.controls[google.maps.ControlPosition.RIGHT_TOP].push( $('#room-select-tools')[0] );
	this.map.controls[google.maps.ControlPosition.RIGHT_TOP].push( $('#place-draw-tools')[0] );
	
	// add overlay in the center of the map, wait until map is loaded to get bounds
	google.maps.event.addListener(this.map, 'tilesloaded', WpjMap.prepareOverlay); // 
	
	WpjMapEditor.init(this.map);

}

WpjMap.prepareOverlay = function() {
	
	google.maps.event.clearListeners(WpjMap.map, 'tilesloaded'); // execute only the first time, map is loaded 
	 
	// calulate bounds for overlay
	var bounds = WpjMap.map.getBounds();
	
	var sLat = bounds.getSouthWest().lat();
	var wLng = bounds.getSouthWest().lng();
	var nLat = bounds.getNorthEast().lat();
	var eLng = bounds.getNorthEast().lng();
	
	// center with 1/3 width and 1/3 height
	var sw = new google.maps.LatLng( sLat+(nLat-sLat)/3 , wLng+(eLng-wLng)/3 );
	var ne = new google.maps.LatLng( sLat+(nLat-sLat)/3*2 , wLng+(eLng-wLng)/3*2 );
  
    var srcImage = $('#overlayImageSelectBox').val();
	WpjMap.overlay = new USGSOverlay(sw, ne,  WpjMap.getOverlayFullPath(srcImage), WpjMap.map);
	
  	// change handler image-select
	$('#overlayImageSelectBox').bind('change', function(event){
		var src = $('#overlayImageSelectBox').val();
		$('#mapOverlayImage').attr("src", WpjMap.getOverlayFullPath(src) );
	});
}

WpjMap.getOverlayFullPath = function(filename) {
    return "typo3conf/ext/wpj/Resources/Public/mapOverlays/"+filename;
}

WpjMap.overlayMarkerChanged = function(event) {
    WpjMap.overlay.draw();
}

WpjMap.loadOverlay = function(event){
	var option = $('#floorSelectBox option:selected')[0];
	
	// image
	var image = $(option).attr('image');
	$('#mapOverlayImage').attr("src", WpjMap.getOverlayFullPath(image) );
	
	// position
	var coordinatesStr = $(option).attr('coordinates');
	if (coordinatesStr != '') {
		var coordinates = google.maps.geometry.encoding.decodePath( WpjMapEditor.zoomPathIn(coordinatesStr) );
		WpjMap.overlay.swMarker.setPosition(coordinates[0]);
		WpjMap.overlay.neMarker.setPosition(coordinates[1]);
		WpjMap.overlayMarkerChanged();
		
		// pan to overlay
		var bounds = new google.maps.LatLngBounds();
		bounds.extend(coordinates[0]);
		bounds.extend(coordinates[1]);
		WpjMap.map.fitBounds(bounds);
	}
}

WpjMap.saveOverlay = function(event){
	var option = $('#overlayImageSelectBox option:selected')[0];
	
	// image
	var image = $(option).attr('value');
	
	// position to path
	var path = new google.maps.MVCArray();
	path.push(WpjMap.overlay.swMarker.getPosition());
	path.push(WpjMap.overlay.neMarker.getPosition());
	
	// calculate center of polygone for marker
	var bounds = new google.maps.LatLngBounds();
	path.forEach (function(latLng){
	  bounds.extend(latLng);
	});
	var center = bounds.getCenter();
		
	var encodedPath = google.maps.geometry.encoding.encodePath( WpjMapEditor.zoomPathOut(path) );
		
	$.ajax({
		url: savePolygoneUrl,
		type: 'POST',
		data: ({
			'tx_wpj_pi1[place][__identity]': $('#floorSelectBox').val(),
			'tx_wpj_pi1[place][coordinates]': encodedPath,
			'tx_wpj_pi1[place][lat]': center.lat(),
			'tx_wpj_pi1[place][lng]': center.lng(),
			'tx_wpj_pi1[place][image]': image,
			
		}),
		success: function(result){
			$('#floor-messages').text('ist gespeichert');
			$('#floor-messages').delay(4000).fadeOut();
			$('#updateFloors').trigger('click');
		}
	});
}

WpjMap.removeOverlay = function(event){
	$.ajax({
		url: savePolygoneUrl,
		type: 'POST',
		data: ({
			'tx_wpj_pi1[place][__identity]': $('#floorSelectBox').val(),
			'tx_wpj_pi1[place][coordinates]': '',
			'tx_wpj_pi1[place][lat]': 0,
			'tx_wpj_pi1[place][lng]': 0,
			'tx_wpj_pi1[place][image]': '',
			
		}),
		success: function(result){
			$('#floor-messages').text('ist entfernt');
			$('#floor-messages').delay(4000).fadeOut();
			$('#updateFloors').trigger('click');
		}
	});
}

function USGSOverlay(sw, ne, image, map) {

  this.image_ = image;
  this.map_ = map;

  var markerImg = new google.maps.MarkerImage('typo3conf/ext/wpj/Resources/Public/map/vertex.png',
      new google.maps.Size(11, 11), new google.maps.Point(0, 0),
      new google.maps.Point(6, 6));
  this.swMarker = new google.maps.Marker({
      position: sw,
	  draggable: true,
	  cursor: "pointer",
	  flat: true,
	  icon: markerImg,
      raiseOnDrag : false,
  });
  this.swMarker.setMap(this.map_); 
  google.maps.event.addListener(this.swMarker, 'dragend', WpjMap.overlayMarkerChanged);
  
  this.neMarker = new google.maps.Marker({
      position: ne,
	  draggable: true,
	  cursor: "pointer",
	  flat: true,
	  icon: markerImg,
      raiseOnDrag : false,
  });  
  this.neMarker.setMap(this.map_); 
  google.maps.event.addListener(this.neMarker, 'dragend', WpjMap.overlayMarkerChanged);
  
  
  // We define a property to hold the image's
  // div. We'll actually create this div
  // upon receipt of the add() method so we'll
  // leave it null for now.
  this.div_ = null;

  // Explicitly call setMap() on this overlay
  this.setMap(this.map_);
}

USGSOverlay.prototype = new google.maps.OverlayView();
USGSOverlay.prototype.onAdd = function() {

  // Note: an overlay's receipt of onAdd() indicates that
  // the map's panes are now available for attaching
  // the overlay to the map via the DOM.

  // Create the DIV and set some basic attributes.
  var div = document.createElement('DIV');
  div.style.border = "none";
  div.style.borderWidth = "0px";
  div.style.position = "absolute";

  // Create an IMG element and attach it to the DIV.
  var img = document.createElement("img");
  img.src = this.image_;
  img.style.width = "100%";
  img.style.height = "100%";
  img.id = "mapOverlayImage";
  div.appendChild(img);

  // Set the overlay's div_ property to this DIV
  this.div_ = div;

  // We add an overlay to a map via one of the map's panes.
  // We'll add this overlay to the overlayImage pane.
  var panes = this.getPanes();
  panes.overlayLayer.appendChild(div);
}
USGSOverlay.prototype.draw = function() {

  // Size and position the overlay. We use a southwest and northeast
  // position of the overlay to peg it to the correct position and size.
  // We need to retrieve the projection from this overlay to do this.
  var overlayProjection = this.getProjection();

  // Retrieve the southwest and northeast coordinates of this overlay
  // in latlngs and convert them to pixels coordinates.
  // We'll use these coordinates to resize the DIV.
  var sw = overlayProjection.fromLatLngToDivPixel(this.swMarker.getPosition());
  var ne = overlayProjection.fromLatLngToDivPixel(this.neMarker.getPosition());

  // Resize the image's DIV to fit the indicated dimensions.
  var div = this.div_;
  div.style.left = sw.x + 'px';
  div.style.top = ne.y + 'px';
  div.style.width = (ne.x - sw.x) + 'px';
  div.style.height = (sw.y - ne.y) + 'px';
}

USGSOverlay.prototype.hide = function() {
  if (this.div_) {
    this.div_.style.visibility = "hidden";
  }
}

USGSOverlay.prototype.show = function() {
  if (this.div_) {
    this.div_.style.visibility = "visible";
  }
}

USGSOverlay.prototype.toggle = function() {
  if (this.div_) {
    if (this.div_.style.visibility == "hidden") {
      this.show();
	  this.swMarker.setMap(this.map_);
	  this.neMarker.setMap(this.map_);
	  
    } else {
      this.hide();
	  this.swMarker.setMap(null);
	  this.neMarker.setMap(null);
    }
  }
}

USGSOverlay.prototype.toggleMarker = function() {
  if (this.getMap()) {
    this.setMap(null);
  } else {
    this.setMap(this.map_);
  }
}

USGSOverlay.prototype.toggleDOM = function() {
  if (this.getMap()) {
    this.setMap(null);
  } else {
    this.setMap(this.map_);
  }
}



