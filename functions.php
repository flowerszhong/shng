<?php
/**
 * shng functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package shng
 */

if ( ! function_exists( 'shng_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function shng_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on shng, use a find and replace
	 * to change 'shng' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'shng', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'shng' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'shng_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'shng_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function shng_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'shng_content_width', 640 );
}
add_action( 'after_setup_theme', 'shng_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function shng_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'shng' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'shng' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( '首页挂件区', 'shng' ),
		'id'            => 'home',
		'description'   => esc_html__( 'Add widgets here.', 'shng' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="index-title">',
		'after_title'   => '</div>',
	) );
}
add_action( 'widgets_init', 'shng_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function shng_scripts() {
	wp_enqueue_style( 'shng-style', get_stylesheet_uri() );
	wp_enqueue_style( 'shng-commonstyle', get_template_directory_uri() . '/common.css' );

	wp_enqueue_script( 'shng-jquery', get_template_directory_uri() . '/js/jquery-1.7.2.min.js', array(), '20151215', true );



	if(is_home() or is_front_page()){
		wp_enqueue_script( 'shng-slide', get_template_directory_uri() . '/js/jquery.superslide.2.1.1.js', array('shng-jquery'), '20151215', true );
		wp_enqueue_script( 'shng-index', get_template_directory_uri() . '/js/index.js', array('shng-slide'), '20151215', true );

		wp_enqueue_style( 'shng-indexstyle', get_template_directory_uri() . '/index.css' );

	}

	wp_enqueue_script( 'shng-common', get_template_directory_uri() . '/js/common.js', array('shng-jquery'), '20151215', true );

	wp_enqueue_script( 'shng-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'shng_scripts' );

function get_post_img( $id = null,$width="200",$height="150") {
    if( $id ){
        $post = get_post($id);
        $post_id = $id;
    }else{
        global $post;
        $post_id = $post->ID;
    }

    if(has_post_thumbnail( $post )){
        return get_the_post_thumbnail_url( $post);
    }

    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    if( !empty( $matches[1][0] ) ){
        return $matches[1][0];
    }else{
        $width_height = $width . 'x' . $height;
        return 'http://fpoimg.com/' . $width_height;
    }
}



/**
 * Implement the Custom Header feature.
 */
// require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
// require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
// require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/widgets/abstract-widget.php';
require get_template_directory() . '/inc/widgets/carousel-widget.php';
require get_template_directory() . '/inc/widgets/slide-widget.php';


/**
 * Load Jetpack compatibility file.
 */
// require get_template_directory() . '/inc/jetpack.php';
