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
    wp_enqueue_style('select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array(), '4.0.13');

    wp_enqueue_script('jquery');

    wp_enqueue_script('select2-js', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);

    wp_enqueue_script( 'tiny-mce', '//cdn.tiny.cloud/1/6ab4ikdk4qmkiuookatavsi3nas1irrmrnf5e9allzgj3o2l/tinymce/7/tinymce.min.js', ['jquery'], time(), true );

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


function add_tinymce_referrer_policy($tag, $handle) {
    if ($handle === 'tiny-mce') {
        $tag = str_replace('></script>', ' referrerpolicy="origin"></script>', $tag);
    }
    return $tag;
}

add_filter('script_loader_tag', 'add_tinymce_referrer_policy', 10, 2);
