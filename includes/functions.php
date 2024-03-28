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

/**
 * Get Review Card | Review CPT
 * @package Book_Review
 * @since 1.0.0
 * @param int $post Post ID.
 */
function wbr_output_review_card( $post_id, $user_id = '' ) {
    $post_title          = get_the_title($post_id);
    $author_id           = get_post_field('post_author', $post_id);
    $comment_author_data = get_userdata($author_id);
    $author_url          = get_author_posts_url($author_id);
    $author_avatar       = get_avatar($author_id, 96); 
    $product_id          = get_post_meta($post_id, '_associated_product_id', true);
    $remove_review       = str_replace('Review', ' ', $post_title);
    $comment_author_id   = get_post_meta($post_id, '_comment_author_id', true);
    $author_avatar       = get_avatar($author_id, 96);
    $comment_author_name = get_post_meta($post_id, '_comment_author_name', true);
    $comment_author_url  = get_post_meta($post_id, '_comment_author_url', true);
    $comment_count       = count_user_posts( $author_id, 'review' );
    $author_name         = $comment_author_data ? $comment_author_data->display_name : 'Anonymous';
    $authors             = get_the_terms($product_id, 'authors');
    $product             = wc_get_product($product_id);
    ?>

    <div class="col-lg-4 col-sm-6 col-xs-12">
        <div class="card wpr-card mb-5">
            <div class="card-header wpr-card-header">
                <div class="header-banner">
                    <div class="thumbnail">
                       <a href="<?php echo get_the_permalink( $product_id ); ?>">
                        <?php the_post_thumbnail(); ?>
                       </a>
                    </div>
                    <div class="right-title">
                    <h5> <a href="<?php the_permalink(); ?>" target="_balnk"><?php echo $remove_review ? esc_html( $remove_review ) : esc_html( $post_title); ?></a></h5>
                        <p class="label-text"> <?php esc_html_e( 'বই নিয়ে টুকেরা কথা', 'wpr' ); ?></p>
                        <?php 
                        if ($authors && !is_wp_error($authors)) {
                            echo '<p class="author-list"><i class="fa-solid fa-pen-to-square ml-3"></i>';
                            $author_links = array();

                            foreach ($authors as $author) {
                                $author_links[] = '<a href="' . esc_url(get_term_link($author)) . '">' . esc_html($author->name) . '</a>';
                            }

                            echo implode(', ', $author_links);
                            echo '</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="card-body wpr-card-body" data-simplebar>
                <div class="title-description">
                    <a href="<?php the_permalink(); ?>" target="_blank">
                        <?php echo wp_trim_words( get_the_content(), 12, '...' ); ?>
                    </a>
                </div>
                <!-- Display the individual comment -->
                <div class="comment-entry wpr-single-comment">
                    <?php 
                    echo '<div class="author-meta">';
                    echo '<div class="author-avatar"> <a href="' . esc_url($comment_author_url) . '"> ' . $author_avatar . '</a></div>';
                    echo '<div class="author-and-count">';
                       echo '<a href="' . esc_url($comment_author_url) . '">';
                       echo esc_html( $comment_author_name ? $comment_author_name : $author_name );
                       echo '</a>';
                       echo '<p>মোট ' . $comment_count . ' টি পর্যালোচনা লিখেছেন</p>';
                    echo '</div>';
                    echo '</div>';
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Retrieves the total reviews count and average rating for a given product ID.
 *
 * @param int $product_id The ID of the product for which to retrieve reviews.
 * @return array An array containing the total reviews count and the average rating.
 */
function wpr_get_total_review_and_average($product_id) {
    $total_rating = 0;
    $total_reviews = 0;

    $args = array(
        'post_type' => 'review', // Assuming 'review' is the custom post type for reviews
        'meta_key' => '_product_id',
        'meta_value' => $product_id,
        'meta_compare' => '=',
        'posts_per_page' => -1, // Retrieve all reviews
    );

    $reviews_query = new WP_Query($args);

    while ($reviews_query->have_posts()) {
        $reviews_query->the_post();
        $rating = intval(get_post_meta(get_the_ID(), '_review_rating', true));
        $total_rating += $rating; // Sum the ratings
        $total_reviews++;
    }

    $average_rating = $total_reviews > 0 ? round($total_rating / $total_reviews, 2) : 0;

    wp_reset_postdata();

    return array(
        'total_reviews' => $total_reviews,
        'average_rating' => $average_rating
    );
}

