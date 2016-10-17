$(function () {
	$("#primary-menu>li").on('mouseenter', function(event) {

		$(this).addClass('hover-menu-item');
		$(this).find('.sub-menu').slideDown();
		event.preventDefault();
		/* Act on the event */
	}).on('mouseleave', function(event) {
		var $this=$(this);
		if($this.find('.sub-menu').length){
			$this.find('.sub-menu').slideUp(400,function () {
				$this.removeClass('hover-menu-item');
			});
		}else{
			$this.removeClass('hover-menu-item');
		}
		/* Act on the event */
	});
});