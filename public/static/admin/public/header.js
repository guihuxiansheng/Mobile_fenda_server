$(function(){
	$('.content-menu .menu-list>ul>li>a').click(function(e){
		if(!e.originalEvent){
			return;
		}
		if($(this).parent().hasClass('in')){
			$(this).parent().removeClass('in');
		}else{
			$(this).parents('.menu-list').find('.in').removeClass('in').children('a').click();
			$(this).parent().addClass('in');
		}
	});
	$('.content .top-menu .menu-left i').click(function(){
		if($(this).parents('.content').hasClass('cur')){
			$(this).parents('.content').removeClass('cur');
			$('.content-menu').removeClass('cur');
			return;
		}
		$(this).parents('.content').addClass('cur');
		$('.content-menu').addClass('cur');
		$('.menu-list').find('.in').removeClass('in').children('a').click();
	});
	// $('.content-menu').hover(function(){
	// 	if($('.content').hasClass('cur')){
	// 		if($(this).hasClass('cur')){
	// 			$(this).removeClass('cur');
	// 			return;
	// 		}
	// 		$(this).addClass('cur');
	// 		$('.menu-list').find('.in').removeClass('in').children('a').click();
	// 	}
	// })
})