<?php
/**
 * The main template file. Used for the "All Blogs" listing.
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
    <?php bg_minimal_breadcrumbs(); // ADDED BREADCRUMBS ?>

    <div class="content-layout">
        <main class="main-content">

            <?php if (have_posts()) : ?>

                <header class="page-header">
                    <h1 class="page-title"><?php echo is_home() ? 'All Blogs' : get_the_archive_title(); ?></h1>
                </header>
                
                <!-- 2. UPDATED BLOG LIST WITH SUMMARY -->
                <ul class="blog-list">
                    <?php while (have_posts()) : the_post(); ?>
                         <li>
                            <h2 class="blog-list-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="post-meta">
                                <span><?php echo get_the_date(); ?></span>
                            </div>
                            <div class="post-summary">
                                <?php the_excerpt(); ?>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <?php the_posts_pagination(); ?>

            <?php else : ?>
                <p>No posts found.</p>
            <?php endif; ?>

        </main>
        
        <?php get_template_part('template-parts/sidebar'); // ADDED SIDEBAR ?>

    </div><!-- .content-layout -->

</div><!-- .container -->

<?php wp_footer(); ?>
</body>
</html>