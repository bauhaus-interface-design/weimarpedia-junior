(function(window, undefined) {
	var jQuery = window.jQuery
	if (window.Aloha === undefined || window.Aloha === null) {
		window.Aloha = {};		
	}
	window.Aloha.settings = {
				//logLevels: {'error': true, 'warn': true, 'info': true, 'debug': true},
				errorhandling : false,
				ribbon: false,

				"i18n": {
					"current": "de"
				},
				"repositories": {
					"linklist": {
						suggestUrl: suggestArticleUrl,
					}
				},
				/*
				"toolbar":{
					"tabs" : {
				        // will generate a tab labeled "formatting"
				        "Formatierung" : {
				            // group "flow"
				            flow : [ 'b', 'em', 'u' ],
				            // group "phrasing"
				            phrasing : [ 'phrasing' ] // "phrasing" is the name of a
				            // MultiSplitButton from the format plugin, which contains
				            // elements like h1 ...
				        },
				        // will generate another tab labeled "insert"
				        "href" : {
				            // as mentioned group names are not displayed anywhere,
				            // so you might pick an arbitrary name
				            first : [ 'insertLink', 'href', 'removeLink']
				        }
				    },
				},
				*/
				"plugins": {
					"format": {
						config : [ 'b', 'i','u', 'p', 'a', 'title', 'h4','h5', 'removeFormat', 'charakterpicker'],
							editables : {
							// no formatting allowed for title
							'h3'	: [ ],
							'.mediadescription' 	: [ 'b', 'i' ]
							}
					},
					"list": {
						config : [ 'ul', 'ol' ],
							editables : {
							'h3': [],
							'.mediadescription': []
							}
					},
					"link": {
						config : [ 'a' ],
							editables : {
							'h3'	: [  ],
							'.mediadescription': []
							}
					},
					
				}
			};
})(window);

