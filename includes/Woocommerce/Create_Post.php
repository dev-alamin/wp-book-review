<?php 
namespace Book\Review\Woocommerce;

class Create_Post {
    public function __construct() {
        add_action('woocommerce_new_comment', [ $this, 'create_review_post_from_comment' ], 10, 2);
    }

    public function create_review_post_from_comment($comment_id, $comment_data) {
        // Check if the comment is associated with a product
        if ($comment_data['comment_type'] === 'review' && isset($comment_data['comment_post_ID'])) {
            $product_id = $comment_data['comment_post_ID'];
    
            // Get the product title
            $product_title = get_the_title($product_id);
    
            // Create a new post for the 'review' custom post type
            $review_post = array(
                'post_title'   => $product_title . ' Review',
                'post_content' => $comment_data['comment_content'],
                'post_status'  => 'publish',
                'post_author'  => $comment_data['user_id'],
                'post_type'    => 'review',
            );
    
            $review_post_id = wp_insert_post($review_post);
    
            // Set the product review post meta for reference
            if ($review_post_id) {
                update_post_meta($review_post_id, '_product_review_id', $comment_id);
                update_post_meta($review_post_id, '_associated_product_id', $product_id);
                
                // Save the comment author's ID as well
                update_post_meta($review_post_id, '_comment_author_id', $comment_data['user_id']);
            }
        }
    }    
}