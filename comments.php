<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form. The form will now appear before the comments.
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php
    // The comment form is now called first.
    comment_form();
    ?>

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ('1' === $comments_number) {
                /* translators: %s: post title */
                printf(_x('One thought on “%s”', 'comments title', 'bg-minimal'), get_the_title());
            } else {
                printf(
                    /* translators: 1: number of comments, 2: post title */
                    _nx(
                        '%1$s thought on “%2$s”',
                        '%1$s thoughts on “%2$s”',
                        $comments_number,
                        'comments title',
                        'bg-minimal'
                    ),
                    number_format_i18n($comments_number),
                    get_the_title()
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
                wp_list_comments(array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 42,
                ));
            ?>
        </ol>

        <?php
        // If comments are closed and there are comments, let's leave a little note.
        if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
        ?>
            <p class="no-comments"><?php _e('Comments are closed.', 'bg-minimal'); ?></p>
        <?php endif; ?>

    <?php endif; // Check for have_comments(). ?>

</div><!-- #comments -->