(function($) {

	$.fn.tagit = function(options) {
		var options = options;
		var el = this;
		const BACKSPACE		= 8;
		const ENTER			= 13;
		const SPACE			= 32;
		const COMMA			= 44;
		const TAB			= 9;

		// add the tagit CSS class.
		el.addClass("tagit");

		// create the input field.
		var html_input_field = "<li class=\"tagit-new\"><input class=\"tagit-input\" type=\"text\" placeholder=\"Tag hinzufügen\"/></li>\n";
		el.html (html_input_field);

		var tag_input = el.children(".tagit-new").children(".tagit-input");

		$(this).click(function(e){
			if (e.target.tagName == 'A') {
				// Removes a tag when the little 'x' is clicked.
				// Event is binded to the UL, otherwise a new tag (LI > A) wouldn't have this event attached to it.
				$(e.target).parent().remove();
			}
			else {
				// Sets the focus() to the input field, if the user clicks anywhere inside the UL.
				// This is needed because the input field needs to be of a small size.
				tag_input.focus();
			}
		});

		tag_input.keypress(function(event){
			if (event.which == BACKSPACE) {
				if (tag_input.val() == "") {
					// When backspace is pressed, the last tag is deleted.
					$(el).children(".tagit-choice:last").remove();
				}
			}
			// Comma/Space/Enter are all valid delimiters for new tags.
			else if (event.which == COMMA || event.which == ENTER || event.which == TAB) {
				event.preventDefault();

				var typed = tag_input.val();
				typed = typed.replace(/,+$/,"");
				typed = typed.trim();

				if (typed != "") {
					if (is_new ({label: typed})) {
						create_choice ({label: typed});
					}
					// Cleaning the input.
					tag_input.val("");
					options.changed.call();
				}
			}
		});

		tag_input.autocomplete({
			source: options.source, 
			select: selectHandler
		});
		
		function selectHandler(event,ui){
			if (is_new (ui.item)) {
				create_choice (ui.item);
			}
			// Cleaning the input.
			tag_input.val("");
			
			options.changed.call();
			
			// Preventing the tag input to be update with the chosen value.
			return false;
		}
		
		function is_new (item){
			var is_new = true;
			var label;
			tag_input.parents("ul").children(".tagit-choice").each(function(i){
				var uid = $(this).data('uid');
				var type = $(this).data('type');
				var label = $(this).data('label');
				
				//console.log(uid+", "+type+", "+label);
				if (item.uid == uid && uid > 0 && item.type == type) {
					// same existing tag or place
					is_new = false;
					return false;
				} else if (item.label == label){
					// same new tag
					is_new = false;
					return false;
				}
			})
			return is_new;
		}
		function create_choice (item){
			var li_search_tags = tag_input.parent();
			var el = "";
			el  = "<li class=\"tagit-choice\">\n";
			el += item.label + "\n";
			el += "<a class=\"close\">x</a>\n";
			el += "</li>\n";
			var li = $(el).insertBefore(li_search_tags);
			
			$(li).data("uid", item.uid);
			$(li).data("taxonomy", item.taxonomy);
			$(li).data("label", item.label);
			$(li).data("type", item.type);
			
			tag_input.val("");
		}
	};

	String.prototype.trim = function() {
		return this.replace(/^\s+|\s+$/g,"");
	};

})(jQuery);
