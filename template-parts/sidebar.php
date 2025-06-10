<aside class="sidebar-main">
    <div class="widget">
        <?php get_search_form(); ?>
    </div>

    <div class="widget">
        <h3 class="widget-title">Recent Posts</h3>
        <?php
        $recent_posts_args = array(
            'post_type' => 'post',
            'posts_per_page' => 5,
            'post__not_in' => is_single() ? array(get_the_ID()) : array(), // Exclude current post if on a single page
        );
        $recent_posts_query = new WP_Query($recent_posts_args);

        if ($recent_posts_query->have_posts()) : ?>
            <ul class="widget-posts-list">
                <?php while ($recent_posts_query->have_posts()) : $recent_posts_query->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; ?>
            </ul>
            <?php wp_reset_postdata();
        else: ?>
            <p>No recent posts found.</p>
        <?php endif; ?>
    </div>
</aside>