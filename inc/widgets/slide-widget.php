<?php

add_action('widgets_init', array('SHNG_Slide_Widget', 'register'));

class SHNG_Slide_Widget extends SHNG_Posts_Widget {

    public static function register(){
        register_widget('SHNG_Slide_Widget');
    }

    function __construct() {
        $widget_ops  = array('classname' => 'shng-slide-widget posts-box', 'description' =>'幻灯片轮播挂件');
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('shng-slide-widget', '神农谷-幻灯片挂件', $widget_ops, $control_ops);
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

            $images = "<div class='slide-images'>";

            echo '<div class="shng-slide container" role="slides">';

            echo '<div class="shng-titles" role="slide-control">';

            $count = 0;

            while ($posts->have_posts()){
                $posts->the_post();
                $post_title = esc_attr(get_the_title());
                $post_url = get_permalink();
                $post_img = get_post_img(null,808,560);
                $post_description = trim(get_the_excerpt());
                $y = get_the_time('Y');
                $m = get_the_time('m');
                $d = get_the_time('d');
                $count += 1;

                $slide_item_class = 'slide-item-' . $count;

                $images = $images . '<img src="'.$post_img.'" alt="'. $post_title .'" class="slide-img" width="808" height="560" />';
                ?>
                <div class="slide-item <?php echo $slide_item_class;  ?>">

                <span class="date">
                <?php if($count == 1){ ?>
                    <b class="date-d">
                        <?php echo $d; ?>
                    </b>
                    <b class="date-ym">
                        <?php echo $y .'.'.$m; ?>
                    </b>
                    <?php }else{ ?>
                    <b class="date-m">
                        <?php echo $m .'/'; ?>
                    </b>
                    <b class="date-m-d">
                        <?php echo $d; ?>
                    </b>
                    <?php } ?>
                </span>
                    <a href="<?php echo $post_url; ?>" class="slide-link">
                         <?php echo $post_title; ?>
                    </a>

                    <?php if($count == 1){ ?>
                        <div class="slide-excerpt">
                            <?php echo $post_description; ?>
                        </div>
                    <?php } ?>

                </div>
                
            <?php }
            echo '</div>';

            $images .= '</div>';

            echo $images;
            echo '</div>';

        

            } 
            wp_reset_postdata();

        echo  htmlspecialchars_decode(esc_html($after_widget));
    }


    protected function get_default() {
        return array(
            'title'          => '最新活动',
            'en_title'       => '',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'category'       => array(),
            'post_tag'       => array(),
            'post_format'    => array(),
            'relation'       => 'OR',
            'in'             => '',
            'more'           => 'http://quickweb.mzh.ren'
        );
    }


}

?>
