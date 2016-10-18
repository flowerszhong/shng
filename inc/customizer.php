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

	$footer_settings = array(
		'copyright'=>array(
			'label'=>'版权声明',
			'default'=>'Copyright&copy;2016',
			'type'=>'text',
			),
		'address'=>array(
			'label'=>'地址',
			'default'=>'茂名市高新区',
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
			'default'=>'Hades',
			'type'=>'text',
			),
		'icp'=>array(
			'label'=>'备案号',
			'default'=>'粤ICP备16032304号',
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
            'default'        => '',
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

        $slide_dom .= '<li><a href="' .$url . '"><img src="' . $slide . '"></a></li>';
    
    }
    $slide_dom .= '</ul>';
    echo $slide_dom;
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

/*
	Usage: gxq_get_meta( 'gxq_link' )
*/



