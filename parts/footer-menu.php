<?php 
if(has_nav_menu( 'footer' )){
	wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu','menu_class'=>'footer-menu' ) );
}else{ ?>
<div class="footer-menu">
	<a href="http://www.shiniuzhai.com/about.html">公司简介</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="http://www.shiniuzhai.com/contact.html">联系我们</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="http://www.shiniuzhai.com/gallery">景区景点</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="http://www.shiniuzhai.com/m">手机版</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="http://www.shiniuzhai.com//index.htm">旧版网站</a>
</div>

<?php }

?>
