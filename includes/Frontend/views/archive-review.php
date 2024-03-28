<?php 
get_header();
if ( have_posts() ) {
    echo '<div class="container mt-3">';
    echo '<div class="row" id="reviews-container">';
    while ( have_posts() ) {
        the_post();
        wbr_output_review_card( get_the_ID() );
    }
    echo '</div>';
    the_posts_pagination();
    // echo '<div class="load-more-rev-container"><button id="load-more-reviews">Load More Reviews</button></div>';
    echo '</div>';
}

get_footer();
?>