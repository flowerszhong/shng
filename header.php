<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package shng
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header id="masthead" class="site-header" role="banner">
		<div class="container clear">

			<?php 
			if(get_theme_mod( 'shng_logo',true)){ ?>
			<div class="site-branding">
				<img id="site-logo" src="<?php echo get_theme_mod('shng_logo',true); ?>" />
			</div>
				

			<?php }else{ ?>
			<div class="site-branding">
				<?php
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif; ?>
			</div><!-- .site-branding -->


			<?php }


			 ?>
			

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'shng' ); ?></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
			</nav><!-- #site-navigation -->
			<div class="clear"></div>
		</div>

	</header><!-- #masthead -->


	<div class="site-banner" id="banner">
		<?php 

		if(is_page()){
			echo get_the_post_thumbnail();
		}

		if(is_category()){
			$category = get_the_category();
			$banner_url = $category[0]->category_description;
			$is_img = @getimagesize($banner_url);
			if($is_img){
				echo "<img src='$banner_url' />";
			}
		}


		if(is_singular('post')){
			$categories = get_the_category();

			$banner_url = "";
			foreach ($categories as $cat) {
				$description = $cat->category_description;
				if(@getimagesize($description)){
					$banner_url = $description;
					break;
				}
			}

			if(!empty($banner_url)){
				echo "<img src='$banner_url' />";
			}

		}

		 ?>
	</div>

	<div id="content" class="site-content">

	<?php if(!(is_home() or is_front_page())){ ?>

	<div class="breadcrumbs container">
		<?php echo custom_breadcrumbs(); ?>
	</div>
	<?php } ?>
