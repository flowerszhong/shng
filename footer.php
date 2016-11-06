<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package shng
 */

?>

	</div><!-- #content -->

	<div class="footer">
	  <div class="contain">
		  <div class="site-wechat">
		  	<img src="<?php echo get_theme_mod( 'wechat_image', 'false' ); ?>" alt="网站二维网" />
		  </div>
		  <?php get_template_part( 'parts/footer', 'menu' ); ?>
		  <?php get_template_part( 'parts/footer', 'friendlink' ); ?>

		   <div class="address"> 地址：
		   <?php echo get_theme_mod( 'address', '中国湖南省株洲市炎陵县神农谷风景区' ); ?> </div>
		   <div class="copyright">
		   <?php echo get_theme_mod( 'copyright', 'Copyright © 2010 - 2016 http://shennongu.com All Rights Reserved. 神农谷 版权所有' ); ?>
		    </div>
		    <div class="icp">
		    	<?php echo get_theme_mod( 'icp', '湘ICP备16016951号' ); ?>
		    </div>
	  </div>
	</div>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'shng' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'shng' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			Theme Shng By <?php echo get_theme_mod( 'support', 'http://quickweb.mzh.ren' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

	<?php get_template_part( 'parts/footer', 'kf' ); ?>

<?php wp_footer(); ?>

</body>
</html>
