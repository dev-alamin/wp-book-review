<?php 
defined( 'ABSPATH' ) || exit;

/**
 * Get Book author | authors
 * @package Book_Review
 * @since 1.0.0
 * @param int $post Post ID.
 */
function wbr_get_author( $post ) {
    $authors = get_the_terms( $post, 'authors' );

    if ( ! $authors || is_wp_error( $authors ) ) {
        return;
    }

    $authors_count = count( $authors );

    if ( $authors_count === 0 ) {
        return;
    }

    $authors_names = wp_list_pluck( $authors, 'name' );

    // return esc_html__( $authors_count === 1 ? 'Author' : 'Authors' ) . ': ' . esc_html( implode( ', ', $authors_names ) );
    return esc_html( implode( ', ', $authors_names ) );

}

/**
 * Get Book publisher
 *
 * @package Book_Review
 * @since 1.0.0
 * @param int $post Post ID.
 */
function wbr_get_publisher( $post, $name ) {
    $publishers = get_the_terms( $post, 'publisher' );

    if ( $publishers && ! is_wp_error( $publishers ) && isset( $publishers[0]->name ) ) {
        return  esc_html__( $name . $publishers[0]->name );
    }
}


/**
 * Get Book Cover Photo with anchor tag
 * And HTML class for image
 * @package Book_Review
 * @since 1.0.0
 * @param int $post Post ID.
 */
function wbr_get_book_cover( $post, $class = 'product-thumbnail', $anchor_class = '' ) {
    $thumbnail  = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
    $permalink = get_the_permalink( $post );
    $post_title = get_the_title( $post );

    if ( $thumbnail ) : 
        return '<a href="' . esc_url( $permalink ) . '" class="'. $anchor_class . '"> <img src="' . esc_url( $thumbnail[0] ) . '" alt="' . esc_attr( $post_title ) . '" class="'. $class .'"></a>';
    endif; 
}
