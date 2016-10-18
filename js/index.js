$(function () {
	$(".slideBox").slide({mainCell:".bd ul",effect:"fold",autoPlay:true,delayTime:1000});
	jQuery(".carousel-content").slide({mainCell:".carousel-list",autoPlay:true,effect:"leftMarquee",vis:3,interTime:50});


	$('.shng-titles').on('mouseenter', '.slide-item', function(event) {
		var index = $('.shng-titles .slide-item').index(this);
		$('.slide-images').find('img').hide().eq(index).show();
	});


	$(".index-gallery ul li").hover(function(){

      $(this).children().children('p').slideDown();

      $(this).siblings().children().children('p').slideUp();

  },function(){

      $(this).children().children('p').slideUp();

  })


});

