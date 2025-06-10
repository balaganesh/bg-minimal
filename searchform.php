<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text">Search for:</span>
        <input type="search" id="home-search-field" class="search-field" placeholder="Search blogs instantly..." value="<?php echo get_search_query(); ?>" name="s" />
    </label>
    <input type="submit" class="search-submit" value="Search" />
</form>