//Cambios en la estructura
function changeInterface(){
	$('.banner').css('height', $(window).height());
}

//Muestra los mensajes de cada baner
function showMessages(){

	var positionTop    = parseInt($(window).scrollTop()),
		heightDocument = $(document).height(),
		heightWindow   = $(window).height();

	$('.banner-message').each(function(index, value){
		
		var positionBanner = $(value).offset(),
			positionOn     = parseInt(positionBanner.top) - parseInt((heightWindow/3)),
			msg            = $(value).find('.message');

		if(positionOn < positionTop && !$(msg[0]).is(':visible')){
			moveMessages(msg);
		}
	});

}

//Las capas de los mensajes
//realizan su aparición y movimiento
function moveMessages(msg){
	$(msg).each(function(key, value){
		var id = $(value).attr('id'),
			moveClass = id + '-move';

		$(value).fadeIn('slow');
		$(value).addClass(moveClass);
	});
}

$(document).ready(function() {

	changeInterface();

    $('.scrollto').bind('click', function(e){
        e.preventDefault();
        var target = $(this).attr('data-target');
        $.scrollTo(target, 600, {'axis':'y'});
    });
    
});

$(window).resize(function(){
	changeInterface();
});

$(window).bind('scroll', function(e) {
	showMessages();
});