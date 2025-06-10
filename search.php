<?php
/**
 * The template for displaying search results pages.
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

    <main class="main-content">

        <header class="page-header">
            <h1 class="page-title">
                <?php printf(esc_html__('Search Results for: %s', 'bg-minimal'), '<span>' . get_search_query() . '</span>'); ?>
            </h1>
        </header>

        <?php if (have_posts()) : ?>
             <ul class="blog-list">
                <?php while (have_posts()) : the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                        <div class="entry-meta">
                            <?php echo get_the_date(); ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
            <?php get_search_form(); ?>
        <?php endif; ?>

    </main>

</div><!-- .container -->

<?php wp_footer(); ?>
</body>
</html>