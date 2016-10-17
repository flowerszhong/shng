<?php

add_action('widgets_init', array('GXQ_Category_Widget', 'register'));

class GXQ_Category_Widget extends WP_Widget {

    public static function register(){
        register_widget('GXQ_Category_Widget');
    }

    function __construct($arg1='gxq-category-widget',$arg2='高新区-分类栏目挂件') {
        $widget_ops  = array('classname' => 'gxq-category-widget', 'description' =>'文章归档栏目挂件，可显示一个栏目，占一行1/3，左、中、右位置可选');
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct($arg1, $arg2, $widget_ops, $control_ops);
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['tab1_title']     = strip_tags($new_instance['tab1_title']);
        $instance['tab1_category']  = isset($new_instance['tab1_category']) ? $new_instance['tab1_category'] : '0';
        $instance['posts_per_page'] = (int) strip_tags($new_instance['posts_per_page']);

        $instance['orderby']  = isset($new_instance['orderby']) && in_array($new_instance['orderby'], array('date', 'popular', 'comment_count', 'rand')) ? $new_instance['orderby'] : 'date';
        $instance['position'] = isset($new_instance['position']) && in_array($new_instance['position'], array('col1','col2','col3')) ? $new_instance['position'] : 'col1';

        return $instance;
    }

    public function form($instance) {
        $instance = wp_parse_args((array) $instance, $this->get_default());       
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('tab1_title')); ?>">自定义栏目标题</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('tab1_title')); ?>" name="<?php echo esc_attr($this->get_field_name('tab1_title')); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['tab1_title'])); ?>" />
        </p>  

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('tab1_category')); ?>">选择分类</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('tab1_category')); ?>" name="<?php echo esc_attr($this->get_field_name('tab1_category')); ?>">
                <option value="">-- All --</option>
                <?php
                $terms = get_terms('category');
                if ($terms) {
                    foreach ($terms as $term) {
                        ?>
                        <option value="<?php echo esc_attr($term->term_id); ?>" <?php selected( $instance['tab1_category'], $term->term_id ); ?>  ><?php echo esc_attr($term->name); ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </p>
       
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('posts_per_page')); ?>">显示文章数量</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('posts_per_page')); ?>" name="<?php echo esc_attr($this->get_field_name('posts_per_page')); ?>" type="text" value="<?php echo esc_attr((int) $instance['posts_per_page']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('orderby')); ?>">排序方式</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('orderby')); ?>" name="<?php echo esc_attr($this->get_field_name('orderby')); ?>">                
                <?php
                $orderbys = array(
                    'date'          => '最新文章',                    
                    'comment_count' => '最多评论',
                    'rand'          => '随机',
                );
                foreach ($orderbys as $value => $title) {
                    ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($instance['orderby'], $value); ?>><?php echo esc_attr($title); ?></option>
                    <?php
                }
                ?>
            </select>
        </p>


        <p>
            <label for="<?php echo esc_attr($this->get_field_id('position')); ?>">方位</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('position')); ?>" name="<?php echo esc_attr($this->get_field_name('position')); ?>">                
                <?php
                $positions = array(
                    'col1' => '左',                    
                    'col2' => '中',
                    'col3' => '右'
                );
                foreach ($positions as $value => $title) {
                    ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($instance['position'], $value); ?>><?php echo esc_attr($title); ?></option>
                    <?php
                }
                ?>
            </select>
        </p>

        <?php
    }


    public function widget($args, $instance) {
        $instance = wp_parse_args((array) $instance, $this->get_default());

        extract($args);
        extract($instance);

        $tab1_title = apply_filters('widget_title', empty($instance['tab1_title']) ? '' : $instance['tab1_title'], $instance, $this->id_base);

        $before_widget = '<div class="posts-box gxq-category-widget '. $position . '">';
        echo htmlspecialchars_decode(esc_html($before_widget));
        if (!empty($tab1_title) && !empty($tab1_category)){

            $before_title = '<div class="box-header">';
            $after_title = '</div>';

            $tab1_link = get_category_link( $tab1_category );

            $tab1 = '<span class="box-title">'.$tab1_title.'</span>';
            $more = '<a href="'. $tab1_link .'" target="_blank" class="more">更多>> </a>';
            echo  htmlspecialchars_decode(esc_html($before_title . $tab1 . $more . $after_title));
        }else{
            echo '<div class="box-header"><span class="box-title">未设置标题或分类</span><a href="" target="_blank" class="more">更多&gt;&gt; </a></div>';
        }

        echo '<div class="box-content">';
        $this->tab_list($instance,$tab1_category,1);
        echo "</div>";
       
        
        $after_widget ="</div>";
        echo htmlspecialchars_decode(esc_html($after_widget));
    }

    public function tab_list($instance,$tab_category,$index){
        $query = $this->get_query($instance,$tab_category);
        $posts = new WP_Query($query);
        if ($posts->have_posts()):
            echo '<ul class="list tab-'.$index.'">';
            while ($posts->have_posts()) {
                $posts->the_post();
                $post_title = esc_attr(get_the_title());
                $post_title_show = wp_trim_words( $post_title, $num_words = 13, $more = '...' );
                $post_url = get_permalink();
                ?>
                <li>
                <a href="<?php echo $post_url; ?>" target="_blank" title="<?php echo $post_title; ?>"><?php echo $post_title_show; ?></a>
                <span class="date"><?php the_time('Y-m-d'); ?></span>
                </li>
            <?php }
            echo "</ul>";
            wp_reset_postdata();
        endif;

    }

    public function get_query($instance, $tab_category) {
        $args = array(
            'post_type'           => array('post'),
            'posts_per_page'      => (int) $instance['posts_per_page'],
            'post_status'         => array('publish'),
            'ignore_sticky_posts' => true
        );

        if (!empty($tab_category)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => array($tab_category)
            );
        }


        if (isset($instance['orderby'])) {
            switch ($instance['orderby']) {
                case 'comment_count':
                    $args['orderby'] = 'comment_count';
                    break;
                case 'rand':
                    $args['orderby'] = 'rand';
                    break;
                default:
                    $args['orderby'] = 'date';
                    break;
            }
        } else {
            $args['orderby'] = 'date';
        }

        return $args;
    }

    protected function get_default() {
        return array(
            'tab1_title'     => '',
            'tab1_category'  => '',
            'posts_per_page' => 6,
            'position'       => 'col1',
            'orderby'        => 'date'
        );
    }

}
