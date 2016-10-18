<?php

add_action('widgets_init', array('SHNG_Carousel_Widget', 'register'));

class SHNG_Carousel_Widget extends SHNG_Posts_Widget {

    public static function register(){
        register_widget('SHNG_Carousel_Widget');
    }

    function __construct() {
        $widget_ops  = array('classname' => 'shng-carousel-widget posts-box', 'description' =>'图片轮播效果组件');
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('shng-carousel-widget', '神农谷-图片轮播效果挂件', $widget_ops, $control_ops);
    }


    function widget($args, $instance) {
        $instance = wp_parse_args((array) $instance, $this->get_default());

        extract($args);
        extract($instance);

        $title = "<h2><a href=$more>$title</a></h2>";
        $en_title = "<h3>$en_title</h3>";

        echo htmlspecialchars_decode(esc_html($before_widget));
        echo  htmlspecialchars_decode(esc_html($before_title . $title . $en_title . $after_title));

        $query = $this->get_query($instance);
        $posts = new WP_Query($query);

        if ($posts->have_posts()){ 

            echo '<div class="carousel-content box-content container">';
            echo  '<div class="hd">
                    <a class="next"></a>
                    <a class="prev"></a>
                  </div>';
            echo '<ul class="shng-carousels carousel-list  role="carousel">';

            while ($posts->have_posts()){
                $posts->the_post();
                $post_title = esc_attr(get_the_title());
                $post_url = get_permalink();
                $post_id = get_the_id();
                $post_img = get_post_img($post_id,$width="386",$height="330");
                ?>
                <li class="carousel-item">
                <a href="<?php echo $post_url; ?>" class="carousel-link">
                <span class="carousel-title"">
                    <?php echo $post_title; ?>
                </span>
                <img src="<?php echo $post_img; ?>" width="386" height="330" />
                </a>
                </li>
                
            <?php }
            echo '</ul>';
            echo '</div>';

            } 
            wp_reset_postdata();

        echo  htmlspecialchars_decode(esc_html($after_widget));
    }


    protected function get_default() {
        return array(
            'title'          => '神农谷周边',
            'en_title'       => 'Shen Nong Valley & Travel Around',
            'more'           => 'http://quickweb.mzh.ren',
            'posts_per_page' => 12,
            'orderby'        => 'date',
            'category'       => array(),
            'post_tag'       => array(),
            'post_format'    => array(),
            'relation'       => 'OR',
            'in'             => ''
        );
    }


}

?>
