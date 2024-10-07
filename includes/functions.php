<?php

use Composer\Installers\RoundcubeInstaller;

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
function wbr_output_review_card( $post_id ) {
    $post_title          = get_the_title($post_id);
    $author_id           = get_post_field('post_author', $post_id);
    $comment_author_data = get_userdata($author_id);
    $author_avatar       = get_avatar($author_id, 96);
    $product_id          = get_post_meta($post_id, '_associated_product_id', true);
    $remove_review       = str_replace('Review', ' ', $post_title);
    $author_avatar       = get_avatar($author_id, 96);
    $comment_author_name = get_post_meta($post_id, '_comment_author_name', true);
    $comment_count       = count_user_posts( $author_id, 'review' );
    $author_name         = $comment_author_data ? $comment_author_data->display_name : 'Anonymous';
    $authors             = get_the_terms($product_id, 'authors');
    $book_info           = wbr_get_product_info_by_review( $post_id );
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
                    <?php if( isset(  $book_info['title'] ) ): ?>
                    <div class="review-meta-info">
                    <?php
                        $post_time = get_the_time('U'); // Get the post time in Unix timestamp format
                        $current_time = current_time('timestamp'); // Get the current time in Unix timestamp format
                        $time_diff = human_time_diff($post_time, $current_time); // Calculate the difference
                        $post_time = $time_diff . ' ago'; // Output the time difference in a human-readable format
                    ?>
                        <p class="post-time">
                            <i class="fa fa-regular fa-clock"></i>
                            <?php echo esc_html( $post_time ); ?>
                        </p>
                        <p>
                            <i class="fa fa-book"></i>
                            <a href="<?php echo esc_url( $book_info['permalink'] ); ?>"><?php echo esc_html( wp_trim_words( $book_info['title'], 5, '' ) ); ?></a>
                        </p>
                    </div>
                    <?php endif; ?>
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
                       echo '<p>মোট ' . wbr_english_to_bengali( $comment_count ) . ' টি পর্যালোচনা লিখেছেন</p>';
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

if( ! function_exists( 'wbr_english_to_bengali' ) ) {
    // Convert Arabic numbers to Bengali numbers
    function wbr_english_to_bengali( $number = '' ) {
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

    return $wpdb->get_results( $query );

}

/**
 * Get the most liked reviews posts of a specific post type.
 *
 * @param string $post_type The type of posts to retrieve. Default is 'review'.
 * @return array The array of the most commented posts.
 */
function wbr_get_most_commented_posts($post_type = 'review') {
    global $wpdb;

    $query = $wpdb->prepare("
        SELECT p.ID, p.post_title, COUNT(c.comment_ID) AS comment_count
        FROM {$wpdb->prefix}posts AS p
        LEFT JOIN {$wpdb->prefix}comments AS c ON p.ID = c.comment_post_ID
        WHERE p.post_type = %s
        AND p.post_status = 'publish'
        GROUP BY p.ID
        ORDER BY comment_count DESC
        LIMIT 5
    ", $post_type);

    return $wpdb->get_results($query);
}

/**
 * Expected campaign winner position
 * @since 1.0.0
 * @param mixed $name
 * @return array
 */
function wbr_campaign_positions():array{
    return [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
        '16',
        '17',
        '18',
        '19',
        '20'
    ];
}

/**
 * Get the number of days left until the campaign starts, or a message if the campaign has started or ended.
 *
 * This function retrieves the start date and end date from the post meta, calculates the number of days left
 * until the campaign starts, and returns a message based on the current date in relation to these dates.
 *
 * @param int $post_id The ID of the post from which to retrieve the meta fields.
 *
 * @return string A message indicating the number of days left until the campaign starts, that the campaign has started, 
 *                or that the submission date is over.
 */
function wbr_get_campaign_days_left(int $post_id) {
    if (!function_exists('carbon_get_post_meta')) return;

    $start_date = carbon_get_post_meta($post_id, 'first_submission_date');
    $last_date = carbon_get_post_meta($post_id, 'last_submission_date');

    // If start date is not set, return an empty string
    if (!$start_date) {
        return '';
    }

    $current_date = new DateTime();
    $start_date_obj = new DateTime($start_date);
    $end_date_obj = new DateTime($last_date);
    $interval = $current_date->diff($start_date_obj);
    $days_left = $interval->days;

    // Determine the message based on the dates
    if ($end_date_obj < $current_date) {
        $message = 'Submission date is over.';
    } elseif ($start_date_obj < $current_date) {
        $message = 'The campaign has started';
    } else {
        $message = sprintf('%s days left', $days_left);
    }

    return $message;
}

/**
 * Get the badge class for a given post's status.
 *
 * This function retrieves the post status of a given post ID and returns a corresponding 
 * badge class for displaying the post status in a styled manner.
 *
 * @param int $post_id The ID of the post.
 * @return string The CSS class for the badge corresponding to the post status.
 */
function wbr_get_post_status_badge_class( int $post_id ) {
    $post_statuses = get_post_status( $post_id );

    // Determine badge class based on post status
    $badge_class = '';
    switch ( $post_statuses ) {
        case 'publish':
            $badge_class = 'text-bg-primary';
            break;
        case 'pending':
            $badge_class = 'text-bg-warning';
            break;
        case 'draft':
            $badge_class = 'text-bg-secondary';
            break;
        case 'private':
            $badge_class = 'text-bg-dark';
            break;
        case 'trash' || 'delete_request':
            $badge_class = 'text-bg-danger';
            break;
        default:
            $badge_class = 'text-bg-info';
            break;
    }

    return $badge_class;
}

function wbr_number_to_word( int $number ) : string {
    $words = array(
        1 => 'First',
        2 => 'Second',
        3 => 'Third',
        4 => 'Fourth',
        5 => 'Fifth',
        6 => 'Sixth',
        7 => 'Seventh',
        8 => 'Eighth',
        9 => 'Ninth',
        10 => 'Tenth',
        11 => 'Eleventh',
        12 => 'Twelfth',
        13 => 'Thirteenth',
        14 => 'Fourteenth',
        15 => 'Fifteenth',
        16 => 'Sixteenth',
        17 => 'Seventeenth',
        18 => 'Eighteenth',
        19 => 'Nineteenth',
        20 => 'Twentieth'
    );

    return isset($words[$number]) ? $words[$number] : '';
}

/**
 * Retrieve basic information about the associated WooCommerce product by a given review ID.
 *
 * This function fetches the post meta value for '_product_id' associated
 * with a specific review post, retrieves the associated product object,
 * and returns an array containing basic information about the product.
 *
 * @param int $review_id The ID of the review post. Defaults to the current post ID.
 * @return array|false An array containing basic information about the product if found, or false if not.
 */
function wbr_get_product_info_by_review( $review_id = null ) {
    if ( is_null( $review_id ) ) {
        $review_id = get_the_ID();
    }

    $review_id = intval( $review_id );
    if ( $review_id <= 0 ) {
        return false;
    }

    $product_id = get_post_meta( $review_id, '_product_id', true );

    if (empty( $product_id )) {
        return false;
    }

    $product = wc_get_product( $product_id );

    if ( ! $product || is_wp_error( $product )) {
        return false;
    }

    $product_info = array(
        'id'            => $product->get_id(),
        'title'         => $product->get_name(),
        'permalink'     => get_permalink($product->get_id()),
        'thumbnail_url' => get_the_post_thumbnail_url($product->get_id(), 'thumbnail'),
        'sale_price'    => $product->get_sale_price(),
        'regular_price' => $product->get_regular_price(),
        'rating'        => get_post_meta($review_id, '_review_rating', true),
        'campaign'      => get_post_meta( $review_id, '_campaign_id', true ),
    );

    return $product_info;
}

function wbr_custom_pagination($total_pages, $paged) {
    $big = 999999999; // need an unlikely integer
    
    if ($total_pages > 1) {
        $pages = paginate_links( array(
            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format'    => '?paged=%#%',
            'current'   => $paged,
            'total'     => $total_pages,
            'type'      => 'array',
            'prev_text' => '←',
            'next_text' => '→',
        ) );

        if ( is_array( $pages ) ) {
            echo '<div class="wd-loop-footer products-footer">';
            echo '<nav class="woocommerce-pagination wd-pagination">';
            echo '<ul class="page-numbers">';
            foreach ( $pages as $page ) {
                echo '<li>' . $page . '</li>';
            }
            echo '</ul>';
            echo '</nav>';
            echo '</div>';
        }
    }
}

function wbr_get_svg_star_rating_icon( $rating = 5 ) {
    // Limit the rating between 1 and 5.
    $rating = min( 5, max( 1, (int) round( $rating ) ) );

    // SVG star icon.
    $star_svg = '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M8.00041 12.1733L3.29811 14.8055L4.34833 9.51994L0.391937 5.86121L5.7433 5.22672L8.00041 0.333344L10.2575 5.22672L15.6088 5.86121L11.6525 9.51994L12.7027 14.8055L8.00041 12.1733Z" fill="#FFAC4B"/>
        </svg>';

    // Output the filled stars.
    for ( $i = 0; $i < $rating; $i++ ) {
        echo '<span>' . $star_svg . '</span>';
    }

    // Output empty stars (if any).
    for ( $i = $rating; $i < 5; $i++ ) {
        echo '<span style="opacity: 0.2;">' . $star_svg . '</span>';
    }
}

function wbr_convert_english_date_to_bengali( $english_date ) {
    // Array to replace English month names with Bengali month names
    $months = [
        'January'   => 'জানুয়ারি',
        'February'  => 'ফেব্রুয়ারি',
        'March'     => 'মার্চ',
        'April'     => 'এপ্রিল',
        'May'       => 'মে',
        'June'      => 'জুন',
        'July'      => 'জুলাই',
        'August'    => 'আগস্ট',
        'September' => 'সেপ্টেম্বর',
        'October'   => 'অক্টোবর',
        'November'  => 'নভেম্বর',
        'December'  => 'ডিসেম্বর'
    ];
    
    // Convert the English date into the desired format (e.g., "12 August 2024")
    $formatted_date = date( 'j F Y', strtotime( $english_date ) );

    // Replace the English month names with Bengali month names
    foreach ( $months as $english => $bengali ) {
        $formatted_date = str_replace( $english, $bengali, $formatted_date );
    }

    // Replace English digits with Bengali digits
    $formatted_date = wbr_english_to_bengali( $formatted_date );

    return $formatted_date;
}
