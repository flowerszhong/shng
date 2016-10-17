<?php

add_action('widgets_init', array('GXQ_Slide_Widget', 'register'));

class GXQ_Slide_Widget extends GXQ_Posts_Widget {

    public static function register(){
        register_widget('GXQ_Slide_Widget');
    }

    function __construct() {
        $widget_ops  = array('classname' => 'gxq-slide-widget posts-box', 'description' =>'幻灯片轮播挂件，占一行的三分之一，左、中、右位置可选');
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('gxq-slide-widget', '高新区-幻灯片挂件', $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        $instance = wp_parse_args((array) $instance, $this->get_default());

        extract($args);
        extract($instance);

        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        $before_widget = '<div class="widget posts-box gxq-slide-widget border '. $position .'">';

        echo htmlspecialchars_decode(esc_html($before_widget));
        if (!empty($title))
            echo  htmlspecialchars_decode(esc_html($before_title . $title . $after_title));

        $query = $this->get_query($instance);
        $posts = new WP_Query($query);

        if ($posts->have_posts()){ 

            echo '<div class="gxq-slides" role="slides">';

            while ($posts->have_posts()){
                $posts->the_post();
                $post_title = esc_attr(get_the_title());
                $post_url = get_permalink();
                ?>
                <div class="slide-item">
                <a href="<?php echo $post_url; ?>" class="slide-link">
                <?php 
                    echo '<img src="'.get_post_img( '', 340, 270 ).'" alt="'. $post_title .'" class="slide-img" width="340" height="270" />';
                ?>
                    <em class="slide-bg"></em>
                
                    <span class="slide-title">
                     <?php echo $post_title; ?>
                    </span>
                
                
                </a>

                </div>
                
            <?php }
            echo '</div>';

        

            } 
            wp_reset_postdata();

        echo  htmlspecialchars_decode(esc_html($after_widget));
    }


    protected function get_default() {
        return array(
            'title'          => '',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'category'       => array(),
            'post_tag'       => array(),
            'post_format'    => array(),
            'relation'       => 'OR',
            'in'             => '',
            'position'       => 'col1',
            'show_position'  => true
        );
    }


}

?>
