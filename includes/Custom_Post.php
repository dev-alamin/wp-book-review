<?php 
namespace Book\Review;

class Custom_Post {
    public function __construct() {
        add_action( 'init', [ $this, 'cpt_cb' ] );

        add_filter('manage_review_posts_columns', [ $this, 'custom_reviews_columns' ]);
        add_action('manage_review_posts_custom_column', [ $this, 'custom_reviews_column_content' ], 10, 2);

        add_filter('template_include', [ $this, 'custom_post_type_template' ]);
        add_filter('template_include', array($this, 'review_archive_template') );

        add_action('pre_get_posts', array($this, 'modify_archive_query'));

        add_action('init', [ $this, 'custom_product_statuses' ] );
    }

     /**
     * Register Post Type POST Book Review
     *
     * @return void
     **/
    public function cpt_cb(){
        $labels = array(
            'name'               => __( 'Book Review', 'wbr' ),
            'singular_name'      => __( 'Review', 'wbr' ),
            'add_new'            => __( 'Add New Review', 'wbr' ),
            'add_new_item'       => __( 'Add New Review', 'wbr' ),
            'edit_item'          => __( 'Edit Review', 'wbr' ),
            'new_item'           => __( 'New Review', 'wbr' ),
            'view_item'          => __( 'View Review', 'wbr' ),
            'search_items'       => __( 'Search Book Review', 'wbr' ),
            'not_found'          => __( 'Not found Book Review', 'wbr' ),
            'not_found_in_trash' => __( 'Not found Book Review in trash', 'wbr' ),
        );
        $args   = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_rest'       => true, // Adds gutenberg support.
            'query_var'          => true,
            'rewrite'            => array(
                'slug'       => _x( 'book-review', 'slug', 'wbr' ),
                'with_front' => false,
            ),
            'has_archive'        => true,
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'menu_position'      => 99,
            'menu_icon'          => 'dashicons-star-filled', // https://developer.wordpress.org/resource/dashicons/.
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'comments' ),
        );
        register_post_type( 'review', $args );
    }


    public function custom_reviews_columns($columns) {
        // Add Comment Author column
        $columns['comment_author'] = 'Comment Author';

        // Add Comment Content column
        $columns['comment_content'] = 'Comment Content';

        return $columns;
    }


    public function custom_reviews_column_content($column, $post_id) {
        switch ($column) {
            case 'comment_author':
                $comment_author_id = get_post_meta($post_id, '_comment_author_id', true);
    
                if ($comment_author_id) {
                    $comment_author_data = get_userdata($comment_author_id);
    
                    if ($comment_author_data) {
                        $first_name = $comment_author_data->first_name;
                        $last_name = $comment_author_data->last_name;
    
                        $author_name = !empty($first_name) || !empty($last_name) ? "$first_name $last_name" : get_comment_author($comment_author_id);
                    } else {
                        $author_name = get_comment_author($comment_author_id);
                    }
                } else {
                    $author_name = 'N/A'; // Replace with a default value if no author ID is found
                }
    
                echo esc_html($author_name);
                break;
    
            case 'comment_content':
                $content = get_post_field('post_content', $post_id);
                $trimmed_content = wp_trim_words($content, 10);
                echo esc_html($trimmed_content);
                break;
        }
    }

    public function custom_post_type_template($template) {
        global $post;
    
        if ( isset ( $post->post_type ) && $post->post_type == 'review' ) {
            if( is_singular( 'review' ) ) {
                $custom_template = __DIR__ . '/Frontend/single-review.php';
                if ( file_exists( $custom_template ) ) {
                    return $custom_template;
                }
            }
        }
    
        return $template;
    }

    public function review_archive_template($template) {
        if (is_post_type_archive('review')) { // Adjust 'review' to your custom post type slug
            // Check if the template file exists in your plugin directory
            $plugin_template = __DIR__ . '/Frontend/views/archive-review.php';

            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }
        return $template;
    }

    public function modify_archive_query($query) {
        if( ! is_admin() ) {
            if ($query->is_post_type_archive('review') && $query->is_main_query()) {
                $query->set('posts_per_page', 3);
            }
        }
    }

    public function custom_product_statuses() {
        register_post_status('wc-pending-approval', array(
            'label' => _x('Pending Approval', 'Product status', 'woocommerce'),
            'public' => true,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,
            'label_count' => _n_noop('Pending Approval <span class="count">(%s)</span>', 'Pending Approval <span class="count">(%s)</span>', 'woocommerce'),
        ));
    }
}