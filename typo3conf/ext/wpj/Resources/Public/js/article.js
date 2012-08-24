/*
 *	functions for the article view
 */

if(!window.Wpj){
  Wpj = {};
  Wpj.previousSavedData;
}



// first loading in show-mode
$(document).ready(function(){
  // init boxes

  Wpj.TagBox.init();
  Wpj.MediaBox.init();
  Wpj.AuthorsBox.init();

  Wpj.VersionsBox.init();
/*  //Wpj.MapBox.load();
  
  
  Wpj.ArticletypeBox.stopEditMode();
*/  
  // editing buttons
  $("#startEditing").click(Wpj.startEditMode);
  $("#editOptions").hide(); // hide all editor buttons
  $("#manageAuthorsOptions").hide();
  
  // detect mobile devices
  var deviceAgent = navigator.userAgent.toLowerCase();
  Wpj.isMobileDevice = deviceAgent.match(/(iphone|ipod|ipad)/);
  
  Wpj.mode = "show"; // possible states are show & edit & save
});

Wpj.startEditMode = function(){
	if (Wpj.mode == "show" && !Wpj.isMobileDevice) {
		// boxes 
		Wpj.TagBox.startEditMode();
		Wpj.ArticletypeBox.startEditMode();
		Wpj.MediaBox.startEditMode();
		Wpj.MapBox.startEditMode();
		Wpj.AuthorsBox.startEditMode();
		
		
		// start aloha
		Wpj.Aloha.init();
		
		// show save-buttons
		$("#editThis").hide(); // the clicked button
		$("#editOptions").show(); // show all editor buttons
		
		// button-eventhandler
		$("#butSave").click(Wpj.saveAjax);
		$('#butSaveAndExit').click(Wpj.save);
		$('#butBreak').click(Wpj.stopEditMode);
		
		$(window).bind('beforeunload', Wpj.alertOnUnload);
		
		// start timer for autosave
		clearTimeout(Wpj.autoSaveTimer);
		//Wpj.autoSaveTimer = setInterval("Wpj.saveAjax()",60000);
		
		Wpj.mode = "edit";
	}
	return false; 
}

Wpj.stopEditMode = function(){
	if (Wpj.mode == "edit" || Wpj.mode == "save") {
		// button-eventhandler
		$(window).unbind('beforeunload', Wpj.alertOnUnload);
		
		// prevent safari aloha-bug: force reload
		window.location.reload();
		
		/*
		// boxes 
		Wpj.TagBox.stopEditMode();
		Wpj.ArticletypeBox.stopEditMode();
		Wpj.MediaBox.stopEditMode();
		Wpj.MapBox.stopEditMode();
		Wpj.AuthorsBox.stopEditMode();
		
		
		// stop aloha
		Wpj.Aloha.stop();
	
		// hide save-buttons
		$("#editThis").show();
		$("#editOptions").hide();
		
	
		// stop timer for autosave
		clearTimeout(Wpj.autoSaveTimer);
		
		Wpj.mode = "show";
		*/
	}
	return false; 
}

Wpj.save = function(event){
	if ($('#articletype').val() == 1) {
		alert("Bitte wähle den Artikeltyp aus dem Auswahlfeld.");
		return false;
	}
	Wpj.prepareSaving();
	$(window).unbind('beforeunload', Wpj.alertOnUnload);
	clearTimeout(Wpj.autoSaveTimer); // stop timer for autosave
	$('#article_form').submit();
	return false; 
}
Wpj.prepareSaving = function(){
	// copy article-textfields into hidden form
	var title = $('#article_title').text()
	var body = $('#article_body').html();
	$("input[name='tx_wpj_pi1[article][title]']").val(title);
	$("input[name='tx_wpj_pi1[article][body]']").val(body);
	
	$("input[name='tx_wpj_pi1[article][articletype]']").val( $('#articletype').val() );
	
	// collect texts from assigned media
	var mediaContent = "";
	// iterate all dom elements which have been made aloha editable
	$(".mediadescription").each(function() {
		// and get their content
		var id = this.id.replace(/mediaDesc_/,'');
		var text = $(this).html().replace(/##/, '').replace(/\n/, '');
		mediaContent += id + "##" + text + "\n";
	});
	
	$('#mediaContent').val(mediaContent);
}
Wpj.saveAjax = function(event){
	Wpj.prepareSaving();
	var data = $("#article_form").serialize()+"&tx_wpj_pi1[ajax]=true";
	var url = $("#article_form").attr('action')+"&type=10";
	
	if (event == undefined && Wpj.previousSavedData == data) { // don't autosave if data unchanged
		//console.log("autosave skipped");
		return false;
	}
	Wpj.previousSavedData = data;
	
	if (event == undefined) {
		// autosave: called by js-timer
		data += "&autosave=true";
	}
	
	$('#saveAjaxSpinner').show();
	$.ajax({
		url: url,
		type: "POST",
		data: data,
		success: function(result){
			if (result == "success"){
				// hide spinner
				$('#saveAjaxSpinner').hide();
			}
		},
	});
	return false; 
}

Wpj.alertOnUnload = function(){
	return 'Alle Änderungen gehen verloren.';
}


/***************************
 *	 TagBox
 */

Wpj.TagBox = {};
Wpj.TagBox.init = function(){
	$("#saveTags").hide();
	Wpj.TagBox.load('');
  	$('#saveTags').bind("click", Wpj.TagBox.addTag);
  	$("#openPlaceWindow").fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoDimensions': false,
		'onComplete': function(){
			Wpj.PlaceWindow.init('place', '#placeList'); 
		},
	});
	$("#openRefPlaceWindow").fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoDimensions': false,
		'onComplete': function(){
			Wpj.PlaceWindow.init('refPlace', '#refplaceList'); 
		},
	});
}

Wpj.TagBox.load = function(list){
	// 1. tagList
	if (list == '' || list == '#tagList'){
		$.ajax({
			url: loadTagBoxUrl+"&tx_wpj_pi1[scope]=tag",
			success: function(result){
				var html = $(result);
				$('#tagList').hide();
				$('#tagList').html(html);
				$('#tagList').fadeIn('slow');
				if (Wpj.mode == "edit") Wpj.TagBox.makeListitemsRemovable('#tagList');
			}
		});
		$("#tagField").tagit({
			source: suggestTagUrl,
			changed: function(){
				$("#saveTags").fadeIn();
				$("#saveTags").addClass('highlight');
			}
		});
	}
	
	// 2. placeList
	if (list == '' || list == '#placeList'){
		$.ajax({
			url: loadTagBoxUrl+"&tx_wpj_pi1[scope]=place",
			success: function(result){
				var html = $(result);
				$('#placeList').hide();
				$('#placeList').html(html);
				$('#placeList').fadeIn('slow');
				if (Wpj.mode == "edit") Wpj.TagBox.makeListitemsRemovable('#placeList');
			}
		});
	}
	
	// 3. refplaceList
	if (list == '' || list == '#refplaceList'){
		$.ajax({
			url: loadTagBoxUrl+"&tx_wpj_pi1[scope]=refplace",
			success: function(result){
				var html = $(result);
				$('#refplaceList').hide();
				$('#refplaceList').html(html);
				$('#refplaceList').fadeIn('slow');
				if (Wpj.mode == "edit") Wpj.TagBox.makeListitemsRemovable('#refplaceList');
			}
		});
	}
	
}

Wpj.TagBox.addTag = function(){
	var data = [];
	
	// collect tags
	$('ul.tagit').children('.tagit-choice').each(function(i){
		var uid = $(this).data('uid');
		if (uid>0){
			// existing selected tags 
			var taxonomy = $(this).data('taxonomy');
			var label = $(this).data('label');
			data.push({'uid': uid, 'taxonomy': taxonomy, 'label': label});
		} else {
			// new tags
			$('a', this).remove();
			var label = $(this).text();
			data.push({'label': $.trim(label)});
		}
	});	
	
	// unfinished tag in tagit-input?
	var label = $('input.tagit-input').val();
	if (label.length>1){
		data.push({'label': $.trim(label)});
	}

	$.ajax({
		url: addTagUrl,
		//type: "POST",
        data:  { 
        	'tx_wpj_pi1[json]': JSON.stringify(data) 
        },
        contentType: "application/json; charset=utf-8", 
		success: function(result){
			if (result == "success"){
				// highlight
				$('#taglist').fadeOut('fast');
				// load updated properties
				Wpj.TagBox.load('#tagList');
				$("#tagField").val('');
				$("#saveTags").hide(); // hide button again
			}
		},
	});
	return false; // prevent from sending form
}
Wpj.TagBox.startEditMode = function(){	
	Wpj.TagBox.makeListitemsRemovable('');
}
Wpj.TagBox.makeListitemsRemovable = function(ul){	
	$('ul'+ul+'.removable-items li').each(function(){
		var id = $(this).attr('id');
		if (id){
			var uid = parseInt(id.split('_').pop()); // extract id from e.g. tag_4
			if (uid > 0){ // ignore items without id
				var $removeLink = $('<a>', {text: "X", title: "entfernen", href: "#"});
				$(this).append( $removeLink );
				$removeLink.wrap('<span>');
				$removeLink.click(Wpj.TagBox.deleteTag);
				$(this).children().first().bind('click', function(){return false;}); // disable link on label
			}
		}
	})
}

Wpj.TagBox.deleteTag = function(event){
	if (!confirm('Wirklich entfernen?')) return false;
	// this a:span:li
	var $li = $(this).parent().parent();
	var id = String($li.attr('id')).split("_");
	var url = removeTagUrl + '&tx_wpj_pi1[tag]='+id[1];
	$.ajax({
		url: url,
		success: function(result){
			if (result == "success"){
				// load updated properties
				//Wpj.TagBox.load('');
			}
		},
	});
	$li.hide('slow');
	return false;
}
Wpj.TagBox.stopEditMode = function() {
	Wpj.TagBox.load('');
	$('ul.removable-items').removeClass('ul-edit');
	
}


/***************************
 *	 MediaBox
 */ 
Wpj.MediaBox = {};

Wpj.MediaBox.init = function() {
	Wpj.MediaBox.load();
  	$("#addMediaLink").hide();
	$("#addMediaLink").fancybox({
		'type' : 'iframe',
		'width' : '80%',
		'height' : '80%',
		'onCleanup': function(){
			Wpj.MediaBox.load();
		}
	});	
}

Wpj.MediaBox.load = function(){
	$.ajax({
		url: loadMediaBoxUrl,
		success: function(result){
			var html = $(result);
			$('#medialist').html(html);
			$('#medialist').fadeIn('fast');
			VideoJS.setupAllWhenReady();
			audiojs.createAll();
			$("a.openInFancybox").fancybox({});	
			if (Wpj.mode == "edit") Wpj.Aloha.init();
		}
	});
}

Wpj.MediaBox.startEditMode = function(){
  	$("#addMediaLink").show();
/*	$("#test-list").sortable({
		handle: '.handle',
		update: function(){
			$("input#test-log").val($('#test-list').sortable('serialize'));
		}
	});
*/
}

Wpj.MediaBox.stopEditMode = function(){
  	$("#addMediaLink").hide();
	
}

/***************************
 *	 MapBox
 */
Wpj.MapBox = {};
Wpj.MapBox.load = function(){
	$.ajax({
		url: loadMapBoxUrl,
		success: function(result){
			var html = $(result);
			$('#placeslist').html(html);
			$('#placeslist').fadeIn('slow');
			
			$("#map_canvas").css({
				width: 620, 
				height: 450
			});
			var center = new google.maps.LatLng(50.99066, 11.3305);
			WpjMap.init('#map_canvas', center, 13);
			WpjMap.placeMarkers(loadMapXmlUrl);
		}
	});
}
Wpj.MapBox.startEditMode = function(){

}
Wpj.MapBox.stopEditMode = function(){

}


/***************************
 *	 VersionsBox
 */
Wpj.VersionsBox = {};
Wpj.VersionsBox.init = function(){
	Wpj.VersionsBox.load();
	// versionbox: only for admins
	var loadVersionsBtn = $('#loadVersionsBtn');
	if ($(loadVersionsBtn).length > 0) {
		$(loadVersionsBtn).bind("click", Wpj.VersionsBox.load);
		$('#versionslist').hide();
	}
}
  
Wpj.VersionsBox.load = function(){
	if ( $('#versionslist').length > 0 ){ // only visible for editors
		$.ajax({
			url: loadVersionsBoxUrl,
			success: function(result){
				var html = $(result);
				$('#versionslist').html(html);
				$('#versionslist').fadeIn('slow');
				$('#loadVersionsBtn').hide();
			}
		});
	}
}

/***************************
 *	 ArticletypeBox
 */
Wpj.ArticletypeBox = {};
Wpj.ArticletypeBox.startEditMode = function(){
	if ($('#articletypeSelector').length > 0) $('#articletypeSelector').show();
}
Wpj.ArticletypeBox.stopEditMode = function(){
	if ($('#articletypeSelector').length > 0) $('#articletypeSelector').hide();
}


/***************************
 *	 AuthorsBox
 */
Wpj.AuthorsBox = {};
Wpj.AuthorsBox.init = function(){
	
	Wpj.AuthorsBox.load();
}

Wpj.AuthorsBox.load = function(){
	$.ajax({
		url: loadAuthorsBoxUrl,
		success: function(result){
			var html = $(result);
			$('li', html).addClass('clearfix');
			$('#authorslist').replaceWith(html);
			html.wrap('<div class="authorlist" />');
			$('.authorlist').hide().fadeIn('slow');
		}
	});
}

Wpj.AuthorsBox.startEditMode = function(){
  	$("#manageAuthorsOptions").show();
}

Wpj.AuthorsBox.stopEditMode = function(){
  	$("#manageAuthorsOptions").hide();

}

/***************************
 *	 Aloha
 */
Wpj.Aloha = {};
Wpj.Aloha.init = function() {
	if (!Wpj.isMobileDevice && $("form[name='article']").length != 0) {
		Aloha.jQuery('.alohaEditor').aloha();
	}
};
Wpj.Aloha.stop = function() {
	//$('.alohaEditor').removeAttr("contenteditable");
	//$('.alohaEditor').removeClass("GENTICS_editable");
	//$('.alohaEditor').mahalo(); // causes this error: "An invalid or illegal string was specified" code: "12"

};



/***************************
 *	 Copy selected words into tag-field
 * 	 unfinished
 */
Wpj.Selector = {};
Wpj.Selector.init = function(){
	this.fieldForSelectedText = $('#fieldForSelectedText');
	this.conceptForSelectedText = $('#conceptForSelectedText');	
}

Wpj.Selector.getSelected = function(){
	var t = '';
	if(window.getSelection){
	  t = window.getSelection();
	}else if(document.getSelection){
	  t = document.getSelection();
	}else if(document.selection){
	  t = document.selection.createRange().text;
	}
	return t;
}

Wpj.Selector.mouseup = function(){
	var str = Wpj.Selector.getSelected();
	if (str != '') {
		// copy selected text into textfield
		Wpj.Selector.fieldForSelectedText.val(str);
		
	}
}






/***************************
 *	 PlaceWindow as modalwindow
 */
Wpj.PlaceWindow = {};
Wpj.PlaceWindow.selectedItem = null;
Wpj.PlaceWindow.init = function(taxonomy, targetListId){
	Wpj.PlaceWindow.taxonomy = taxonomy;
	Wpj.PlaceWindow.targetListId = targetListId;
	// first decision: inside or outside
	// reset/hide elements in further steps 
	$('#modalwindow #insideBtn').click(function(){
		$('#modalwindow #insideBuildingDiv').show();
		$('#modalwindow #outsideBuildingDiv').hide();
		$('#searchFieldBuilding').focus();	
		$("a.assignBtn").hide();
		// hide ul
		$('ul#floorList').hide();
		$('ul#roomList').hide();
	});
	$('#modalwindow #outsideBtn').click(function(){
		$('#modalwindow #insideBuildingDiv').hide();
		$('#modalwindow #outsideBuildingDiv').show();
		$('#searchFieldPlace').focus();
		$("a.assignBtn").hide();
	});
	
	
	// configure autosuggests
	// place inside
	$('#searchFieldBuilding').autocomplete({
		source: suggestTagPlaceUrl+"&accuracy=7",
		select: Wpj.PlaceWindow.buildingSelected,
	});	
	// place outside
	$('#searchFieldPlace').autocomplete({
		source: suggestTagPlaceUrl+"&accuracy=-7", // -7 code for <7
		select: Wpj.PlaceWindow.placeSelected,
	});
	
	$("a.assignBtn").bind("click", Wpj.PlaceWindow.assignBtnClickHandler);	
}

// OUTSIDE: place selected: show button to confirm
Wpj.PlaceWindow.placeSelected = function(event, ui) { 
	Wpj.PlaceWindow.selectedItem = ui.item;
	$("a.assignBtn").show();
}

// INSIDE: if building is know, show floors in the next step
Wpj.PlaceWindow.buildingSelected = function(event, ui) { 
	$('#searchFieldBuilding').val(ui.item.label);
	$('#buildingName').text(" im »" + ui.item.label+ "« "); // building in headline
	
	// load floors for next step
	$.ajax({
		url: loadChildrenUrl+"&root="+ui.item.uid,
		dataType: 'json',
		success: Wpj.PlaceWindow.floorsLoaded
	});
	$('div#insideStep2').show();
	$('ul#floorList').addClass('box-loading');
	$('ul#floorList').show();
}

// fill floor list
Wpj.PlaceWindow.floorsLoaded = function(result){
	$('ul#floorList').removeClass('box-loading');
	$("ul#floorList").empty();
	$(result).each(function(index,floor){
		var item = $('<a/>', {text: unescape(floor.label), id: 'floor_'+floor.uid, href: '#'});
		$("ul#floorList").append(item);
		item.wrap('<li>');
		item.bind("click", floor.uid, Wpj.PlaceWindow.floorClickHandler);
	});
}
// load room list
Wpj.PlaceWindow.floorClickHandler = function(event){
	$('ul#floorList li').removeClass('selected-item');
	$(this).parent().addClass('selected-item');
	var uid = event.data;
	$.ajax({
		url: loadChildrenUrl+"&root="+uid,
		dataType: 'json',
		success: Wpj.PlaceWindow.roomsLoaded
	});
	$('ul#roomList').show();
	$('ul#roomList').addClass('box-loading');
	return false;
}
// fill room list
Wpj.PlaceWindow.roomsLoaded = function(result){
	$('ul#roomList').removeClass('box-loading');
	$("ul#roomList").empty();
	$(result).each(function(index,room){
		var item = $('<a/>', {text: room.label, id: 'room_'+room.uid, href: '#'});
		$("ul#roomList").append(item);
		item.wrap('<li>');
		item.bind("click", {label: room.label, uid: room.uid} ,Wpj.PlaceWindow.roomClickHandler);
	});
}
// select room
Wpj.PlaceWindow.roomClickHandler = function(event){
	$('ul#roomList li').removeClass('selected-item');
	$(this).parent().addClass('selected-item');
	$("a.assignBtn").show();
	Wpj.PlaceWindow.selectedItem = event.data;
	return false;
}

Wpj.PlaceWindow.assignBtnClickHandler = function(event){
	Wpj.PlaceWindow.addPlaceTagToArticle();
	$.fancybox.close();
	return false;
}

Wpj.PlaceWindow.addPlaceTagToArticle = function(){
	var data = [];
	data.push({
		'uid': Wpj.PlaceWindow.selectedItem.uid, 
		'taxonomy': Wpj.PlaceWindow.taxonomy,
		'type': 'place', 
	});
	
	$.ajax({
		url: addTagUrl,
        data:  { 
        	'tx_wpj_pi1[json]': JSON.stringify(data) 
        },
        contentType: "application/json; charset=utf-8", 
		success: Wpj.PlaceWindow.placeAdded,
	});
	return false; // prevent from sending form
}
Wpj.PlaceWindow.placeAdded = function(result){
	if (result == "success"){
		$(Wpj.PlaceWindow.targetListId).fadeOut('fast');
		Wpj.TagBox.load(Wpj.PlaceWindow.targetListId);
	}
}
