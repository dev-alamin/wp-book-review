<?php
namespace Book\Review;

/**
 * Class Ajax
 *
 * Handles AJAX functionality for Book Reviews.
 *
 * @package Book\Review
 */
class Ajax {
    /**
     * Ajax constructor.
     *
     * Sets up actions for AJAX requests.
     */
    public function __construct() {
        add_action( 'wp_ajax_get_full_comment_content', [ $this, 'full_text' ] );
        add_action( 'wp_ajax_nopriv_get_full_comment_content', [ $this, 'full_text' ] );

        add_action('wp_ajax_load_more_reviews', [ $this, 'load_more_reviews' ] );
        add_action('wp_ajax_nopriv_load_more_reviews', [ $this, 'load_more_reviews' ] );
    }

    /**
     * Retrieves the full content of a comment for AJAX request.
     */
    public function full_text() {
        $comment_id = isset( $_POST['comment_id'] ) ? intval( $_POST['comment_id'] ) : 0;
        $comment = get_comment( $comment_id );

        if ( $comment ) {
            echo wp_kses_post( $comment->comment_content );
        }

        wp_die();
    }

    /**
     * Loads more reviews for AJAX request.
     */
    public function load_more_reviews() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $posts_per_page = 3; // Adjust the default value as needed
    
        $review_args = array(
            'post_type'      => 'review',
            'post_status'    => 'publish',
            'posts_per_page' => $posts_per_page,
            'orderby'        => 'date',
            'order'          => 'ASC',
            'paged'          => $page,
        );
    
        $rev_posts = new \WP_Query($review_args);
    
        if ($rev_posts->have_posts()) {
            while ($rev_posts->have_posts()) {
                $rev_posts->the_post();
                // Output your review content here
                wbr_output_review_card( get_the_ID() );
            }
            wp_reset_postdata();
            
            $has_more_posts = $rev_posts->max_num_pages > $page;
        }
    
        wp_die();
    }
    
}
