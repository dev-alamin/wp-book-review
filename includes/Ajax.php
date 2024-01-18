<?php 
namespace Book\Review;

class Ajax {
    public function __construct() {
        add_action( 'wp_ajax_get_full_comment_content', [ $this, 'full_text' ] );
        add_action( 'wp_ajax_nopriv_get_full_comment_content', [ $this, 'full_text' ] );
    }

    public function full_text() {
        $comment_id = isset( $_POST['comment_id'] ) ? intval( $_POST['comment_id'] ) : 0;
        $comment = get_comment( $comment_id );

        if ( $comment ) {
            echo wp_kses_post( $comment->comment_content );
        }

        wp_die();
    }
}