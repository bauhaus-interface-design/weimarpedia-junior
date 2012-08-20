GENTICS.Aloha.settings = {
	errorhandling : false,
	ribbon: false,	
	"i18n": {"current": "de"},
	"plugins": { 
		"com.gentics.aloha.plugins.GCN": { 
			"enabled": false 
		},
	 	"com.gentics.aloha.plugins.Format": { 
			config : [ 'b', 'i','u','del','sub','sup', 'p', 'a', 'title', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'pre', 'removeFormat'],
		  	editables : {
				title	: [ ], // no formatting allowed
				teaser 	: [ 'b', 'i', 'u', 'del', 'sub', 'sup'  ] // just basic formattings, no headers, etc.
		  	}
		} 
 	}
};

$(document).ready(function() {
	var deviceAgent = navigator.userAgent.toLowerCase();
	var isMobileDevice = deviceAgent.match(/(iphone|ipod|ipad)/);
	if (!isMobileDevice && jQuery("form[name='article']").length != 0) {
		$('.alohaEditor').aloha();
	}
}); 