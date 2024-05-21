<?php 
namespace Book\Review\Frontend\User;

class Review {
    public function __construct() {
        add_shortcode('display_reviews', [ $this, 'display_reviews' ] );   
    }

    public function display_reviews( $atts ) {
        wp_enqueue_style( 'wbr-bootstrap' );
		wp_enqueue_script( 'wbr-bootstrap-js' );
        wp_enqueue_style( 'wbr-fontawesome' );
        wp_enqueue_style( 'wbr-style' );
        
        wp_enqueue_script( 'wbr-script' );
        
        ob_start();
        $review = true;

        $has_review = current_user_can( 'submit_review' ); // Need to add cap
        
        if( is_user_logged_in() ) {
            $this->display_review_submission_form();
        }
        
        if( $review ) {
            // Display existing reviews
            $this->review_list();
        }
        
        return ob_get_clean();
    }

    public function display_review_submission_form() {
        $review_id = isset($_GET['reviewid']) ? intval($_GET['reviewid']) : null;
        $file = $review_id ? __DIR__ . '/../Form/edit-review.php' : __DIR__ . '/../Form/submit-review.php';
    
        if (file_exists($file)) {
            include $file;
            wp_enqueue_script('wbr-script');
        }
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