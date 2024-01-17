<?php 
namespace Book\Review\Frontend\User;

class Review {
    public function __construct() {
        add_shortcode('display_reviews', [ $this, 'display_reviews' ] );   
    }

    function display_reviews( $atts ) {
        ob_start();
        $review = true;

        if( $review ) {
            // Display existing reviews
            $this->review_list();
        }
    
        // Display review submission form
        $this->display_review_submission_form();
    
        return ob_get_clean();
    }

    public function display_review_submission_form() {
        // Custom form for submitting reviews
        ?>
        <div id="review-submission-form">
            <h2>Submit a Review</h2>
            <form id="review-form" action="" method="post">
                <label for="review-title">Review Title:</label>
                <input type="text" name="review-title" id="review-title" required>
    
                <label for="review-content">Your Review:</label>
                <textarea name="review-content" id="review-content" required></textarea>
    
                <label for="review-rating">Rating:</label>
                <select name="review-rating" id="review-rating" required>
                    <option value="5">5 Stars</option>
                    <!-- Add other rating options as needed -->
                </select>
    
                <input type="submit" value="Submit Review">
            </form>
        </div>
        <?php
    }

    public function review_list() {
        wp_enqueue_style( 'wpr-bootstrap' );
        wp_enqueue_style( 'wpr-style' );

        $paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
        $args = array(
            'number'    => get_option( 'comments_per_page' ),
            'post_type' => 'product',
            'paged'     => $paged,
            'parent'    => 0,
            'orderby'   => 'date',
            'order'     => 'DESC',
        );
        
        $comments = get_comments( $args );
        
        $file = __DIR__ . '/../views/review-list.php';

        if( file_exists( $file ) ) {
            include $file;
        }else{
            echo __( 'review-list.php file could not be found. Please ask developer to fix.', 'wpr' );
        }
    }
}