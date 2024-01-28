<?php 
namespace Book\Review\Frontend\User;

class Review {
    public function __construct() {
        add_shortcode('display_reviews', [ $this, 'display_reviews' ] );   
    }

    public function display_reviews( $atts ) {
        wp_enqueue_style( 'wbr-simplebar' );
        wp_enqueue_style( 'wbr-bootstrap' );
        wp_enqueue_style( 'wbr-fontawesome' );
        wp_enqueue_style( 'wbr-style' );

        wp_enqueue_script( 'wbr-simplebar' );
        wp_enqueue_script( 'wbr-script' );
        
        ob_start();
        $review = true;

        // Display review submission form
        //$this->display_review_submission_form();
        
        if( $review ) {
            // Display existing reviews
            $this->review_list();
        }
    
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
        $paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
        $args = array(
            'number'    => get_option( 'comments_per_page' ),
            'post_type' => 'product',
            'paged'     => $paged,
            'parent'    => 0,
            'orderby'   => 'comment_date',
            'order'     => 'ASC',
        );
        
        $comments = get_comments( $args );
        
        $file = __DIR__ . '/../views/review-list.php';

        $error_message = sprintf(
            'The file %s at line %d could not be found. Please ask the developer to fix this issue.',
            __FILE__,
            __LINE__
        );


        $rev_file =__DIR__ . '/../views/review-archive.php';

        if( file_exists( $file ) ) {
            include $rev_file;
            // include $file;
        }else{
           echo esc_html_e( $error_message, 'wbr' );
        }
    }

    /**
     * Display star ratings based on a numerical rating.
     *
     * @param int $rating The numerical rating.
     */
    public function display_star_rating( $rating ) {
        $max_rating = 5;

        $filled_stars = round( $rating, 1 );
        $empty_stars = max( 0, $max_rating - $filled_stars );

        for ( $i = 0; $i < $filled_stars; $i++ ) {
            echo '<span class="star-filled">&#9733;</span>';
        }

        for ( $i = 0; $i < $empty_stars; $i++ ) {
            echo '<span class="star-empty">&#9733;</span>';
        }
    }

}