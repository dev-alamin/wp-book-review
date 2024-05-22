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
                <?php if( ! is_author() ) : ?>
                <div class="comment-entry wpr-single-comment">
                    <?php 
                    echo '<div class="author-meta">';
                    echo '<div class="author-avatar"> <a href="' . esc_url(get_author_posts_url( $author_id )) . '"> ' . $author_avatar . '</a></div>';
                    echo '<div class="author-and-count">';
                       echo '<a href="' . esc_url(get_author_posts_url( $author_id )) . '">';
                       echo '<strong>' . esc_html( strtoupper( $comment_author_name ? $comment_author_name : $author_name ) ) . '</strong>';
                       echo '</a>';
                       echo '<p>মোট ' . ff_english_to_bengali( $comment_count ) . ' টি পর্যালোচনা লিখেছেন</p>';
                    echo '</div>';
                    echo '</div>';
                    ?>
                </div>
                <?php endif; ?>
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


 function wbr_get_top_reviewed_books( int $limit = 5 ) {
    global $wpdb;

    $query = "
        SELECT p.id, t.term_id, t.name, COUNT(*) AS review_count
        FROM {$wpdb->prefix}terms AS t
        INNER JOIN {$wpdb->prefix}term_taxonomy AS tt ON t.term_id = tt.term_id
        INNER JOIN {$wpdb->prefix}term_relationships AS tr ON tt.term_taxonomy_id = tr.term_taxonomy_id
        INNER JOIN {$wpdb->prefix}posts AS p ON tr.object_id = p.ID
        WHERE tt.taxonomy = 'review_book'
        AND p.post_type = 'review'
        GROUP BY t.term_id
        ORDER BY review_count DESC
        LIMIT $limit
    ";

    $results = $wpdb->get_results( $query );

    return $results;
}

/**
 * Retrieves the most commented posts.
 *
 * Retrieves the most commented posts from the WordPress database and formats them into
 * an HTML list based on the provided container element and class.
 *
 * @param string $post              Optional. Post type to retrieve. Default is 'review'.
 * @param string $container_element Optional. Container element for the list. Default is 'ul'.
 * @param string $container_class   Optional. Class for the container element. Default is 'leaderboard-list'.
 * @return string                   The formatted HTML list of most commented posts.
 */
function wbr_get_most_commented_posts( $post = 'review', $container_element = 'ul', $container_class = 'leaderboard-list' ) {
    global $wpdb;

    $query = "
        SELECT p.ID, p.post_title, COUNT(c.comment_ID) AS comment_count
        FROM {$wpdb->prefix}posts AS p
        LEFT JOIN {$wpdb->prefix}comments AS c ON p.ID = c.comment_post_ID
        WHERE p.post_type = '$post'
        AND p.post_status = 'publish'
        GROUP BY p.ID
        ORDER BY comment_count DESC
        LIMIT 5
    ";

    // Execute the query
    $results = $wpdb->get_results( $query );

    // Start building the output HTML
    $output = '<' . $container_element . ' class="' . esc_attr($container_class) . '">';
    foreach ( $results as $result ) {
        $output .= '<li>';
        // Check if the post has a featured image
        if ( has_post_thumbnail( $result->ID ) ) {
            // Get the featured image URL
            $featured_image_url = get_the_post_thumbnail_url( $result->ID, 'thumbnail' ); // Adjust the image size as needed
            // Output the featured image as a link
            $output .= '<a href="' . get_permalink( $result->ID ) . '"><img src="' . $featured_image_url . '" alt="' . esc_attr( $result->post_title ) . '"></a>';
        }
        $output .= '<a href="' . get_permalink( $result->ID ) . '">' . esc_html( wp_trim_words( $result->post_title, 7 ) ) . '</a>';
        $output .= '</li>';
    }
    
    $output .= '</' . $container_element . '>';

    return $output;
}

/**
 * Expected campaign winner position
 * @since 1.0.0
 * @param mixed $name
 * @return array
 */
function wbr_campaign_positions():array{
    return [
        'first',
        'second',
        'third',
        'fourth',
        'fifth',
        'sixth',
        'seventh',
        'eighth',
        'ninth',
        'tenth',
        'eleventh',
        'twelfth',
        'thirteenth',
        'fourteenth',
        'fifteenth',
        'sixteenth',
        'seventeenth',
        'eighteenth',
        'nineteenth',
        'twentieth'
    ];
}