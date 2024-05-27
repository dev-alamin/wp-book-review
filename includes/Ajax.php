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
        add_action( 'wp_ajax_edit_review', [ $this, 'edit_review_callback'] );


        add_action( 'wp_ajax_load_author_reviews', [ $this, 'load_author_reviews' ] );
        add_action( 'wp_ajax_nopriv_load_author_reviews', [ $this, 'load_author_reviews' ] );
        // add_action( 'wp_ajax_nopriv_submit_review', [ $this, 'submit_review_callback' ] );

        add_action('wp_ajax_wbr_set_review_status', [ $this, 'wbr_request_deletion' ] );

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
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            wp_send_json_error('Invalid Request');
        }
    
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'submit_review')) {
            wp_send_json_error('Invalid nonce.');
        }
    
        $errors = $this->validate_review_submission($_POST, $_FILES);
        if (!empty($errors)) {
            wp_send_json_error($errors);
        }
    
        $product_image_id = $this->validate_image_and_upload($_FILES['product-image-id']);
        if ( is_wp_error( $product_image_id ) ) {
            wp_send_json_error($product_image_id->get_error_message());
        } elseif (is_string($product_image_id)) {
            wp_send_json_error($product_image_id);
        }
        // wp_send_json_error( $_POST );
        $review_post_id = $this->create_review_post($_POST, $product_image_id);
        if (is_wp_error($review_post_id)) {
            wp_send_json_error('Failed to submit review.');
        }
    
        if( ! empty( $_POST['campaign_id'] ) ) {
            $this->set_review_terms($review_post_id, $_POST['product-id'], $_POST['campaign_id']);
        }
    
        wp_send_json_success('Review submitted successfully.');
        wp_die();
    }
    
    /**
    * Validates the review submission data.
    *
    * @param array $post_data The POST data.
    * @param array $file_data The FILE data.
    * @return array An array of error messages, or an empty array if no errors.
    */
    private function validate_review_submission($post_data, $file_data) {
        $errors = array();
    
        if (empty($post_data['review-title'])) {
            $errors[] = 'You must provide a review title.';
        }
    
        if (empty($post_data['review-content'])) {
            $errors[] = 'You must provide review content.';
        }
    
        if (!isset($file_data['product-image-id']) || empty($file_data['product-image-id']['tmp_name']) || $file_data['product-image-id']['error'] == 4) {
            $errors[] = 'You must provide an image for review.';
        }
    
        if (empty($post_data['review-rating'])) {
            $errors[] = 'You must provide a rating.';
        }
    
        if (empty($post_data['publish-status'])) {
            $errors[] = 'You must choose a publish status.';
        }
    
        return $errors;
    }
    
    /**
    * Validates and uploads an image file.
    *
    * @param array $file The file data.
    * @return int|string The attachment ID on success, or an error message on failure.
    */
    private function validate_image_and_upload($file) {
        $file_type = wp_check_filetype_and_ext($file['tmp_name'], $file['name']);
    
        if (!$file_type['type'] || !in_array($file_type['type'], array('image/jpeg', 'image/png', 'image/gif'))) {
            return 'Invalid file type. Please upload a JPEG, PNG, or GIF image.';
        }
    
        if ($file['size'] > 2 * 1024 * 1024) {
            return 'File size exceeds the maximum limit of 2MB.';
        }
    
        list($width, $height) = getimagesize($file['tmp_name']);
    
        // Crop the image if larger than 1280x720, keeping the aspect ratio
        if ($width > 1280 || $height > 720) {
            $editor = wp_get_image_editor($file['tmp_name']);
            if (!is_wp_error($editor)) {
                $editor->resize(1280, 720, true); // Crop to 1280x720
                $resized_file = $editor->save(); // Save the resized image
                $file['tmp_name'] = $resized_file['path']; // Update the temporary file path
            } else {
                return 'Failed to resize image. Please try again.';
            }
        }
    
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
    
        $attachment_id = media_handle_upload('product-image-id', 0); // 0 means no parent post
        if (is_wp_error($attachment_id)) {
            return 'Failed to upload image. Please try again.';
        }
    
        return $attachment_id;
    }
    
    /**
     * Creates a new review post.
     *
     * @param array $post_data The POST data.
     * @param int $product_image_id The ID of the uploaded image.
     * @return int|\WP_Error The ID of the created post, or a WP_Error object on failure.
     */
    private function create_review_post($post_data, $product_image_id) {
        $post_status = sanitize_text_field( $post_data['publish-status'] );
        $status = '';
        if( $post_status == 'publish' ) {
            $status = 'pending';
        }elseif( $post_status == 'draft' ) {
            $status = 'draft';
        }

        $review_post = array(
            'post_title' => sanitize_text_field($post_data['review-title']),
            'post_content' => wp_kses_post($post_data['review-content']),
            'post_status' => $status,
            'post_type' => 'review',
            'meta_input' => array(
                '_product_id' => absint($post_data['product-id']),
                '_review_rating' => intval($post_data['review-rating']),
                '_product_image_id' => $product_image_id,
                '_campaign_id' => absint($post_data['campaign_id']),
            )
        );
    
        $review_post_id = wp_insert_post($review_post);
    
        if ($review_post_id && !is_wp_error($review_post_id)) {
            set_post_thumbnail($review_post_id, $product_image_id);
        }
    
        return $review_post_id;
    }
    
    /**
     * Sets the review terms (taxonomy) for a review post.
     *
     * @param int $review_post_id The ID of the review post.
     * @param int $product_id The ID of the product.
     * @param int $campaign_id The ID of the campaign.
     * @return void
     */
    private function set_review_terms($review_post_id, $product_id, $campaign_id) {
        $product_name = get_the_title($product_id);
        $campaign_name = get_the_title($campaign_id);
    
        $review_book_term = $this->get_or_create_term($product_name, 'review_book');
        if (is_wp_error($review_book_term)) {
            wp_send_json_error('Failed to create or get term in review_book taxonomy.');
        }
    
        $campaign_review_term = $this->get_or_create_term($campaign_name, 'campaign_review');
        if (is_wp_error($campaign_review_term)) {
            wp_send_json_error('Failed to create or get term in campaign_review taxonomy.');
        }
    
        wp_set_post_terms($review_post_id, array($review_book_term), 'review_book', true);
        if ($campaign_id) {
            wp_set_post_terms($review_post_id, array($campaign_review_term), 'campaign_review', true);
        }
    }
    
    private function get_or_create_term($term_name, $taxonomy) {
        $existing_term = get_term_by('name', $term_name, $taxonomy);
        if ($existing_term) {
            return $existing_term->term_id;
        }
    
        $new_term = wp_insert_term($term_name, $taxonomy);
        if (is_wp_error($new_term)) {
            return $new_term;
        }
    
        return $new_term['term_id'];
    }

    public function edit_review_callback() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            wp_send_json_error('Invalid Request');
        }
    
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'edit_review')) {
            wp_send_json_error('Invalid nonce.');
        }
    
        $errors = $this->validate_review_submission($_POST, $_FILES);
        $has_image = $_POST['existing_image'];

        if( ! isset( $has_image ) && ! empty( $has_image ) ) {
            if (!empty($errors)) {
                wp_send_json_error($errors);
            }
        }
    
        if( isset( $_FILES['product-image-id'] ) && empty( $has_image ) ) {
            $product_image_id = $this->validate_image_and_upload($_FILES['product-image-id']);
            if (is_wp_error($product_image_id)) {
                wp_send_json_error($product_image_id->get_error_message());
            } elseif (is_string($product_image_id)) {
                wp_send_json_error($product_image_id);
            }
        }else{
            $product_image_id = $this->validate_image_and_upload($_FILES['product-image-id']);
        }
    
        $review_id = isset($_POST['review_id']) ? absint($_POST['review_id']) : 0;
    
        if ($review_id > 0) {
            $review_post_id = $this->update_review_post($review_id, $_POST, $product_image_id);
        } else {
            wp_send_json_error('Review ID is missing.');
        }
    
        if (is_wp_error($review_post_id)) {
            wp_send_json_error('Failed to update review.');
        }
    
        if( ! empty( $_POST['campaign_id'] ) ) {
            $this->set_review_terms($review_post_id, $_POST['product-id'], $_POST['campaign_id']);
        }
    
        wp_send_json_success('Review updated successfully.');
        wp_die();
    }

    private function update_review_post($review_id, $post_data, $product_image_id) {
        $post_status = sanitize_text_field( $post_data['publish-status'] );
        $status = '';
        if( $post_status == 'publish' ) {
            $status = 'pending';
        }elseif( $post_status == 'draft' ) {
            $status = 'draft';
        }

        $review_post = array(
            'ID' => $review_id,
            'post_title' => sanitize_text_field($post_data['review-title']),
            'post_content' => wp_kses_post($post_data['review-content']),
            'post_status' => $status,
            'meta_input' => array(
                '_product_id' => absint($post_data['product-id']),
                '_review_rating' => intval($post_data['review-rating']),
                '_product_image_id' => $product_image_id,
                '_campaign_id' => absint($post_data['campaign_id']),
            )
        );
    
        $review_post_id = wp_update_post($review_post);
    
        if ($review_post_id && !is_wp_error($review_post_id)) {
            set_post_thumbnail($review_post_id, $product_image_id);
        }
    
        return $review_post_id;
    }

    public function update_user_agreement_callback() {
        if ( ! isset( $_POST['ff_user_agreement_nonce_field'] ) || ! wp_verify_nonce( $_POST['ff_user_agreement_nonce_field'], 'ff_user_agreement_nonce' ) ) {
            wp_send_json_error( 'Nonce verification failed.' );
        }

        $user_consent = isset( $_POST['user_agreement_consent'] ) ? $_POST['user_agreement_consent'] : false;
        if ( ! $user_consent ) {
            wp_send_json_error( 'Please check the agreement checkbox before proceeding.' );
        }

        $user_id = get_current_user_id();
        $existing_user_consent = get_user_meta( $user_id, 'user_agreement_consent', true );

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
    
    public function load_author_reviews() {
        $author_id      = isset($_POST['author_id']) ? intval($_POST['author_id']) : 0;
        $paged          = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $posts_per_page = 10;
    
        $author_review_posts_args = array(
            'post_type'      => 'review',
            'author'         => $author_id,
            'posts_per_page' => $posts_per_page,
            'paged'          => $paged,
            'post_status'    => ['publish', 'pending', 'draft', 'private', 'delete_request' ],
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
    
        $author_review_posts = new \WP_Query($author_review_posts_args);
    
        if ($author_review_posts->have_posts()) {
            $serial = (($paged - 1) * $posts_per_page) + 1;
            while ($author_review_posts->have_posts()) {
                $author_review_posts->the_post();
                $post_id        = get_the_ID();
                $post_title     = get_the_title();
                $post_date      = get_the_date();
                $review_book    = get_post_meta(get_the_ID(), '_product_id', true);
                $review_book_id = $review_book ? $review_book : '0';
                $post_statuses = wbr_get_post_status_badge_class( $post_id );
    
                echo '<tr>';
                echo '<td>' . esc_html($serial++) . '</td>';
                echo '<td>' . esc_html(wp_trim_words($post_title, 8, '')) . '</td>';
                echo '<td><img width="50px" src="' . get_the_post_thumbnail_url(get_the_ID(), 'medium') . '"></td>';
                echo '<td>';
                if( $review_book_id && $review_book_id != 0 ) {
                    echo '<a href="' . get_the_permalink($review_book_id) . '">' . esc_html(get_the_title($review_book_id)) . '</a>';
                }
                echo '</td>';
                echo '<td>' . esc_html($post_date) . '</td>';
                echo '<td><span class="badge '. esc_attr( $post_statuses ) . '">' . esc_html( ucwords( str_replace( '_', ' ', get_post_status( $post_id ) ) ) ) . '</span></td>';
                echo '<td>';
                if( get_post_status( $post_id ) == 'draft' ) {
                    echo '<a class="me-2" href="' . esc_url( '/publish' ) . '"><span class="badge text-bg-info">Publish</span></a>';
                }
                echo '<a class="me-2" href="' . esc_url('/submit-review?reviewid=' . get_the_ID()) . '"><span class="badge text-bg-primary">Edit</span></a>';
                echo '<a href="#" class="wbrDeleteRequestReview" data-id="' . esc_attr( $post_id ) . '"><span class="badge text-bg-danger">Delete</span></a>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">No reviews found.</td></tr>';
        }
    
        wp_reset_postdata();
        wp_die();
    }

    public function wbr_request_deletion() {
        if (isset($_POST['post_id'])) {
            $post_id = intval($_POST['post_id']);
            $post = get_post($post_id);

            if ($post && $post->post_type === 'review') {
                wp_update_post(array(
                    'ID' => $post_id,
                    'post_status' => 'delete_request',
                ));

                wp_send_json_success('Post status updated successfully.');
            } else {
                wp_send_json_error('Invalid post ID or post type.');
            }
        }

        wp_send_json_error('Post ID not provided.');
    }
}
