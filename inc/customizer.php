<?php

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


	$wp_customize->add_section('sidebar_config' , array(
		'title' => '边栏配置',
		'priority' => 112,
	));

	$wp_customize->add_setting('show_archive_sidebar',array(
		'default'=>true,
	));

	$wp_customize->add_control('show_archive_sidebar',array(
		'label'=>'显示归档页、分类页侧边栏',
		'section'=>'sidebar_config',
		'setting'=>'show_archive_sidebar',
		'type'=>'checkbox'
	));

	$wp_customize->add_setting('show_single_sidebar',array(
		'default'=>true,
	));

	$wp_customize->add_control('show_single_sidebar',array(
		'label'=>'显示文章页侧边栏',
		'section'=>'sidebar_config',
		'setting'=>'show_single_sidebar',
		'type'=>'checkbox'
	));


	$wp_customize->add_setting('header_logo',array(
		'default'=> get_template_directory_uri() . '/img/logo.png',
	));

	$wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'header_logo',
           array(
               'label'      => '上传网站LOGO',
               'section'    => 'header_image',
               'settings'   => 'header_logo',
           )
       )
   );
}
add_action( 'customize_register', 'twentyfifteen_customize_register' );



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


