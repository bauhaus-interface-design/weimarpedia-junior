WpjMap.setGuiHandler = function(){
	
	/*
	 	buildings and floors
	 */
	$('#buildingSelectBox').bind('change', WpjMap.loadFloors);
	$('#updateBuildings').bind('click', WpjMap.loadBuildings);
	
	$('#floorSelectBox').bind('change', WpjMap.loadRooms);
	$('#updateFloors').bind('click', WpjMap.loadFloors);
	
	$('#loadOverlay').bind('click', WpjMap.loadOverlay);
	$('#saveOverlay').bind('click', WpjMap.saveOverlay);
	$('#removeOverlay').bind('click', WpjMap.removeOverlay);
	
	/*
	 	drawing
	 */
	$('#btnEnableDrawing').bind('click', function(event){
		event.preventDefault();
		WpjMapEditor.startDrawing();
	});
	
	$('#btnEnableSelection').bind('click', function(event){
		event.preventDefault();
		WpjMapEditor.startSelecting();
	});
	
	$('#btnDelete').bind('click', function(event){
		event.preventDefault();
		if (WpjMapEditor.selectedPolygone) {
			WpjMapEditor.deletePolygone(WpjMapEditor.selectedPolygone);
			WpjMapEditor.selectedPolygone = null;
		}
	});
	$('#btnDeleteAll').bind('click', function(event){
		event.preventDefault();
		jQuery.each(WpjMapEditor.mapPolygons, function(index, polygone){
			WpjMapEditor.deletePolygone(polygone);
		});
		WpjMapEditor.selectedPolygone = null;
	});
	
	
	/*
	 rooms
	 */
	$('#roomSelectBox').bind('change', function(event){
		var option = $("#roomSelectBox option:selected")[0];
		WpjMapEditor.setSelectedPolygone( $.data(option, 'polygone') );
	});
	$('#roomSelectBox').bind('click', function(event){
		WpjMapEditor.startSelecting();
	});
	$('#updateRooms').bind('click', WpjMap.loadRooms);
	
	$('#btnAssign').bind('click', function(event){
		event.preventDefault();
		var roomOption = $("#roomSelectBox option:selected")[0];
		WpjMapEditor.assignSelectedPolygoneToRoomOption(roomOption);
		WpjMapEditor.startSelecting();
		//$('#updateRooms').trigger('click');
	});
	
	$('#btnRestore').bind('click', function(event){
		event.preventDefault();
		var option = $("#roomSelectBox option:selected")[0];
		var encodedString = $(option).attr('coordinates');
		var decodedMVCObject = google.maps.geometry.encoding.decodePath(encodedString);
		decodedMVCObject = WpjMapEditor.zoomPathIn(decodedMVCObject);
		if (!WpjMapEditor.selectedPolygone) WpjMapEditor.createPolygone();
		WpjMapEditor.selectedPolygone.stopEdit();
		WpjMapEditor.selectedPolygone.setPath(decodedMVCObject);
	});
	
	$('#btnDebug').bind('click', function(event){
		event.preventDefault();
		var output = WpjMap.map.getZoom()+'\n\n';
		WpjMapEditor.selectedPolygone.getPath().forEach( function(latLng, i){
			output += latLng.toString()+",\n";
		});
		
		$('#debug').text(output);
	});
	
	WpjMap.loadBuildings();
}







WpjMap.loadBuildings = function(){
	$.ajax({
		url: loadBuildingsUrl,
		success: function(result){
			var html = jQuery(result);
			$('#buildingSelectBox').html(html);
			// restore last room from cookie
			var room = $.cookie('_selectedRoom');
			$('#buildingSelectBox option[value="' + room + '"]').attr('selected', 'selected');
			// load floors
			WpjMap.loadFloors();
		}
	});
}

WpjMap.loadFloors = function(){
	$.cookie('_selectedRoom', $('#buildingSelectBox').val(), {
		expires: 365,
		path: '/',
		secure: false
	});
	
	$.ajax({
		url: loadChildrenUrl + "&tx_wpj_pi1[place]=" + $('#buildingSelectBox').val(),
		success: function(result){
			var html = jQuery(result);
			jQuery('#floorSelectBox').html(html);
			WpjMap.loadRooms();
		}
	});
}

WpjMap.loadRooms = function(){
	$.ajax({
		url: loadChildrenUrl + "&tx_wpj_pi1[place]=" + $('#floorSelectBox').val(),
		success: function(result){
			var html = jQuery(result);
			jQuery('#roomSelectBox').html(html);
		}
	});
}
