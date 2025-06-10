<?php
/**
 * The template for displaying the custom homepage.
 * Version: 1.5 - With a hard-coded link for 'About Me' for reliability.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="container">

    <?php get_template_part('template-parts/top-bar'); ?>

    <div class="home-layout">
        
        <aside class="about-me-section">
            <h2>About Me</h2>
            <?php
            // The content summary will still be pulled dynamically from the page you selected in the customizer.
            $about_page_id = get_theme_mod('about_page_setting');
            
            if ($about_page_id && ($about_page = get_post($about_page_id))) {
                // Display the first paragraph of the content.
                $content = apply_filters('the_content', $about_page->post_content);
                $first_p_end = strpos($content, '</p>');
                if ($first_p_end !== false) {
                    echo substr($content, 0, $first_p_end + 4); 
                } else {
                    echo wp_trim_words($content, 55, '...'); 
                }
            } else {
                // A helpful message if no page is selected.
                echo '<p>Please go to Appearance > Customize > Theme Options to select your "About Me" page to display a summary here.</p>';
            }
            
            // =================================================================
            // THE DIRECT, HARD-CODED LINK.
            // This now points directly to yourwebsite.com/about-me/
            // =================================================================
            $about_me_url = home_url('/about-me/');
            echo '<p><a href="' . esc_url($about_me_url) . '">Read the full story...</a></p>';
            ?>
        </aside>

        <main class="recent-blogs-section">
            <h2>Recent Blogs</h2>
            
            <?php get_search_form(); ?>
            <div id="search-results-container" style="display:none;"></div>

            <?php
            $recent_posts = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 10,));
            if ($recent_posts->have_posts()) : ?>
                <ul class="blog-list">
                    <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <li>
                            <h3 class="blog-list-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="post-meta">
                                <span><?php echo get_the_date(); ?></span>
                            </div>
                            <div class="post-summary">
                                <?php the_excerpt(); ?>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p>No blog posts found.</p>
            <?php endif; ?>

            <?php
            $blog_page_id = get_option('page_for_posts');
            if ($blog_page_id) {
                echo '<a class="view-all-blogs-link" href="' . esc_url(get_permalink($blog_page_id)) . '">View all blogs →</a>';
            }
            ?>
        </main>

    </div><!-- .home-layout -->

</div><!-- .container -->

<?php wp_footer(); ?>
</body>
</html>