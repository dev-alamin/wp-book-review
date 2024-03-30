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
        // add_action( 'wp_ajax_nopriv_submit_review', [ $this, 'submit_review_callback' ] );

        add_action('wp_ajax_update_user_agreement', [ $this, 'update_user_agreement_callback' ]);
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


        // Usage
        if (isset($_FILES['product-image-id']) && !empty($_FILES['product-image-id']['tmp_name'])) {
            $file_validation_result = validate_image_and_upload($_FILES['product-image-id']);
            if (is_int($file_validation_result)) {
                // Upload successful
                $product_image_id = $file_validation_result;
            } else {
                // Validation failed
                wp_send_json_error($file_validation_result);
            }
        } else {
            // No file uploaded
            wp_send_json_error('Please upload a product image.');
        }

        $review_post = array(
            'post_title'             => $review_title,
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

    // Callback function to update user metadata
    public function update_user_agreement_callback() {
        // Verify nonce
        if ( ! isset( $_POST['ff_user_agreement_nonce_field'] ) || ! wp_verify_nonce( $_POST['ff_user_agreement_nonce_field'], 'ff_user_agreement_nonce' ) ) {
            wp_send_json_error( 'Nonce verification failed.' );
        }

        // Check if the agreement checkbox is checked
        $user_consent = isset( $_POST['user_agreement_consent'] ) ? $_POST['user_agreement_consent'] : false;
        if ( ! $user_consent ) {
            wp_send_json_error( 'Please check the agreement checkbox before proceeding.' );
        }

        $user_id = get_current_user_id();
        $existing_user_consent = get_user_meta( $user_id, 'user_agreement_consent', true );

        // $deleted = delete_user_meta( $user_id, 'user_agreement_consent', 'user_agreement_consent');
        if ( ! empty( $existing_user_consent ) ) {
            wp_send_json_error( 'User has already submitted the agreement form.' );
        }else {
            $meta_saved = update_user_meta( $user_id, 'user_agreement_consent', $user_consent );
            if ( $meta_saved ) {
                wp_send_json_success( 'You\'ve already agreed with our terms and conditions.' );
            } else {
                wp_send_json_error( 'Failed to save user agreement consent.' );
            }
        }



        wp_die();
    }   
}
