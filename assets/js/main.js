jQuery(document).ready(function ($) {

    // --- Live Search ---
    let searchTimer;
    const searchInput = $('#home-search-field');
    const resultsContainer = $('#search-results-container');
    const minChars = 2;

    searchInput.on('keyup', function () {
        const query = $(this).val();
        clearTimeout(searchTimer);
        if (query.length >= minChars) {
            resultsContainer.show().html('<ul><li>Searching...</li></ul>');
            searchTimer = setTimeout(function () {
                $.ajax({
                    url: bg_ajax_obj.ajax_url, type: 'POST', data: { action: 'bg_live_search', query: query, nonce: bg_ajax_obj.nonce },
                    success: function (response) {
                        if (response.success) { resultsContainer.html('<ul>' + response.data + '</ul>');
                        } else { resultsContainer.html('<ul><li>Error fetching results.</li></ul>'); }
                    }
                });
            }, 500);
        } else {
            resultsContainer.hide().empty();
        }
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.search-form').length) {
            resultsContainer.hide().empty();
        }
    });


    // --- Persistent Like Button ---

    // 1. On page load, check which posts have been liked and update their state.
    const likedPosts = JSON.parse(localStorage.getItem('bg_liked_posts')) || [];
    $('.like-button').each(function() {
        const postId = $(this).data('post-id');
        if (likedPosts.includes(postId)) {
            $(this).addClass('liked').attr('title', 'You have already liked this');
        }
    });

    // 2. Handle the click event.
    $('.like-button').on('click', function() {
        const $this = $(this);
        const postId = $this.data('post-id');

        // If it's already liked, do nothing.
        if ($this.hasClass('liked')) {
            return;
        }

        // Send the AJAX request to the server.
        $.ajax({
            url: bg_ajax_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'bg_handle_like_button',
                post_id: postId,
                nonce: bg_ajax_obj.like_nonce // Use the specific nonce for security
            },
            success: function(response) {
                if (response.success) {
                    // Update the count on the page
                    $this.find('.like-count').text(response.data.new_count);
                    
                    // Mark as liked
                    $this.addClass('liked').attr('title', 'You have already liked this');
                    
                    // Store this post ID in the user's browser localStorage
                    const likedPosts = JSON.parse(localStorage.getItem('bg_liked_posts')) || [];
                    if (!likedPosts.includes(postId)) {
                        likedPosts.push(postId);
                        localStorage.setItem('bg_liked_posts', JSON.stringify(likedPosts));
                    }
                } else {
                    // Optional: handle error
                    console.error(response.data);
                }
            },
            error: function() {
                console.error("An error occurred with the like request.");
            }
        });
    });
});