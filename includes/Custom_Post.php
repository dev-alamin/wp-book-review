<?php 
namespace Book\Review;

/**
 * Custom_Post class manages custom post types and their functionality for book reviews and campaigns.
 *
 * This class handles the registration of custom post types, modification of admin columns,
 * loading of custom templates, modification of queries for custom post types, and preservation
 * of original post authors.
 *
 * @package Book\Review
 */
class Custom_Post {
    public function __construct() {
        add_action( 'init', [ $this, 'cpt_cb' ] );
        add_filter('manage_review_posts_columns', [ $this, 'custom_reviews_columns' ] );
        add_action('manage_review_posts_custom_column', [ $this, 'custom_reviews_column_content' ], 10, 2 );
        add_filter('template_include', [ $this, 'custom_post_type_template' ] );
        add_action('pre_get_posts', array($this, 'modify_archive_query') );
        add_action('init', [ $this, 'custom_product_statuses' ] );
        add_action('save_post', [ $this, 'update_post_author_info' ], 10, 3 );
        add_action('save_post', [ $this, 'wbr_preserve_original_author' ], 10, 3 );

        add_action('init', [ $this, 'wbr_register_delete_request_post_status' ] );
        add_filter('display_post_states', [ $this, 'wbr_display_delete_request_post_state' ], 10, 2 );
        add_filter('quick_edit_dropdown_post_status', [ $this, 'wbr_add_delete_request_to_quick_edit' ] );
    
    }

    /**
     * Register custom post types for Book Reviews and Campaigns
     *
     * @return void
     **/
    public function cpt_cb() {
        $common_labels = array(
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'has_archive'        => true,
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'menu_position'      => 99,
            'menu_icon'          => 'dashicons-grid-view',
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'comments'),
        );

        $review_labels = array(
            'name'               => __( 'Book Reviews', 'wbr' ),
            'singular_name'      => __( 'Review', 'wbr' ),
            'add_new'            => __( 'Add New Review', 'wbr' ),
            'add_new_item'       => __( 'Add New Review', 'wbr' ),
            'edit_item'          => __( 'Edit Review', 'wbr' ),
            'new_item'           => __( 'New Review', 'wbr' ),
            'view_item'          => __( 'View Review', 'wbr' ),
            'search_items'       => __( 'Search Book Reviews', 'wbr' ),
            'not_found'          => __( 'No Book Reviews found', 'wbr' ),
            'not_found_in_trash' => __( 'No Book Reviews found in trash', 'wbr' ),
        );

        $review_args = array_merge($common_labels, array(
            'labels'  => $review_labels,
            'rewrite' => array(
                'slug'       => _x('book-review', 'slug', 'wbr'),
                'with_front' => false,
            ),
        ));

        $campaign_labels = array(
            'name'               => __( 'Campaigns', 'wbr' ),
            'singular_name'      => __( 'Campaign', 'wbr' ),
            'add_new'            => __( 'Add New Campaign', 'wbr' ),
            'add_new_item'       => __( 'Add New Campaign', 'wbr' ),
            'edit_item'          => __( 'Edit Campaign', 'wbr' ),
            'new_item'           => __( 'New Campaign', 'wbr' ),
            'view_item'          => __( 'View Campaign', 'wbr' ),
            'search_items'       => __( 'Search Campaigns', 'wbr' ),
            'not_found'          => __( 'No Campaigns found', 'wbr' ),
            'not_found_in_trash' => __( 'No Campaigns found in Trash', 'wbr' ),
            'parent_item_colon'  => __( 'Parent Campaign:', 'wbr' ),
            'menu_name'          => __( 'Campaigns', 'wbr' ),
            'menu_icon'          => 'dashicons-grid-view',
        );

        $campaign_args = array_merge($common_labels, array(
            'labels'  => $campaign_labels,
            'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
            'rewrite' => array(
                'slug'       => _x('review-campaign', 'slug', 'wbr'),
                'with_front' => false,
            ),
        ));

        register_post_type('review', $review_args);
        register_post_type('review-campaign', $campaign_args);
    }

    /**
     * Add custom columns to the Reviews admin list table
     *
     * @param array $columns Existing columns
     * @return array Modified columns
     **/
    public function custom_reviews_columns($columns) {
        $columns['review_book']         = __( 'Book', 'wbr' );
        $columns['review_author']       = 'Review Author';
        $columns['review_content']      = 'Review Content';
        $columns['is_featured_rev']     = __( 'Featured?', 'wbr' );
        $columns['review_content_rank'] = __( 'W Position', 'wbr' );
        $columns['related_campaign']    = __( 'Campaign', 'wbr' );
        return $columns;
    }

    /**
     * Display custom column content in the Reviews admin list table
     *
     * @param string $column The name of the column to display
     * @param int $post_id The ID of the current post
     * @return void
     **/
    public function custom_reviews_column_content($column, $post_id) {
        switch ($column) {
            case 'review_author':
                $author_id   = get_post_field('post_author', $post_id);
                $author_name = get_the_author_meta('display_name', $author_id);
                echo esc_html(ucwords($author_name));
                break;

            case 'review_content':
                $content         = get_post_field('post_content', $post_id);
                $trimmed_content = wp_trim_words($content, 10);
                echo esc_html($trimmed_content);
                break;

            case 'review_book':
                $product_id = get_post_meta(get_the_ID(), '_product_id', true);
                $product    = wc_get_product($product_id);
                if (!$product) return;
                echo '<a href="' . get_the_permalink($product->get_id()) . '">';
                echo esc_html($product->get_title());
                echo '</a>';
                break;

            case 'is_featured_rev':
                if (!function_exists('carbon_get_post_meta')) break;
                $is_featured = carbon_get_post_meta(get_the_ID(), 'wbr_is_featured_review');
                if ($is_featured == 1) {
                    echo 'Yes';
                }
                break;

            case 'review_content_rank':
                if (!function_exists('carbon_get_post_meta')) break;
                $winner_position = carbon_get_post_meta(get_the_ID(), '_review_winner_option');
                if ($winner_position == 'default') break;
                echo esc_html(ucwords($winner_position));
                break;

            case 'related_campaign':
                $terms = get_the_terms(get_the_ID(), 'campaign_review');
                if (!empty($terms) && !is_wp_error($terms)) {
                    $term_names = array();
                    foreach ($terms as $term) {
                        $term_names[] = $term->name;
                    }
                    echo implode(', ', $term_names);
                } else {
                    echo '-';
                }
                break;
        }
    }

    /**
     * Load custom templates for single posts and archives of the 'review' and 'review-campaign' post types
     *
     * @param string $template The path of the template to include
     * @return string The modified path of the template to include
     **/
    public function custom_post_type_template($template) {
        global $post;

        if (isset($post->post_type) && $post->post_type == 'review') {
            if (is_singular('review')) {
                $custom_template = __DIR__ . '/Frontend/single-review.php';
                if (file_exists($custom_template)) {
                    return $custom_template;
                }
            }
        }

        if (isset($post->post_type) && $post->post_type == 'review-campaign') {
            if (is_singular('review-campaign')) {
                $review_template = __DIR__ . '/Frontend/single-campaign.php';
                if (file_exists($review_template)) {
                    return $review_template;
                }
            }
        }

        if (is_post_type_archive('review')) {
            $plugin_template = __DIR__ . '/Frontend/views/archive-review.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }

        if (is_post_type_archive('review-campaign')) {
            $plugin_template = __DIR__ . '/Frontend/views/archive-campaign.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }

        if (is_author()) {
            $author_template = __DIR__ . '/Frontend/views/author.php';
            if (file_exists($author_template)) {
                return $author_template;
            }
        }

        return $template;
    }

    /**
     * Modify the main query for the 'review' post type archive to display 6 posts per page
     *
     * @param WP_Query $query The current query
     * @return void
     **/
    public function modify_archive_query($query) {
        if (!is_admin()) {
            if ($query->is_post_type_archive('review') && $query->is_main_query()) {
                $query->set('posts_per_page', 6);
            }
        }
    }

    /**
     * Register custom product statuses for WooCommerce
     *
     * @return void
     **/
    public function custom_product_statuses() {
        register_post_status('wc-pending-approval', array(
            'label'                     => _x('Pending Approval', 'Product status', 'woocommerce'),
            'public'                    => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Pending Approval <span class="count">(%s)</span>', 'Pending Approval <span class="count">(%s)</span>', 'woocommerce'),
        ));
    }

    /**
     * Prevent admin from changing the author of a post when editing
     *
     * @param int $post_id The ID of the post being saved
     * @param WP_Post $post The post object
     * @param bool $update Whether this is an existing post being updated
     * @return void
     **/
    public function update_post_author_info($post_id, $post, $update) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (current_user_can('administrator')) {
            remove_action('save_post', array($this, 'update_post_author_info'), 10);
            wp_update_post(array(
                'ID'          => $post_id,
                'post_author' => $post->post_author,
            ));
            add_action('save_post', array($this, 'update_post_author_info'), 10, 3);
        }
    }

    /**
     * Preserve the original author of a 'review' post type when edited
     *
     * @param int $post_id The ID of the post being saved
     * @param WP_Post $post The post object
     * @param bool $update Whether this is an existing post being updated
     * @return void
     **/
    public function wbr_preserve_original_author( $post_id, $post, $update ) {
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return;
        }

        if ($post->post_type !== 'review') {
            return;
        }

        $original_author_id = get_post_meta($post_id, '_original_author_id', true);

        if (!$update && !$original_author_id) {
            update_post_meta($post_id, '_original_author_id', $post->post_author);
        } elseif ($update && $original_author_id && $post->post_author != $original_author_id) {
            remove_action('save_post', 'wbr_preserve_original_author', 10, 3);
            wp_update_post(array(
                'ID'          => $post_id,
                'post_author' => $original_author_id,
            ));
            add_action('save_post', 'wbr_preserve_original_author', 10, 3);
        }
    }


    /**
     * Register a custom post status 'delete_request' for the 'review' post type.
     */
    public function wbr_register_delete_request_post_status() {
        register_post_status('delete_request', array(
            'label'                     => _x('Delete Request', 'post status label'),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Delete Request <span class="count">(%s)</span>', 'Delete Requests <span class="count">(%s)</span>'),
        ));
    }

    /**
     * Display the custom post status 'delete_request' in the post list table.
     *
     * @param array $post_states An array of post display states.
     * @param WP_Post $post The current post object.
     * @return array The modified array of post display states.
     */
    public function wbr_display_delete_request_post_state($post_states, $post) {
        if ($post->post_status === 'delete_request') {
            $post_states['delete_request'] = _x('Delete Request', 'post status');
        }
        return $post_states;
    }

    /**
     * Add the 'delete_request' status to the quick edit dropdown.
     *
     * @param array $post_statuses The array of post statuses.
     * @return array The modified array of post statuses.
     */
    public function wbr_add_delete_request_to_quick_edit($post_statuses) {
        $post_statuses['delete_request'] = _x('Delete Request', 'post status');
        return $post_statuses;
    }
}
