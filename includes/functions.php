<?php 
defined( 'ABSPATH' ) || exit;

/**
 * Get Book author | authors
 * @package Book_Review
 * @since 1.0.0
 * @param int $post Post ID.
 */
function wbr_get_authors( $post, $all_authors = true ) {
    $authors = get_the_terms( $post, 'authors' );

    if ( ! $authors || is_wp_error( $authors ) ) {
        return;
    }

    $authors_names = wp_list_pluck( $authors, 'name' );

    // If $all_authors is true, return all authors; otherwise, return one author
    return esc_html( $all_authors ? implode( ', ', $authors_names ) : reset( $authors_names ) );
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
function wbr_get_book_cover( $post, $comment, $class = 'product-thumbnail', $anchor_class = '' ) {
    $thumbnail  = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
    $permalink  = get_comment_link( $comment );
    $post_title = get_the_title( $post );

    if ( $thumbnail ) : 
        return '<a href="' . esc_url( $permalink ) . '" class="'. $anchor_class . '"> <img src="' . esc_url( $thumbnail[0] ) . '" alt="' . esc_attr( $post_title ) . '" class="'. $class .'"></a>';
    endif; 
}

/**
 * Get Comment Author name with Anchor tag
 * @package Book_Review
 * @since 1.0.0
 * @param int $post Post ID.
 */
function wbr_get_comment_author_name( $comment ) {
    $author_name = get_comment_author($comment);
    // $comment_author_id = get_comment(get_comment_ID())->user_id;
    $comment_author_data = get_userdata($comment->user_id);
    $first_name = '';
    $last_name = '';

    if( isset( $comment_author_data->first_name ) ) {
        $comment_author_data->first_name;
    }

    if( isset( $comment_author_data->last_name ) ) {
        $comment_author_data->last_name;
    }


    if( ! empty( $first_name ) || ! empty( $last_name ) ) {
        $author_name = $first_name . ' ' . $last_name;
    }else{
        $author_name = get_comment_author($comment);
    }

    $author_url  = get_author_posts_url($comment->user_id);

   return ($author_url ? '<a href="' . $author_url . '">' . esc_html($author_name) . '</a>' : esc_html($author_name));

}