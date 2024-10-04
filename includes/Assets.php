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
        add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
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
            'wbr-simplebar' => [
                'src'     => '//unpkg.com/simplebar@latest/dist/simplebar.min.js',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery', 'wp-util' ]
            ],
            'wbr-select2' => [
                'src'     => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
			'wbr-bootstrap-js' => [
                'src'     => '//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'tiny-mce' => [
                'src'     => '//cdn.tiny.cloud/1/6ab4ikdk4qmkiuookatavsi3nas1irrmrnf5e9allzgj3o2l/tinymce/7/tinymce.min.js',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'slick-js' => [
                'src'     => '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'wbr-wow-js' => [
                'src'     => BOOK_REVIEW_ASSETS . '/js/wow.js',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'wbr-flip-js' => [
                'src'     => BOOK_REVIEW_ASSETS . '/js/flip.min.js',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'wb-sweet-alert' => [
                'src' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
                'version' => fileatime( BOOK_REVIEW_PATH . '/assets/js/frontend.js' ),
                'deps' => [ 'jquery' ]
            ]
        ];
    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles() {
        return [
            'wbr-style' => [
                'src'     => BOOK_REVIEW_ASSETS . '/css/frontend.css',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/css/frontend.css' )
            ],
            'wbr-style-flip' => [
                'src'     => BOOK_REVIEW_ASSETS . '/css/flip.min.css',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/css/flip.min.css' )
            ],
            'wbr-admin-style' => [
                'src'     => BOOK_REVIEW_ASSETS . '/css/admin.css',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/css/admin.css' )
            ],
            'wbr-bootstrap' => [
                'src'     => BOOK_REVIEW_ASSETS . '/css/bootstrap.min.css',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/css/bootstrap.min.css' )
            ],
            'wbr-simplebar' => [
                'src'     => '//unpkg.com/simplebar@latest/dist/simplebar.css',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/css/frontend.css' )
            ],
            'wbr-fontawesome' => [
                'src'     => BOOK_REVIEW_ASSETS . '/fontawesome/css/all.min.css',
                'version' => filemtime( BOOK_REVIEW_PATH . '/assets/css/frontend.css' )
            ],
            'wbr-select2' => [
                'src' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css',
                'version' => '4.0.13'
            ],
            'slick-css' => [
                'src' => '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css',
                'version' => '4.0.13'
            ],
            'wbr-wow-css' => [
                'src' => BOOK_REVIEW_ASSETS . '/css/animation.css',
                'version' => '1.0.0'
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
                'ajaxUrl'       => admin_url( 'admin-ajax.php'),
                'nonce'         => wp_create_nonce( 'wbr_readmore' ),
                'CurrentAuthor' => get_current_user_id(),
            ]
        );

        if( ! is_admin() ) {
            if ( is_singular() || is_archive() ) {
                    // Get the current post object
                global $post;
                
                // Check if the post type is 'review'
                if ( $post && $post->post_type === 'review' || $post && $post->post_type === 'review-campaign' || is_author() ) {
                    // wp_enqueue_style( 'wbr-simplebar' );
                    wp_enqueue_style( 'wbr-bootstrap' );
                    wp_enqueue_style( 'wbr-fontawesome' );
                    wp_enqueue_style( 'wbr-style' );
                    wp_enqueue_style( 'wbr-style-flip' );
                    wp_enqueue_style( 'slick-css' );
                    wp_enqueue_style( 'wbr-wow-css' );
                    wp_enqueue_style( 'wbr-select2' );
                    wp_enqueue_style( 'wbr-style-summernote' );
                    
                    wp_enqueue_script( 'wbr-simplebar' );
                    wp_enqueue_script( 'wbr-script' );
                    wp_enqueue_script( 'tiny-mce' );
                    wp_enqueue_script( 'slick-js' );
                    wp_enqueue_script( 'wbr-wow-js' );
                    wp_enqueue_script( 'wb-sweet-alert' );
                    wp_enqueue_script( 'wbr-flip-js' );
                    wp_enqueue_script( 'wbr-select2' );
                    wp_enqueue_script( 'wbr-summernote-js' );
                }
            }
        }
    }
}
