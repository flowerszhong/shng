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
	  <?php get_template_part( 'parts/footer', 'menu' ); ?>
	  <?php get_template_part( 'parts/footer', 'friendlink' ); ?>

	   <div class="address"> 地址：中国湖南省岳阳平江石牛寨景区 </div>
	   <div class="copyright">
	      Copyright © 2010 - 2016 www.shiniuzhai.com All Rights Reserved. 石牛寨 版权所有 <br>
	      湘ICP备12010097号
	    </div>
	  </div>
	</div>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'shng' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'shng' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'shng' ), 'shng', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
