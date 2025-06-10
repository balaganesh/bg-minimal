<?php
/**
 * The template for displaying all single posts.
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
    <?php bg_minimal_breadcrumbs(); ?>
    
    <div class="content-layout">
        <main class="main-content">

            <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="post-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-meta">
                            Posted on <?php echo get_the_date(); ?> by <?php the_author(); ?>
                        </div>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <footer class="post-footer">
                        <?php
                        // Get the real like count from the database. Default to 0 if it doesn't exist.
                        $like_count = get_post_meta(get_the_ID(), '_bg_like_count', true);
                        $like_count = ($like_count) ? $like_count : '0';
                        ?>
                        <!-- Add data-post-id and print the real count -->
                        <div class="like-button" data-post-id="<?php echo get_the_ID(); ?>">
                            👍 Like <span class="like-count"><?php echo esc_html($like_count); ?></span>
                        </div>
                    </footer>
                </article>

                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; ?>

        </main>

        <?php get_template_part('template-parts/sidebar'); ?>
        
    </div><!-- .content-layout -->

</div><!-- .container -->

<?php wp_footer(); ?>
</body>
</html>