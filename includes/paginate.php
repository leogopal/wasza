<?php 

function nmpza_pagination() {
    
    if (is_singular()) {
        return;
    }

    global $wp_query;
    /** Stop execution if there's only 1 page */
    if ($wp_query->max_num_pages <= 1) {
        return;
    }
    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);
    /** Add current page to the array */
    if ($paged >= 1) {
        $links[] = $paged;
    }
    /** Add the pages around the current page to the array */
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
    echo '<div class="pagination_wrapper"><ul class="pagination">' . "\n";
    /** Previous Post Link */
    if (get_previous_posts_link()) {
        printf('<li>%s</li>' . "\n", get_previous_posts_link("&#8592;"));
    }
    /** Link to first page, plus ellipses if necessary */
    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' class="first active"' : ' class="first"';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');
        if (!in_array(2, $links)) {
            echo '<li>…</li>';
        }
    }
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort($links);
    foreach ((array)$links as $link) {
        $class = $paged == $link ? ' class="last active"' : ' class="last"';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
    }
    /** Link to last page, plus ellipses if necessary */
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links)) {
            echo '<li><span class="btn disabled">…</span></li>' . "\n";
        }
        $class = $paged == $max ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    }
    /** Next Post Link */
    if (get_next_posts_link()) {
        printf('<li>%s</li>' . "\n", get_next_posts_link("&#8594;"));
    }
    echo '</ul></div>' . "\n";
}
function nmpza_product_pagination() {
    global $post;
    if ( is_singular() ) {
        
        $category = get_the_category($post->ID);
        $category_array = array_shift($category);
                                
        // Fetch all posts in the current post's (main) category
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'cat' => $category_array,
        );
        $query = new WP_Query($args);

        // The index of the current post in its (main) category
        $X = 1;
        $id = $post->ID;
        foreach ($query->posts as $cat_post)
            if ($id != $cat_post->ID) 
                $X++;
            else
                break;

        // The number of posts in the current post's (main) category
        $Y = $query->found_posts;

        $prevPost = get_previous_post();
        $nextPost = get_next_post();

        if ($prevPost || $nextPost) {
            
            if ($prevPost) {
                $prevURL = get_permalink($prevPost->ID); ?>
                <a href="<?php echo $prevURL; ?>" class="paginate-right">
                <img src="<?php echo bloginfo('template_directory'); ?>/images/paginationarrow.png" /></a>
            <?php } ?>

            <span><?php echo $X.'/'.$Y; ?></span> 

            <?php
            if ($nextPost) {
                $nextURL = get_permalink($nextPost->ID); ?>
                <a href="<?php echo $nextURL; ?>" class="paginate-left">
                <img src="<?php echo bloginfo('template_directory'); ?>/images/paginationarrow.png" /></a>
            <?php }

        }
    }
}
?>