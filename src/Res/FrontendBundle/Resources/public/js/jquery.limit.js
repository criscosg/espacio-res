(function($){ 
     $.fn.extend({  
         limit: function(limit,element,type) {
			
			var interval, f;
			var self = $(this);
					
			$(this).focus(function(){
				interval = window.setInterval(substring,100);
			});
			
			$(this).blur(function(){
				clearInterval(interval);
				substring();
			});
			
			substringFunction = "function substring(){ var val = $(self).val();var length = val.length;if(type == \"word\"){var initWhites = /^ /;var lastWhites = / $/;var severalWhites = /[ ]+/g;val = val.replace (severalWhites,\" \");val = val.replace (initWhites,\"\");val = val.replace (lastWhites,\"\");var valPieces = val.split(\" \");length = valPieces.length;}if(length > limit){$(self).val($(self).val().substring(0,limit));}";
			if(typeof element != 'undefined')
				substringFunction += "if($(element).html() != limit-length){$(element).html((limit-length<=0)?'0':limit-length);}"
				
			substringFunction += "}";
			
			eval(substringFunction);
			substring();
			
        } 
    }); 
})(jQuery);
