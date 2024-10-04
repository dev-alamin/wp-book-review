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
        new \Book\Review\Miscellaneous();

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
