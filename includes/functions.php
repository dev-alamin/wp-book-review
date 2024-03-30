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

        <div class="wpr-card mb-5">
            <div class="wpr-card-header" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>);">
                <a href="<?php the_permalink(); ?>">

                </a>
            </div>
            <div class="wpr-card-body">
            <div class="right-title">
                <h2> 
                    <a href="<?php the_permalink(); ?>" target="_balnk">
                    <?php 
                    $title = $remove_review ? esc_html( $remove_review ) : esc_html( $post_title);
                    
                    echo wp_trim_words( $title, 15 );
                    ?>
                    </a>
                </h2>
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
                <div class="title-description">
                    <a href="<?php the_permalink(); ?>" target="_blank">
                        <?php echo wp_trim_words( get_the_content(), 20, '...' ); ?>
                    </a>
                </div>
                <!-- Display the individual comment -->
                <div class="comment-entry wpr-single-comment">
                    <?php 
                    echo '<div class="author-meta">';
                    echo '<div class="author-avatar"> <a href="' . esc_url($comment_author_url) . '"> ' . $author_avatar . '</a></div>';
                    echo '<div class="author-and-count">';
                       echo '<a href="' . esc_url($comment_author_url) . '">';
                       echo '<strong>' . esc_html( strtoupper( $comment_author_name ? $comment_author_name : $author_name ) ) . '</strong>';
                       echo '</a>';
                       echo '<p>মোট ' . $comment_count . ' টি পর্যালোচনা লিখেছেন</p>';
                    echo '</div>';
                    echo '</div>';
                    ?>
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


function validate_image_and_upload($file) {
    $file_type = wp_check_filetype_and_ext($file['tmp_name'], $file['name']);

    if (!$file_type['type'] || !in_array($file_type['type'], array('image/jpeg', 'image/png', 'image/gif'))) {
        return 'Invalid file type. Please upload a JPEG, PNG, or GIF image.';
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        return 'File size exceeds the maximum limit of 2MB.';
    }

    list($width, $height) = getimagesize($file['tmp_name']);
    // if ($width < 1280 || $height < 720) {
    //     return 'Image resolution must be at least 1280x720 pixels.';
    // }

    // Crop the image if larger than 1280x720, keeping the aspect ratio
    if ($width > 1280 || $height > 720) {
        $editor = wp_get_image_editor($file['tmp_name']);
        if (!is_wp_error($editor)) {
            $editor->resize(1280, 720, true); // Crop to 1280x720
            $resized_file = $editor->save(); // Save the resized image
            $file['tmp_name'] = $resized_file['path']; // Update the temporary file path
            return 'Image cropped at proper size';
        } else {
            return 'Failed to resize image. Please try again.';
        }
    }

    $attachment_id = media_handle_upload('product-image-id', 0); // 0 means no parent post
    if (is_wp_error($attachment_id)) {
        return 'Failed to upload image. Please try again.';
    }

    return $attachment_id;
}


if( ! function_exists( 'ff_english_to_bengali' ) ) {
    // Convert Arabic numbers to Bengali numbers
    function ff_english_to_bengali( $number = '' ) {
        $bengali_numbers = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
        return str_replace(range(0, 9), $bengali_numbers, $number);
    }
}

function ff_get_term_link( $post_id ) {
    $terms = get_the_terms( $post_id, 'review_book');

    if ($terms && !is_wp_error($terms)) {
        $term_slugs = array(); 

        foreach ($terms as $term) {
            $term_slugs[] = urldecode($term->slug);
        }

        $archive_link = get_term_link(  $term_slugs[0], 'review_book');
        $archive_link = urldecode( $archive_link );

        if (!is_wp_error($archive_link) ) {
            return '<a class="btn" style="background:var(--wd-primary-color);max-width:200px;margin:10px auto;" href="' . esc_url($archive_link) . '">এই বইটির সকল রিভিউ দেখুন</a>';
        }
    }
 }