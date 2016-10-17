<?php

class SHNG_Posts_Widget extends WP_Widget {

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title']          = strip_tags($new_instance['title']);
        $instance['en_title']       = strip_tags($new_instance['en_title']);
        $instance['more']           = strip_tags($new_instance['more']);
        $instance['posts_per_page'] = (int) strip_tags($new_instance['posts_per_page']);
        $instance['orderby']        = isset($new_instance['orderby']) && in_array($new_instance['orderby'], array('date', 'popular', 'comment_count', 'rand')) ? $new_instance['orderby'] : 'date';
        $instance['category']       = (isset($new_instance['category']) && is_array($new_instance['category'])) ? array_filter($new_instance['category']) : array();
        $instance['post_tag']       = (isset($new_instance['post_tag']) && is_array($new_instance['post_tag'])) ? array_filter($new_instance['post_tag']) : array();
        $instance['post_format']    = (isset($new_instance['post_format']) && is_array($new_instance['post_format'])) ? array_filter($new_instance['post_format']) : array();
        $instance['relation']       = isset($new_instance['relation']) && in_array($new_instance['relation'], array('AND', 'OR')) ? $new_instance['relation'] : 'OR';
        $instance['in']             = strip_tags($new_instance['in']);


        return $instance;
    }

    public function form($instance) {
        $instance = wp_parse_args((array) $instance, $this->get_default());       
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">标题</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['title'])); ?>" />
        </p>  

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('en_title')); ?>">英文标题</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('en_title')); ?>" name="<?php echo esc_attr($this->get_field_name('en_title')); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['en_title'])); ?>" />
        </p>  

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('more')); ?>">查看更多</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('more')); ?>" name="<?php echo esc_attr($this->get_field_name('more')); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['more'])); ?>" />
        </p>  

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('posts_per_page')); ?>">显示文章数量</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('posts_per_page')); ?>" name="<?php echo esc_attr($this->get_field_name('posts_per_page')); ?>" type="text" value="<?php echo esc_attr((int) $instance['posts_per_page']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('orderby')); ?>">文章排序方式</label>
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
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>">选择分类</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>[]" multiple="multiple" size="5">
                <option value="">-- All --</option>
                <?php
                $terms = get_terms('category');
                if ($terms) {
                    foreach ($terms as $term) {
                        $selected = in_array($term->term_id, $instance['category']) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?php echo esc_attr($term->term_id); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_attr($term->name); ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('post_tag')); ?>">选择标签</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('post_tag')); ?>" name="<?php echo esc_attr($this->get_field_name('post_tag')); ?>[]" multiple="multiple" size="5">
                <option value="">-- All --</option>
                <?php
                $terms = get_terms('post_tag');
                if ($terms) {
                    foreach ($terms as $term) {
                        $selected = in_array($term->term_id, $instance['post_tag']) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?php echo esc_attr($term->term_id); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_attr($term->name); ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('relation')); ?>">分类及标签组合形式</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('relation')); ?>" name="<?php echo esc_attr($this->get_field_name('relation')); ?>">                
                <?php
                $relations = array(
                    'AND' => __('And', 'origamiez'),
                    'OR'  => __('Or', 'origamiez'),
                );
                foreach ($relations as $value => $title) {
                    ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($instance['relation'], $value); ?>><?php echo esc_attr($title); ?></option>
                    <?php
                }
                ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('in')); ?>"><?php printf('%s <i>%s</i>', __('In:', 'origamiez'), __('(require Wordpress 3.7+)', 'origamiez')); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('in')); ?>" name="<?php echo esc_attr($this->get_field_name('in')); ?>">                
                <?php
                $times = array(
                    ''          => __('-- All --', 'origamiez'),
                    '-1 week'   => __('1 week', 'origamiez'),
                    '-2 week'   => __('2 weeks', 'origamiez'),
                    '-3 week'   => __('3 weeks', 'origamiez'),
                    '-1 month'  => __('1 months', 'origamiez'),
                    '-2 month'  => __('2 months', 'origamiez'),
                    '-3 month'  => __('3 months', 'origamiez'),
                    '-4 month'  => __('4 months', 'origamiez'),
                    '-5 month'  => __('5 months', 'origamiez'),
                    '-6 month'  => __('6 months', 'origamiez'),
                    '-7 month'  => __('7 months', 'origamiez'),
                    '-8 month'  => __('8 months', 'origamiez'),
                    '-9 month'  => __('9 months', 'origamiez'),
                    '-10 month' => __('10 months', 'origamiez'),
                    '-11 month' => __('11 months', 'origamiez'),
                    '-1 year'   => __('1 year', 'origamiez'),
                    '-2 year'   => __('2 years', 'origamiez'),
                    '-3 year'   => __('3 years', 'origamiez'),
                    '-4 year'   => __('4 years', 'origamiez'),
                    '-5 year'   => __('5 years', 'origamiez')
                );
                foreach ($times as $value => $title) {
                    ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($instance['in'], $value); ?>><?php echo esc_attr($title); ?></option>
                    <?php
                }
                ?>
            </select>
        </p>

        <?php
    }

    public function get_query($instance, $args_extra = array()) {
        global $wp_version;

        $args = array(
            'post_type'           => array('post'),
            'posts_per_page'      => (int) $instance['posts_per_page'],
            'post_status'         => array('publish'),
            'ignore_sticky_posts' => true
        );

        if (!empty($instance['category'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => $instance['category']
            );
        }

        if (!empty($instance['post_tag'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'post_tag',
                'field'    => 'id',
                'terms'    => $instance['post_tag']
            );
        }

        if (!empty($instance['post_format'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'post_format',
                'field'    => 'id',
                'terms'    => $instance['post_format']
            );
        }

        if (isset($args['tax_query']) && (count($args['tax_query']) >= 2)) {
            $args['tax_query']['relation'] = ('true' == $instance['relation']) ? 'AND' : 'OR';
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

        if (version_compare($wp_version, '3.7', '>=')) {
            if (isset($instance['in']) && !empty($instance['in'])) {
                $in = $instance['in'];
                $y = date('Y', strtotime($in));
                $m = date('m', strtotime($in));
                $d = date('d', strtotime($in));

                $args['date_query'] = array(
                    array(
                        'after' => array(
                            'year'  => (int) $y,
                            'month' => (int) $m,
                            'day'   => (int) $d
                        )
                    )
                );
            }
        }

        if (!empty($args_extra)) {
            return array_merge($args, $args_extra);
        } else {
            return $args;
        }
    }

    protected function get_default() {
        return array(
            'title'          => '',
            'en_title'       => '',
            'more'           => 'http://quickweb.mzh.ren',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'category'       => array(),
            'post_tag'       => array(),
            'post_format'    => array(),
            'relation'       => 'OR',
            'in'             => '',
        );
    }

}
