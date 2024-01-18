<?php

namespace Book\Review;

/**
 * Assets handlers class
 */
class Assets {

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        // add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts() {
        return [
            'wbr-script' => [
                'src'     => BOOK_REVIEW_ASSETS . '/js/frontend.js',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'wbr-admin-script' => [
                'src'     => BOOK_REVIEW_ASSETS . '/js/admin.js',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/js/admin.js' ),
                'deps'    => [ 'jquery' ]
            ],
            // 'wbr-admin-script' => [
            //     'src'     => BOOK_REVIEW_ASSETS . '/js/admin.js',
            //     'version' => filemtime( BOOK_REVIEW_PATH . '/assets/js/admin.js' ),
            //     'deps'    => [ 'jquery', 'wp-util' ]
            // ],
        ];
    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles() {
        return [
            'wpr-style' => [
                'src'     => BOOK_REVIEW_ASSETS . '/css/frontend.css',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/css/frontend.css' )
            ],
            'wpr-admin-style' => [
                'src'     => BOOK_REVIEW_ASSETS . '/css/admin.css',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/css/admin.css' )
            ],
            'wpr-bootstrap' => [
                'src'     => BOOK_REVIEW_ASSETS . '/css/bootstrap.min.css',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/css/bootstrap.min.css' )
            ],
        ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets() {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;

            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;
            
            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }

        wp_localize_script( 
            'wbr-script',
            'wbrFrontendScripts',
            [
                'ajaxUrl' => admin_url( 'admin-ajax.php'),
                'nonce'    => wp_create_nonce( 'wbr_readmore' )
            ]
        );
    }
}
