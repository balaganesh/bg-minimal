<?php
/**
 * BG Minimal Theme Functions
 * Version: 1.4 - Corrected and Consolidated
 */

// 1. THEME SETUP
// =============================================================================
function bg_minimal_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('excerpt'); 
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'bg-minimal'),
    ));
}
add_action('after_setup_theme', 'bg_minimal_setup');


// 2. ENQUEUE SCRIPTS AND STYLES
// =============================================================================
function bg_minimal_scripts() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;700&display=swap', array(), null);
    wp_enqueue_style('bg-minimal-style', get_stylesheet_uri());
    wp_enqueue_style('bg-minimal-custom-style', get_template_directory_uri() . '/assets/css/main.css', array(), '1.4');
    wp_enqueue_script('bg-minimal-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.4', true);
    
    // Pass data to JavaScript for AJAX functionality
    wp_localize_script('bg-minimal-js', 'bg_ajax_obj', array(
        'ajax_url'   => admin_url('admin-ajax.php'),
        'nonce'      => wp_create_nonce('bg_ajax_nonce'),
        'like_nonce' => wp_create_nonce('bg_like_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'bg_minimal_scripts');


// 3. THEME CUSTOMIZER OPTIONS
// =============================================================================
function bg_minimal_customize_register($wp_customize) {
    // Add a new section for Theme Options
    $wp_customize->add_section('bg_theme_options', array(
        'title'    => __('Theme Options', 'bg-minimal'),
        'priority' => 120,
    ));

    // Add a setting for the 'About Me' page
    $wp_customize->add_setting('about_page_setting', array(
        'default'           => '',
        'sanitize_callback' => 'absint', // Sanitize to ensure it's a page ID (integer)
    ));

    // Add the control (the dropdown list of pages)
    $wp_customize->add_control('about_page_setting', array(
        'label'    => __('Select "About Me" Page', 'bg-minimal'),
        'section'  => 'bg_theme_options',
        'type'     => 'dropdown-pages',
        'description' => __('Select the page to use for the "About Me" summary on the homepage.', 'bg-minimal'),
    ));
}
add_action('customize_register', 'bg_minimal_customize_register');


// 4. AJAX HANDLERS & HELPERS
// =============================================================================

// -- Live Search Handler --
function bg_live_search() {
    check_ajax_referer('bg_ajax_nonce', 'nonce');
    $search_query = new WP_Query(array( 's' => sanitize_text_field($_POST['query']), 'post_type' => 'post', 'posts_per_page' => 10 ));
    $results_html = '';
    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            $results_html .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
    } else { 
        $results_html = '<li>No results found.</li>'; 
    }
    wp_reset_postdata();
    wp_send_json_success($results_html);
}
add_action('wp_ajax_bg_live_search', 'bg_live_search');
add_action('wp_ajax_nopriv_bg_live_search', 'bg_live_search');

// -- Like Button Handler --
function bg_handle_like_button() {
    check_ajax_referer('bg_like_nonce', 'nonce');
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    if ($post_id === 0) { 
        wp_send_json_error('Invalid Post ID.'); 
    }
    $like_count = get_post_meta($post_id, '_bg_like_count', true);
    $new_like_count = ($like_count) ? intval($like_count) + 1 : 1;
    update_post_meta($post_id, '_bg_like_count', $new_like_count);
    wp_send_json_success(array('new_count' => $new_like_count));
}
add_action('wp_ajax_bg_handle_like_button', 'bg_handle_like_button');
add_action('wp_ajax_nopriv_bg_handle_like_button', 'bg_handle_like_button');

// -- Breadcrumbs Function --
function bg_minimal_breadcrumbs() {
    if (is_front_page()) { 
        return; 
    }
    echo '<nav class="breadcrumbs" aria-label="breadcrumb">';
    echo '<a href="' . esc_url(home_url('/')) . '">Home</a>';
    echo '<span class="separator"> / </span>';
    if (is_home()) { 
        echo '<span>' . single_post_title('', false) . '</span>';
    } elseif (is_singular('post')) {
        $posts_page_id = get_option('page_for_posts');
        if ($posts_page_id) { 
            echo '<a href="' . esc_url(get_permalink($posts_page_id)) . '">' . esc_html(get_the_title($posts_page_id)) . '</a>'; 
            echo '<span class="separator"> / </span>'; 
        }
        echo '<span>' . get_the_title() . '</span>';
    } elseif (is_page()) { 
        echo '<span>' . get_the_title() . '</span>';
    } elseif (is_search()) { 
        echo '<span>Search Results for: ' . get_search_query() . '</span>';
    } elseif (is_404()) { 
        echo '<span>Page Not Found</span>';
    } else { 
        echo '<span>' . get_the_archive_title() . '</span>'; 
    }
    echo '</nav>';
}