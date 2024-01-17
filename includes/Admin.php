<?php 
/**
 * WP Book Review Admin Class
 *
 * @package WPBookReview
 * @subpackage Admin
 * @since 1.0.0
 */

namespace Book\Review;

/**
 * Class Admin
 *
 * This class serves as the main entry point for the WP Book Review admin functionality.
 *
 * @since 1.0.0
 */
class Admin {
    /**
     * Constructor function to initialize the Admin class.
     *
     * It instantiates the Menu class to handle the creation of admin menus.
     *
     * @since 1.0.0
     */
    public function __construct() {
        new Admin\Menu();
    }
}
