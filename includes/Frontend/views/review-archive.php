<?php 
/**
 * Book Review
 * This page is for shortcode 
 * rendering review list
 */
defined( 'ABSPATH' ) || exit;

$review_args = [
    'post_type'      => 'review',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'ASC',
    
];

$rev_posts = new WP_Query($review_args);

if ($rev_posts->have_posts()) {
    echo '<div class="container mt-3">';
    echo '<div class="row" id="reviews-container">';
    while ($rev_posts->have_posts()) {
        $rev_posts->the_post();
        echo '<div class="col-lg-4 col-sm-6 col-xs-12">';
        wbr_output_review_card(get_the_ID());
        echo '</div>';
    }
    wp_reset_postdata();
    echo '</div>';
    echo '<div class="load-more-rev-container"><button id="load-more-reviews">Load More Reviews</button></div>';
    echo '</div>';
} else {
    esc_html_e('No review found.', 'wpr');
}