<?php
/**
 * Book Review Miscellaneous Functionality
 *
 * @package Book\Review
 */

namespace Book\Review;

/**
 * Class Miscellaneous
 *
 * Handles miscellaneous functionalities for the Book Review plugin.
 */
class Miscellaneous {

    /**
     * Constructor for the Miscellaneous class.
     */
    public function __construct() {
        // Hook into WordPress actions and filters
        add_action('admin_head', [$this, 'custom_admin_column_width_css']);
        add_action('wp_body_open', [$this, 'sticky_header_code']);
        add_filter('manage_users_columns', [$this, 'add_review_count_column']);
        add_filter('manage_users_custom_column', [$this, 'show_review_count_column_content'], 10, 3);
        add_filter('manage_users_sortable_columns', [$this, 'make_review_count_column_sortable']);
        add_action('pre_get_users', [$this, 'sort_users_by_review_count']);
        add_action('save_post', [$this, 'update_user_review_count']);
        add_action('pre_get_posts', [$this, 'add_custom_post_type_to_author_query']);
        add_action('init', [$this, 'add_reviewer_role']);
    }

    /**
     * Add custom CSS to set column widths in the admin interface.
     */
    public function custom_admin_column_width_css() {
        echo '<style type="text/css">';
        echo '.column-is_featured_rev, .column-review_content_rank { width: 80px; }';
        echo '.column-related_campaign { width: 120px; }';
        echo '</style>';
    }

    /**
     * Add sticky header code.
     */
    public function sticky_header_code() {
        echo '
            <div id="wbrfs_overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>
        ';
    }

    /**
     * Add a new column to the users table to show the review count.
     *
     * @param array $columns Existing columns.
     * @return array Modified columns.
     */
    public function add_review_count_column($columns) {
        $columns['review_count'] = 'Review Count';
        return $columns;
    }

    /**
     * Populate the review count column with data.
     *
     * @param string $value Current cell value.
     * @param string $column_name Column name.
     * @param int $user_id User ID.
     * @return string Modified cell value.
     */
    public function show_review_count_column_content($value, $column_name, $user_id) {
        if ('review_count' === $column_name) {
            $review_count = count_user_posts($user_id, 'review');
            return $review_count;
        }
        return $value;
    }

    /**
     * Ensure the review count column is sortable.
     *
     * @param array $columns Existing sortable columns.
     * @return array Modified sortable columns.
     */
    public function make_review_count_column_sortable($columns) {
        $columns['review_count'] = 'review_count';
        return $columns;
    }

    /**
     * Handle sorting of users by review count.
     *
     * @param WP_User_Query $query The current query.
     */
    public function sort_users_by_review_count($query) {
        if (!is_admin()) {
            return;
        }

        $screen = get_current_screen();
        if ('users' !== $screen->id) {
            return;
        }

        if (isset($_GET['orderby']) && 'review_count' === $_GET['orderby']) {
            $query->query_vars['meta_key'] = 'review_count';
            $query->query_vars['orderby'] = 'meta_value_num';
        }
    }

    /**
     * Update the review count for a user when a review is saved.
     *
     * @param int $post_id The post ID.
     */
    public function update_user_review_count($post_id) {
        if (get_post_type($post_id) !== 'review') {
            return;
        }

        $author_id    = get_post_field('post_author', $post_id);
        $review_count = count_user_posts($author_id, 'review');
        update_user_meta($author_id, 'review_count', $review_count);
    }

    /**
     * Include custom post type 'review' in author queries.
     *
     * @param WP_Query $query The current query.
     */
    public function add_custom_post_type_to_author_query( $query ) {
        if ($query->is_author() && $query->is_main_query() && !is_admin()) {
            $query->set('post_type', array('post', 'review'));
        }
    }

    /**
     * Add the Reviewer role with specific capabilities.
     */
    public function add_reviewer_role() {
        add_role(
            'reviewer',
            __('Reviewer'),
            array(
                'read'         => true,  // Allow this role to read posts
                'edit_posts'   => true,  // Allow this role to edit their own posts
                'upload_files' => true,  // Allow this role to upload files
            )
        );
    }
}