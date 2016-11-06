<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shng
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('archive-item'); ?>>
	<div class="archive-item-thumb">
	<img src="<?php echo get_post_img(null,220,130); ?>" alt="" width="220" height="130">
	</div><!-- .entry-content -->

	<div class="archive-item-content">
		<div class="archive-item-header">
			<h3>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php the_title(); ?>
			</a>
			</h3>
			<div class="archive-item-meta">
				<i class="iconfont">&#xe600;</i>&nbsp;作者：<?php the_author(); ?> &nbsp;&nbsp;&nbsp;&nbsp;<i class="iconfont">&#xe601;</i>&nbsp;时间：<?php the_time('Y-m-d');?> &nbsp;&nbsp;&nbsp;&nbsp;<i class="iconfont">&#xe602;</i>&nbsp;访问：<?php post_views('','',true); ?>
			</div>
		</div>
		<div class="archive-item-description">
			<?php the_excerpt(); ?>
		</div>
		<div class="clear"></div>
	</div>
</article><!-- #post-## -->
