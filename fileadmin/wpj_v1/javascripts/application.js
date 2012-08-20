
if(!window.Wpj){
  Wpj = {};
}



Wpj.Helper = {};
Wpj.Helper.init = function(){
	// copy aloha-text into hidden form
	jQuery('#submitArticleForm').click(function(event){
		var title = jQuery('#article_title').text()
		var body = jQuery('#article_body').html();
		
		jQuery("input[name='tx_wpjv1_pi1[article][title]']").val(title);
		jQuery("textarea[name='tx_wpjv1_pi1[article][body]']").html(body);
		
		jQuery('#sendHiddenForm').click();
	});
}


Wpj.Selector = {};
Wpj.Selector.init = function(){
	this.fieldForSelectedText = jQuery('#fieldForSelectedText');
	this.conceptForSelectedText = jQuery('#conceptForSelectedText');	
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
Wpj.Selector.sendProperty = function(){
	var url = wpj_ajaxUrl + "&tx_wpjv1_pi1[tag][caption]="+Wpj.Selector.fieldForSelectedText.val();
	url += "&tx_wpjv1_pi1[tag][concept]="+Wpj.Selector.conceptForSelectedText.val();
	$.ajax({
		url: url,
		success: function(result){
			if (result == "success"){
				// highlight
				jQuery('#taglist').fadeOut('fast');
				// load updated properties
				Wpj.Selector.loadProperties();
			}
		},
	});
}

Wpj.Selector.loadProperties = function(){
	$.ajax({
		url: wpj_updateUrl,
		success: function(result){
			var html = jQuery(result);
			jQuery('a', html).each(function(){
					jQuery(this).click(Wpj.Selector.deleteProperty);
				}
			)
			
			jQuery('#taglist').replaceWith(html);
			jQuery('#taglist').fadeIn('slow');
		}
	});
}

Wpj.Selector.deleteProperty = function(event){
	
	jQuery(this).hide('slow');
	
	var url = jQuery(this).attr('href');
	url += '&type=10';
	$.ajax({
		url: url,
		success: function(result){
			if (result == "success"){
				// load updated properties
				//Wpj.Selector.loadProperties();
			}
		},
	});
	//event.preventDefault();
	return false;
}


$(document).ready(function(){
  $(document).bind("mouseup", Wpj.Selector.mouseup);
  $('#sendProperty').bind("click", Wpj.Selector.sendProperty);
  Wpj.Selector.init();
  Wpj.Helper.init();
  if ( $('#taglist').length != 0 ) Wpj.Selector.loadProperties();
});