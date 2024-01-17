<?php
/**
 * WP Book Review Admin Menu Class
 *
 * @package WPBookReview
 * @subpackage Admin
 * @since 1.0.0
 */

namespace Book\Review\Admin;

/**
 * Class Menu
 *
 * This class handles the creation of the admin menu for the WP Book Review plugin.
 *
 * @since 1.0.0
 */
class Menu {
    /**
     * Constructor function to initialize the Menu class.
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'menu' ] );
    }

    /**
     * Callback function to create the admin menu for the WP Book Review plugin.
     *
     * @since 1.0.0
     */
    public function menu() {
        add_menu_page(
            __( 'Book Review', 'wpr' ),
            __( 'Book Review', 'wpr' ),
            'manage_options',
            'wp-book-review',
            [ $this, 'menu_cb' ],
            'dashicons-star-filled'
        );
    }

    /**
     * Callback function for the admin menu page.
     *
     * @since 1.0.0
     */
    public function menu_cb() {
       $file = __DIR__ . '/views/review-list.php';

       if( file_exists( $file ) ) {
        include $file;
       }else{
        esc_html_e( 'Review list file could not be found. Please ask developer to fix', 'wpr' );
       }
    }
}
