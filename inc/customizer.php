<?php


add_action( 'customize_register', 'shng_customize_logo' );
function shng_customize_logo( $wp_customize ) {
    // Add setting for logo uploader
    $wp_customize->add_setting( 'shng_logo',array(
    	'default'=> get_template_directory_uri(). '/assets/images/logo.png'
    	)); 

    // Add control for logo uploader (actual uploader)
    $wp_customize->add_control( 
    	new WP_Customize_Image_Control( $wp_customize, 'shng_logo', array(
		        'label'    => __( '上传logo', 'shng' ),
		        //section with title
		        'section'  => 'title_tagline',
		        'settings' => 'shng_logo',
		    ) )
    	);
}

function twentyfifteen_customize_register( $wp_customize ) {
	// $color_scheme = twentyfifteen_get_color_scheme();

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->remove_section('colors'); // works
	$wp_customize->remove_section('static_front_page'); // ok


	$wp_customize->add_section('footer_info' , array(
		'title' => '底部配置',
		'priority' => 113,
	));

   $wp_customize->add_setting('wechat_image',array(
        'default'=> get_template_directory_uri() . '/assets/images/wechat.jpg',
    ));


    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'wechat_image',
           array(
               'label'      => '网站（微信）二维码',
               'section'    => 'footer_info',
               'settings'   => 'wechat_image',
           )
       )
   );

	$footer_settings = array(
		'copyright'=>array(
			'label'=>'版权声明',
			'default'=>'Copyright © 2010 - 2016 http://shennongu.com All Rights Reserved. 神农谷 版权所有',
			'type'=>'textarea',
			),
		'address'=>array(
			'label'=>'地址',
			'default'=>'中国湖南省株洲市炎陵县神农谷风景区',
			'type'=>'text',
			),
		'postcode'=>array(
			'label'=>'邮编',
			'default'=>'520000',
			'type'=>'text',
			),
		'office'=>array(
			'label'=>'电话',
			'default'=>'xxx-xxxxxxx',
			'type'=>'text',
			),
		'fax'=>array(
			'label'=>'传真',
			'default'=>'xxx-xxxxxxxx',
			'type'=>'text',
			),
		'email'=>array(
			'label'=>'邮箱',
			'default'=>'test@test.com',
			'type'=>'text',
			),
		'support'=>array(
			'label'=>'技术支持',
			'default'=>'http://quickweb.mzh.ren',
			'type'=>'text',
			),
		'icp'=>array(
			'label'=>'备案号',
			'default'=>'湘ICP备16016951号',
			'type'=>'text',
			),
		'poilcebeian'=>array(
			'label'=>'公安备案号',
			'default'=>'44090402440960',
			'type'=>'text',
			),
	);

	foreach ($footer_settings as $setting => $configs) {
		$wp_customize->add_setting($setting,array(
			'default'=>$configs['default']
			));
		$wp_customize->add_control($setting,array(
			'label'=> $configs['label'],
			'section'=> 'footer_info',
			'setting'=>$setting,
			'type'=>$configs['type']
		));
	}
}


add_action( 'customize_register', 'twentyfifteen_customize_register' );

add_action( 'customize_register', 'shng_index_intro' );

function shng_index_intro($wp_customize)
{
	$wp_customize->add_section( 'intro', array(
	    'title'          => __('首页介绍','shng'),
	    'priority'       => 28,
	) );


	$wp_customize->add_setting('intro_text',array(
		'default'=>'<span class="f24">SHEN NONG GU PARK</span><br>神农谷国家森林公园位于罗霄山脉中段、湘赣边境万阳山北段的西北坡，东面与革命纪念地江西井冈山仅一脊之隔，相距12公里，距离炎陵县城45公里。森林公园位于中亚热带季风湿润气候区，年平均气温14.4℃，1月最低平均气温3.9℃，7月最热月平均气温23.8℃，年降雨量1967.9mm。年平均空气相对湿度86％，区内日照少、气温低、云雾降水多、空气湿度大、风速小、气候垂直变化大、是典型的山地气候特征。',
		));

	$wp_customize->add_control('intro_text',array(
		'label'=> '介绍文字',
		'section'=> 'intro',
		'setting'=>'intro_text',
		'type'=>'textarea'
	));


	$wp_customize->add_setting('intro_image',array(
		'default'=> get_template_directory_uri() . '/assets/images/intro_image.gif',
	));


	$wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'intro_image',
           array(
               'label'      => '网站说明附图',
               'section'    => 'intro',
               'settings'   => 'intro_image',
           )
       )
   );




}


//记录浏览次数
if(!function_exists('record_visitors')){
    function record_visitors(){
        if (is_singular())
        {
          global $post;
          $post_ID = $post->ID;
          if($post_ID)
          {
              $post_views = (int)get_post_meta($post_ID, 'views', true);
              if(!update_post_meta($post_ID, 'views', ($post_views+1)))
              {
                add_post_meta($post_ID, 'views', 1, true);
              }
          }
        }
    }
}

add_action('wp_head', 'record_visitors');


function post_views($before = '(浏览 ', $after = ' 次)', $echo = 1){
      global $post;
      $post_ID = $post->ID;
      $views = (int)get_post_meta($post_ID, 'views', true);
      if ($echo) echo $before, number_format($views), $after;
      else return $views;
}


add_action( 'customize_register', 'shng_customize_slide' );

function shng_customize_slide($wp_customize) {  

    global $slide_prefix;
    $slide_prefix = 'shng_slide_';
    global $slide_length;
    $slide_length = 5;

    $wp_customize->add_section( 'slides', array(
        'title'          => __('首页幻灯片','shng'),
        'priority'       => 25,
    ) );

    for ($i=1; $i <= $slide_length; $i++) { 
        $setting_name = $slide_prefix . $i;
        $slide_label = '幻灯片 ' . $i;
        $wp_customize->add_setting( $setting_name, array(
            'default'=> '',
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting_name, array(
            'label'   => $slide_label,
            'section' => 'slides',
            'settings'   => $setting_name,
        ) ) );

        $url_setting = $slide_prefix . 'url_' . $i;
        $url_label = '幻灯片链接 ' . $i;


        $wp_customize->add_setting(
            $url_setting,
            array(
                'default' => __('http://','shng'),
            )
        );

        $wp_customize->add_control(
            $url_setting,
            array(
                'label' => $url_label,
                'section' => 'slides',
                'type' => 'text',
            )
        );
    }
}

function render_slider()
{
    
    $slide_dom = '<ul class="slides">';
    for ($i=1; $i <=5 ; $i++) { 
        $slide_prefix = 'shng_slide_';
        $setting_name = $slide_prefix . $i;
        $url_name = $slide_prefix . 'url_' . $i;
        $slide = get_theme_mod( $setting_name );
        $url = get_theme_mod( $url_name );
        if(!empty($slide)){
            $slide_dom .= '<li><a href="' .$url . '"><img src="' . $slide . '"></a></li>';
        }
    
    }
    $slide_dom .= '</ul>';
    echo $slide_dom;
}


function render_slider_controls()
{
    $slide_dom = '<ul>';
    for ($i=1; $i <=5 ; $i++) { 
        $slide_prefix = 'shng_slide_';
        $setting_name = $slide_prefix . $i;
        $slide = get_theme_mod( $setting_name );
        if(!empty($slide)){
            $slide_dom .= '<li></li>';
        }
    
    }
    $slide_dom .= '</ul>';
    echo $slide_dom;
}


add_action( 'customize_register', 'shng_customize_kf' );

function shng_customize_kf($wp_customize) {  

    global $kf_prefix;
    $kf_prefix = 'shng_kf_';
    global $kf_length;
    $kf_length = 3;

    $wp_customize->add_section( 'kf', array(
        'title'          => __('客服','shng'),
        'priority'       => 114,
    ) );

    $wp_customize->add_setting(
        'shng_kf_office',
        array('default'=>__('400-800-100','shng'))
    );

    $wp_customize->add_control(
            'shng_kf_office',
            array(
                'label' => '客服电话',
                'section' => 'kf',
                'type' => 'text',
            )
        );

    for ($i=1; $i <= $kf_length; $i++) { 
        $kf_setting = $kf_prefix . 'qq_' . $i;
        $kf_label = '客服 QQ ' . $i .' (格式：昵称||QQ号)';


        $wp_customize->add_setting(
            $kf_setting,
            array(
                'default' => __('可可||123456','shng'),
            )
        );

        $wp_customize->add_control(
            $kf_setting,
            array(
                'label' => $kf_label,
                'section' => 'kf',
                'type' => 'text',
            )
        );
    }
}

function render_kf_contact()
{   
    $kf_dom = '<ul>';
    for ($i=1; $i <=3 ; $i++) { 
        $kf_prefix = 'shng_kf_qq_';
        $setting_name = $kf_prefix . $i;
        $kf = get_theme_mod( $setting_name );
        if(!empty($kf)){
            $kf_array = explode('||', $kf);
            $kf_dom .= '<li><a href="'. $kf_array[1] . '">'. $kf_array[0].'</a></li>';
        }
    
    }
    $kf_dom .= '</ul>';
    echo $kf_dom;
}




/**
 * Generated by the WordPress Meta Box generator
 * at http://jeremyhixon.com/tool/wordpress-meta-box-generator/
 */

function gxq_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function gxq_add_meta_box() {
	add_meta_box(
		'gxq-gxq',
		'跳转链接',
		'gxq_html',
		'post',
		'normal',
		'default'
	);
	// add_meta_box(
	// 	'gxq-gxq',
	// 	'',
	// 	'gxq_html',
	// 	'golink',
	// 	'normal',
	// 	'default'
	// );
}
add_action( 'add_meta_boxes', 'gxq_add_meta_box' );

function gxq_html( $post) {
	wp_nonce_field( '_gxq_nonce', 'gxq_nonce' ); ?>
	<p>如果设置了跳转链接，并且链接URL合法，页面会去到链接所在的页面，而不会显示编辑器里的正文</p>

	<p>
		<label for="gxq_link">跳转链接地址，如：http://www.qq.com</label><br>
		<input type="text" class='widefat' name="gxq_link" id="gxq_link" value="<?php echo gxq_get_meta( 'gxq_link' ); ?>">
	</p><?php
}

function gxq_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['gxq_nonce'] ) || ! wp_verify_nonce( $_POST['gxq_nonce'], '_gxq_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['gxq_link'] ) )
		update_post_meta( $post_id, 'gxq_link', esc_attr( $_POST['gxq_link'] ) );
}
add_action( 'save_post', 'gxq_save' );



function wp_shng_pagination( $args = array() ) {
    
    $defaults = array(
        'range'           => 5,
        'custom_query'    => FALSE,
        'previous_string' => __( '&lsaquo;', 'text-domain' ),
        'next_string'     => __( '&rsaquo;', 'text-domain' ),
        'before_output'   => '<div class="wp-pagenavi">',
        'after_output'    => '</div>'
    );
    
    $args = wp_parse_args( 
        $args, 
        $defaults
    );
    
    $args['range'] = (int) $args['range'] - 1;
    if ( !$args['custom_query'] )
        $args['custom_query'] = @$GLOBALS['wp_query'];
    $count = (int) $args['custom_query']->max_num_pages;
    $page  = intval( get_query_var( 'paged' ) );
    $ceil  = ceil( $args['range'] / 2 );
    
    if ( $count <= 1 )
        return FALSE;
    
    if ( !$page )
        $page = 1;
    
    if ( $count > $args['range'] ) {
        if ( $page <= $args['range'] ) {
            $min = 1;
            $max = $args['range'] + 1;
        } elseif ( $page >= ($count - $ceil) ) {
            $min = $count - $args['range'];
            $max = $count;
        } elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
            $min = $page - $ceil;
            $max = $page + $ceil;
        }
    } else {
        $min = 1;
        $max = $count;
    }
    
    $echo = '';
    $previous = intval($page) - 1;
    $previous = esc_attr( get_pagenum_link($previous) );
    
    $firstpage = esc_attr( get_pagenum_link(1) );

    if($count && $page){
        $echo .= '<span class="pages">' . $page .'/' . $count .'</span>';
    }

    if ( $firstpage && (1 != $page) ){
        $echo .= '<a href="' . $firstpage . '">' . __( '&laquo;', 'text-domain' ) . '</a>';
    }
    if ( $previous && (1 != $page) ){
        $echo .= '<a href="' . $previous . '" title="' . __( '&laquo;', 'text-domain') . '">' . $args['previous_string'] . '</a>';
    }
    
    if ( !empty($min) && !empty($max) ) {
        for( $i = $min; $i <= $max; $i++ ) {
            if ($page == $i) {
                $echo .= '<span class="current">' . $i . '</span>';
            } else {
                $echo .= sprintf( '<a href="%s">%d</a>', esc_attr( get_pagenum_link($i) ), $i );
            }
        }
    }
    
    $next = intval($page) + 1;
    $next = esc_attr( get_pagenum_link($next) );
    if ($next && ($count != $page) )
        $echo .= '<a href="' . $next . '" title="' . __( '&rsaquo;', 'text-domain') . '">' . $args['next_string'] . '</a>';
    
    $lastpage = esc_attr( get_pagenum_link($count) );
    if ( $lastpage ) {
        $echo .= '<a href="' . $lastpage . '">' . __( '&raquo;', 'text-domain' ) . '</a>';
    }
    if ( isset($echo) )
        echo $args['before_output'] . $echo . $args['after_output'];
}

/*
	Usage: gxq_get_meta( 'gxq_link' )
*/



