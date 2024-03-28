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

        add_action( 'wp_ajax_submit_review', [ $this, 'submit_review_callback' ] );
        add_action( 'wp_ajax_nopriv_submit_review', [ $this, 'submit_review_callback' ] );
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
                wbr_output_review_card( get_the_ID() );
            }
            wp_reset_postdata();
            
            $has_more_posts = $rev_posts->max_num_pages > $page;
        }
    
        wp_die();
    }

    public function submit_review_callback() {
        // $current_user_has_post = count_user_posts( get_current_user_id(), 'review', true );

        if( ! $_SERVER["REQUEST_METHOD"] == "POST" ) {
            wp_send_json_error( 'Invalid Request' );
        }

        if ( ! isset($_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'submit_review' ) ) {
            wp_send_json_error('Invalid nonce.');
        }
    
        $errors = array();

        $review_title   = isset($_POST['review-title']) ? sanitize_text_field($_POST['review-title']) : '';
        $review_content = isset($_POST['review-content']) ? wp_kses_post($_POST['review-content']) : '';
        $product_id     = isset($_POST['product-id']) ? absint($_POST['product-id']) : 0;
        $review_rating  = isset($_POST['review-rating']) ? intval($_POST['review-rating']) : '';
        $post_status    = isset($_POST['publish-status']) ? sanitize_text_field( $_POST['publish-status'] ) : '';
        
        // Check for errors
        if ( empty( $review_title ) ) {
            $errors[] = 'You must provide a review title.';
        }

        if ( empty( $review_content ) ) {
            $errors[] = 'You must provide review content.';
        }

        if( ! isset( $_FILES['product-image-id'] ) || empty( $_FILES['product-image-id'] ) || $_FILES['product-image-id']['error'] == 4 ) {
            $errors[] = 'You must provide image for review.';
        }

        if( ! isset( $_POST['review-rating'] ) || empty( $_POST['review-rating'] ) ) {
            $errors[] = 'You must put a rating.';
        }

        if( ! isset( $_POST['publish-status'] ) || empty( $_POST['publish-status'] ) ) {
            $errors[] = 'You must choose publish status.';
        }

        if ( ! empty( $errors ) ) {
            foreach ($errors as $error) {
                wp_send_json_error( $error );
            }
        }


        if ( isset( $_FILES['product-image-id'] ) && ! empty( $_FILES['product-image-id']['tmp_name'] ) ) {

            $file = $_FILES['product-image-id'];
            $file_type = wp_check_filetype_and_ext($file['tmp_name'], $file['name']);
            if (!$file_type['type'] || !in_array($file_type['type'], array('image/jpeg', 'image/png', 'image/gif'))) {
                wp_send_json_error('Invalid file type. Please upload a JPEG, PNG, or GIF image.');
            }
    
            $attachment_id = media_handle_upload('product-image-id', 0); // 0 means no parent post
    
            if ( is_wp_error($attachment_id ) ) {
                wp_send_json_error('Failed to upload image. Please try again.');
            } else {
                // Upload successful
                $product_image_id = $attachment_id;
            }
        } else {
            wp_send_json_error('Please upload a product image.');
        }
        
        $review_post = array(
            'post_title'             => get_the_title($product_id),
            'post_content'           => $review_content,
            'post_status'            => $post_status,
            'post_type'              => 'review',
            'meta_input'             => array(
                '_product_id'            => $product_id,
                '_review_rating'         => $review_rating,
                '_product_image_id'      => $product_image_id,
                // '_comment_author_url'   => get_author_posts_url( $user_id, get_userdata( $user_id )->nickname  )
            )
        );

        $review_post_id = wp_insert_post($review_post); // Insert review type post

        if ( $review_post_id ) {
            set_post_thumbnail( $review_post_id, $product_image_id );
            $product_name = get_the_title( $product_id );
            $existing_term = get_term_by('name', $product_name, 'review_book');

            if ($existing_term) {
                $term_id = $existing_term->term_id;
            } else {
                $term = wp_insert_term($product_name, 'review_book');
                
                if (!is_wp_error($term)) {
                    $term_id = $term['term_id'];
                } else {
                    wp_send_json_error('Failed to create term.');
                }
            }
            wp_set_post_terms($review_post_id, array($term_id), 'review_book', true);
            wp_send_json_success( 'Review submitted successfully.' );
        } else {
            wp_send_json_error('Failed to submit review.');
        }
        wp_die();
    }
    
}
