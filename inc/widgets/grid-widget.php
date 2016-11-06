<?php

add_action('widgets_init', array('SHNG_Grid_Widget', 'register'));

class SHNG_Grid_Widget extends SHNG_Posts_Widget {

    public static function register(){
        register_widget('SHNG_Grid_Widget');
    }

    function __construct() {
        $widget_ops  = array('classname' => 'shng-grid-widget index-gallery posts-box', 'description' =>'首页网格挂件');
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('shng-grid-widget', '神农谷-首页网格挂件', $widget_ops, $control_ops);
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

                echo '<div class="grid-content grid-content">';
                echo '<ul class="shng-grid grid-list  role="grid">';

                while ($posts->have_posts()){
                    $posts->the_post();
                    $post_title = esc_attr(get_the_title());
                    $post_url = get_permalink();
                    $post_id = get_the_id();
                    $post_img = get_post_img($post_id,$width="228",$height="168",$size='gallery');
                    ?>

                    <li class="grid-item">
                    <a href="<?php echo $post_url; ?>" class="grid-link">
                    <p class="grid-title">
                        <?php echo $post_title; ?>
                    </p>
                    <img src="<?php echo $post_img; ?>" width="228" height="168" />
                    </a>
                    </li>
                    
                <?php }
                echo '</ul>';
                echo '<div class="clear"></div>';
                echo '</div>';

                } 
                wp_reset_postdata();

            echo  htmlspecialchars_decode(esc_html($after_widget));
        }


    protected function get_default() {
        return array(
            'title'          => '最新动态',
            'en_title'       => '',
            'more'           => '',
            'posts_per_page' => 30,
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
