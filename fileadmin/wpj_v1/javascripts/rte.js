$().ready(function() {
	
	$('textarea.mceEditor').tinymce({			
		//script_url : 'http://localhost:3002/javascripts/tiny_mce/tiny_mce.js',
		browsers : "msie,gecko,safari",
		cleanup : true,
		cleanup_on_startup : true,
		convert_fonts_to_spans : true,
		convert_urls : false,
		extended_valid_elements : '',
		mode : 'textareas',
		plugin_preview_height : '650',
		plugin_preview_pageurl : '../../../../../posts/preview',
		plugin_preview_width : '950',
		plugins : "media,preview,inlinepopups,safari,paste,fullscreen",
		relative_urls : false,
		theme : 'advanced',
		theme_advanced_buttons1 : "bold,italic,underline,separator,indent,outdent,separator,bullist,numlist,separator,link,unlink,separator,code,fullscreen",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_layout_manager : 'SimpleLayout',
		theme_advanced_resize_horizontal : false,
		theme_advanced_resizing : true,
		theme_advanced_statusbar_location : 'bottom',
		theme_advanced_toolbar_align : 'left',
		theme_advanced_toolbar_location : 'top',
		setup : function(ed) {
	        
			// Double-Click
	        ed.onDblClick.add(function(ed) {
	            //ed.windowManager.alert('User clicked the editor.');
				//alert(ed.selection.getContent({format : 'text'}));
				
				jQuery.ajax({
					data:'post_id=2&q='+encodeURIComponent(ed.selection.getContent({format : 'text'})) , 
					dataType:'script', 
					type:'post', 
					url:'/posts/new_suggestion'
				})
				
	        });
			
	        // Change
	        ed.onChange.add(function(ed) {
	            //ed.windowManager.alert('User clicked the editor.');
				
				jQuery.ajax({
					data:'post_id=2&q='+encodeURIComponent(ed.getContent()) , 
					dataType:'script', 
					type:'post', 
					url:'/posts/find_suggestion'
				})
				
	        });	
	
	        // Add a custom button
	        ed.addButton('mybutton', {
	            title : 'My button',
	            image : 'img/example.gif',
	            onclick : function() {
	                ed.selection.setContent('<strong>Hello world!</strong>');
	            }
	        });
	    }


	});
});