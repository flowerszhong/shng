<?php

add_action('widgets_init', array('SHNG_List_Widget', 'register'));

class SHNG_List_Widget extends SHNG_Posts_Widget {

    public static function register(){
        register_widget('SHNG_List_Widget');
    }

    function __construct() {
        $widget_ops  = array('classname' => 'shng-list-widget posts-box', 'description' =>'边栏-文章列表挂件');
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('shng-list-widget', '神农谷-边栏-文章列表挂件', $widget_ops, $control_ops);
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

            echo '<ul class="shng-post-list post-list  role="list">';

            while ($posts->have_posts()){
                $posts->the_post();
                $post_title = esc_attr(get_the_title());
                $post_title = mb_substr($post_title, 0,12,'UTF-8');


                $post_url = get_permalink();

                $m = get_the_time('m');
                $d = get_the_time('d');
                ?>
                <li class="list-item">
                <a href="<?php echo $post_url; ?>" class="list-link">
                <span class="post-date"">
                    <b><?php echo $m .  "/" ; ?></b> <?php echo $d; ?>
                </span>
                <?php echo $post_title; ?>
                </a>
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
