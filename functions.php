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
		'before_title'  => '<h2 class="widget-title"><span class="widget-title-box"></span>',
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



// Breadcrumbs
function custom_breadcrumbs($before='当前位置：',$separator=' &raquo; ',$home_title='首页') {
    // Settings
    $breadcrums_id      = 'bread-crumbs';
    $breadcrums_class   = 'breadcrumbs';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;

   
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<div id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
         if($before){
            echo $before;
        }
           
        // Home page
        echo '<span><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></span>';
        echo $separator;
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<span>' . post_type_archive_title($prefix, false) . '</span>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<span><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></span>';
                echo  $separator;
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<span>' . $custom_tax_name . '</span>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
            $category = null;
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<span><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></span>';
                echo  $separator;
                
            }else{
                $category = get_the_category();
            }

              
            // Get post category info
            // $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<span class="item-cat">'.$parents.'</span>';
                    $cat_display .= '<span class="separator"> ' . $separator . ' </span>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<span>' . get_the_title() . '</span>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<span class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></span>';
                echo '<span class="separator"> ' . $separator . ' </span>';
                echo '<span class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></span>';
              
            } else {
                  
                echo '<span>' . get_the_title() . '</span>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<span>' . single_cat_title('', false) . '</span>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<span><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></span>';
                    $parents .= '<span> ' . $separator . ' </span>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<span title="' . get_the_title() . '"> ' . get_the_title() . '</span>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<span class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</span>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<span>' . $get_term_name . '</span>';
           
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<span>' . 'Author: ' . $userdata->display_name . '</span>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<span>'.__('Page') . ' ' . get_query_var('paged') . '</span>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<span>Search results for: ' . get_search_query() . '<span>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<span>' . 'Error 404' . '</span>';
        }
       
        echo '</div>';
           
    }
       
}


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
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/widgets/abstract-widget.php';
require get_template_directory() . '/inc/widgets/carousel-widget.php';
require get_template_directory() . '/inc/widgets/slide-widget.php';
require get_template_directory() . '/inc/widgets/list-widget.php';
require get_template_directory() . '/inc/widgets/media-widget.php';
require get_template_directory() . '/inc/widgets/grid-widget.php';


/**
 * Load Jetpack compatibility file.
 */
// require get_template_directory() . '/inc/jetpack.php';
