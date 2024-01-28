<?php 
namespace Book\Review\Woocommerce;

class Create_Post {
    public function __construct() {
        add_action('woocommerce_new_comment', [ $this, 'create_review_post_from_comment' ], 10, 2);
    }

    /**
     * Create a review post from a WooCommerce product review comment.
     *
     * This method checks if the given comment is associated with a product and is of type 'review'.
     * It then creates a new review post in the 'review' custom post type, associating it with the
     * respective product and storing relevant information such as the comment author's details,
     * comment rating, and post thumbnail.
     *
     * @param int   $comment_id    The ID of the comment.
     * @param array $comment_data  The data of the comment.
     *
     * @return void
     */
    public function create_review_post_from_comment( $comment_id, $comment_data ) {
        // Check if the comment is associated with a product
        if ($comment_data['comment_type'] === 'review' && isset($comment_data['comment_post_ID'])) {
            $product_id = $comment_data['comment_post_ID'];
            
            $product_title = get_the_title($product_id);
            $comment_author_data = get_userdata($comment_data['user_id']);
    
            if ($comment_author_data) {
                $term_name = $comment_author_data->display_name;
                $term = term_exists($term_name, 'review_author');
    
                if (!$term) {
                    $term = wp_insert_term(
                        $term_name,
                        'review_author',
                        array(
                            'description' => 'Review author: ' . $term_name,
                            'slug'        => sanitize_title($term_name),
                        )
                    );
    
                    if (is_wp_error($term)) {
                        error_log('Failed to create term for user ' . $comment_author_data->ID . ': ' . $term->get_error_message());
                    }
                }
    
                // Get the single comment rating from WooCommerce review comment meta
                $comment_rating = get_comment_meta($comment_id, 'rating', true);
    
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
                    update_post_meta($review_post_id, '_comment_author_id', $comment_data['user_id']); // Save comment author's ID
                    update_post_meta($review_post_id, '_comment_rating', $comment_rating); // Save comment rating
    
                    // Set post thumbnail to the product image
                    $product_image_id = get_post_thumbnail_id($product_id);
    
                    if ($product_image_id) {
                        set_post_thumbnail($review_post_id, $product_image_id);
                    }
    
                    // Save comment author information and comment count as post meta
                    $comment_author_name = $comment_author_data->display_name;
                    $comment_author_url = get_author_posts_url($comment_data['user_id']);
                    $comment_count = count(get_comments(array('user_id' => $comment_data['user_id'])));
    
                    update_post_meta($review_post_id, '_comment_author_name', $comment_author_name);
                    update_post_meta($review_post_id, '_comment_author_url', $comment_author_url);
                    update_post_meta($review_post_id, '_comment_count', $comment_count);
                }
            }
        }
    }       
}