<form role="search" method="get" class="search-form" id="status-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input type="search" class="search-field" placeholder="请输入要搜索的内容" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'twentysixteen' ); ?>" />
    <button type="submit" class="search-submit"><span class="screen-reader-text">搜索</span></button>
</form>