<?php
/**
 * The template for displaying all pages.
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

    <main class="main-content">

        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="post-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>

        <?php endwhile; ?>

    </main>

</div><!-- .container -->

<?php wp_footer(); ?>
</body>
</html>