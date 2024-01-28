<?php 
defined( 'ABSPATH' ) || exit;

$review_args = [
    'post_type'      => 'review',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'ASC',
    
];

$rev_posts = new WP_Query($review_args);

// Use the function to output the review cards
if ($rev_posts->have_posts()) {
    echo '<div class="container mt-3">';
    echo '<div class="row" id="reviews-container">';
    while ($rev_posts->have_posts()) {
        $rev_posts->the_post();
        wbr_output_review_card(get_the_ID());
    }
    wp_reset_postdata(); // Reset the post data to avoid conflicts
    echo '</div>';
    echo '<div class="load-more-rev-container"><button id="load-more-reviews">Load More Reviews</button></div>';
    echo '</div>';
} else {
    esc_html_e('No review found.', 'wpr');
}
?>

