<?php 
/**
 * Plugin Name: WP Book Review
 * Plugin URI:  
 * Description: This plugin will help you to take user review like forum. It will increase engangement and thus boost sale.
 * Version:     1.0
 * Author:      Al Amin, Fahad Abdullah
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
 * @author      Al Amin, Fahad Abdullah
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

        // if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        //     new Book\Review\Ajax();
        // }

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




function cptui_register_my_taxes_authors() {

	/**
	 * Taxonomy: Authors.
	 */

	$labels = [
		"name" => esc_html__( "Authors", "custom-post-type-ui" ),
		"singular_name" => esc_html__( "Author", "custom-post-type-ui" ),
	];

	
	$args = [
		"label" => esc_html__( "Authors", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => '/books/author', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "authors",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "authors", [ "product" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_authors' );

function cptui_register_my_taxes_publisher() {

	/**
	 * Taxonomy: Publishers.
	 */

	$labels = [
		"name" => esc_html__( "Publishers", "custom-post-type-ui" ),
		"singular_name" => esc_html__( "Publisher", "custom-post-type-ui" ),
	];

	
	$args = [
		"label" => esc_html__( "Publishers", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => '/books/publisher', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "publisher",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "publisher", [ "product" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_publisher' );

/**
 * Add a custom product data tab
 */
add_filter('woocommerce_product_tabs', 'hhbs_new_product_tab');
function hhbs_new_product_tab($tabs)
{

    unset($tabs['additional_information']);

    // Adds the new tab

    $tabs['test_tab'] = array(
        'title'     => __('Author', 'woocommerce'),
        'priority'     => 50,
        'callback'     => 'hhbs_new_product_tab_content'
    );

    return $tabs;
}
function hhbs_new_product_tab_content()
{

    // The new tab content
    $author = get_the_terms(get_the_ID(), ['authors']);
    $single_author = $author[0];
    $author_name = [];
    $author_desc = [];
    foreach ($author as $a) {
        $author_name[] = $a->name;
        $author_desc[] = $a->description;
    }

    echo '<h2>' . esc_html($author_name[0]) . '</h2>';
    echo '<p>' . esc_html($author_desc[0]) . '</p>';
}



// do_action( 'astra_woo_shop_title_after' );


add_action('astra_woo_shop_title_after', function () {
    $author = get_field('book_author', get_the_ID());

    echo '<p style="opacity:.7;font-size:13px !important;margin-top:-5px;" class="hhbs-book-author-shop">';
    foreach ($author as $a) {
        print_r($a->name);
    }
    echo '</p>';

}, 9);
