<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shng
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
		<i class="iconfont">&#xe600;</i>&nbsp;作者：<?php the_author(); ?>&nbsp;&nbsp;&nbsp;&nbsp;<i class="iconfont">&#xe601;</i>&nbsp;时间：<?php the_time('Y-m-d'); ?>&nbsp;&nbsp;&nbsp;&nbsp;<i class="iconfont">&#xe602;</i>&nbsp;访问：<?php post_views('','次',true); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content();
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
