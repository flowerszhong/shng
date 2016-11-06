<?php

add_action('widgets_init', array('SHNG_Media_Widget', 'register'));

class SHNG_Media_Widget extends SHNG_Posts_Widget {

    public static function register(){
        register_widget('SHNG_Media_Widget');
    }

    function __construct() {
        $widget_ops  = array('classname' => 'shng-media-widget posts-box', 'description' =>'文章图片列表挂件');
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('shng-media-widget', '神农谷-文章图片列表挂件', $widget_ops, $control_ops);
    }


    function widget($args, $instance) {
        $instance = wp_parse_args((array) $instance, $this->get_default());

        extract($args);
        extract($instance);

        if(!empty($more)){
            $title = $title .'<a class="more" href="' . $more . '">[查看更多]</a>';
        }


        echo htmlspecialchars_decode(esc_html($before_widget));
        echo  htmlspecialchars_decode(esc_html($before_title . $title  . $after_title));

        $query = $this->get_query($instance);
        $posts = new WP_Query($query);

        if ($posts->have_posts()){ 

            echo '<ul class="shng-media-list media-list  role="list">';

            while ($posts->have_posts()){
                $posts->the_post();
                $post_title = esc_attr(get_the_title());
                $post_title = mb_substr($post_title, 0,8,'UTF-8');

                $excerpt = get_the_excerpt();
                $excerpt = mb_substr($excerpt, 0,12,'UTF-8');


                $post_url = get_permalink();

                $img_url = get_post_img(null,90,60,'media');

                ?>
                <li class="media-item">
                <div class="media-thumbnail">
                    <a href="<?php echo $post_url; ?>" class="list-link">
                        <img src="<?php echo $img_url; ?>" alt="" width="90" height="60">
                    </a>
                </div>
                <div class="media-content">
                    <h3>
                        <a href="<?php echo $post_url; ?>" class="list-link">
                            <?php echo $post_title; ?>
                        </a>
                    </h3>
                    <p>
                        <?php echo $excerpt; ?>
                    </p>

                </div>
               
                </li>
                
            <?php }
            echo '</ul>';

            } 
            wp_reset_postdata();

        echo  htmlspecialchars_decode(esc_html($after_widget));
    }


    protected function get_default() {
        return array(
            'title'          => '最新动态',
            'en_title'       => '',
            'more'           => '',
            'posts_per_page' => 5,
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
