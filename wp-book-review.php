<?php 
/**
 * Plugin Name: WP Book Review
 * Plugin URI:  
 * Description: This plugin will help you to take user review like forum. It will increase engangement and thus boost sale.
 * Version:     1.0
 * Author:      Al Amin
 * Author URI:  https://almn.me/wp-book-review
 * Text Domain: wbr
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * Requires at least: 5.4
 * Requires PHP: 7.0
 * Requires Plugins:
 *
 * @package     WPBookReview
 * @author      Al Amin
 * @copyright   2024 ShalikDev
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 *
 * Prefix:      Book_Review
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Book_Review {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
     * Class construcotr
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes a singleton instance
     *
     * @return \Book_Review
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'BOOK_REVIEW_VERSION', self::version );
        define( 'BOOK_REVIEW_FILE', __FILE__ );
        define( 'BOOK_REVIEW_PATH', __DIR__ );
        define( 'BOOK_REVIEW_URL', plugins_url( '', BOOK_REVIEW_FILE ) );
        define( 'BOOK_REVIEW_ASSETS', BOOK_REVIEW_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new Book\Review\Assets();
        new Book\Review\Taxonomy();
        new Book\Review\Custom_Post();
        new \Book\Review\Admin\Metabox();

        // new Book\Review\Woocommerce\Create_Post();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Book\Review\Ajax();
        }

        if ( is_admin() ) {
            new Book\Review\Admin();
        } else {
            new Book\Review\Frontend();
        }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {

    }
}

/**
 * Initializes the main plugin
 *
 * @return \Book_Review
 */
function book_review() {
    return Book_Review::init();
}

// kick-off the plugin
book_review();

function enqueue_select2_assets() {
    wp_enqueue_style('book-review-wow-css', plugin_dir_url(__FILE__) . "/assets/css/animation.css", array(), '1.0.0');
    wp_enqueue_style('select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array(), '4.0.13');
    wp_enqueue_style('slick-css', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css', array(), '4.0.13');
    // wp_enqueue_style('slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css', array(), '4.0.13');

    wp_enqueue_script('jquery');

    wp_enqueue_script('select2-js', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);

    wp_enqueue_script( 'tiny-mce', '//cdn.tiny.cloud/1/6ab4ikdk4qmkiuookatavsi3nas1irrmrnf5e9allzgj3o2l/tinymce/7/tinymce.min.js', ['jquery'], time(), true );
    wp_enqueue_script( 'slick-js', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', ['jquery'], time(), true );
    wp_enqueue_script('book-review-wow-js',  plugin_dir_url(__FILE__) . "/assets/js/wow.js");
    wp_enqueue_script( 'wb-sweet-alert', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', [], '1.0.0', true );
}
add_action('wp_enqueue_scripts', 'enqueue_select2_assets');

function custom_admin_column_width_css() {
    echo '<style type="text/css">';
    echo '.column-is_featured_rev, .column-review_content_rank { width: 80px; }';
    echo '.column-related_campaign { width: 120px; }';
    echo '</style>';
}

add_action('admin_head', 'custom_admin_column_width_css');

function sticky_header_code() {
    echo '
        <div id="wbrfs_overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div>
    ';
}
add_action( 'wp_body_open', 'sticky_header_code' );


// Add a new column to the users table
function add_review_count_column($columns) {
    $columns['review_count'] = 'Review Count';
    return $columns;
}
add_filter('manage_users_columns', 'add_review_count_column');

// Populate the review count column with data
function show_review_count_column_content($value, $column_name, $user_id) {
    if ('review_count' === $column_name) {
        $review_count = count_user_posts($user_id, 'review');
        return $review_count;
    }
    return $value;
}
add_filter('manage_users_custom_column', 'show_review_count_column_content', 10, 3);

// Ensure the column is sortable
function make_review_count_column_sortable($columns) {
    $columns['review_count'] = 'review_count';
    return $columns;
}
add_filter('manage_users_sortable_columns', 'make_review_count_column_sortable');

// Handle the sorting by review count
function sort_users_by_review_count($query) {
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
add_action('pre_get_users', 'sort_users_by_review_count');

// Update user meta with review count upon saving a review post
function update_user_review_count($post_id) {
    if (get_post_type($post_id) !== 'review') {
        return;
    }

    $author_id = get_post_field('post_author', $post_id);
    $review_count = count_user_posts($author_id, 'review');
    update_user_meta($author_id, 'review_count', $review_count);
}
add_action('save_post', 'update_user_review_count');

function add_custom_post_type_to_author_query( $query ) {
    if ($query->is_author() && $query->is_main_query() && !is_admin()) {
        $query->set('post_type', array('post', 'review')); // Include default posts and your custom post type
    }
}
add_action('pre_get_posts', 'add_custom_post_type_to_author_query');
