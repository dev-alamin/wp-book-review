<?php 
$posts_per_page = 10;

$author_review_posts_args = array(
    'post_type'      => 'review',
    'author'         => $author_id,
    'posts_per_page' => $posts_per_page,
    'post_status'    => ['publish', 'pending', 'draft', 'private', 'delete_request' ],
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$author_review_posts = new WP_Query($author_review_posts_args);

if ( $author_review_posts->have_posts() ) {
    echo '<div class="container mt-3 mb-5 bg-white pt-3 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">';
    echo '<div class="row">';
    echo '<div class="col-lg-12">';
    echo '<h2>Your Post List - You can edit, request for delete. </h2>';
    echo '<div class="book-review-table ">';
    echo '<table id="reviews-table">';
    echo '<tr>';
    echo '<th>#</th>';
    echo '<th>Review Title</th>';
    echo '<th>Thumbnail</th>';
    echo '<th>Book</th>';
    echo '<th>Date</th>';
    echo '<th> Status </th>';
    echo '<th>Actions</th>';
    echo '</tr>';

    $serial = 1;
    while ( $author_review_posts->have_posts() ) {
        $author_review_posts->the_post();
        $post_id = get_the_ID();
        $post_title = get_the_title();
        $post_date = get_the_date();
        $review_book = get_post_meta(get_the_ID(), '_product_id', true);
        $review_book_id = $review_book ? $review_book : '0';
        $post_statuses = wbr_get_post_status_badge_class( $post_id );

        echo '<tr>';
        echo '<td>' . esc_html($serial++) . '</td>';
        echo '<td><a href="'.get_the_permalink(get_the_ID()).'">' . esc_html(wp_trim_words($post_title, 8, '')) . '</a></td>';
        echo '<td><img width="50px" src="' . get_the_post_thumbnail_url(get_the_ID(), 'medium') . '"></td>';
        echo '<td>';
        if( $review_book_id && $review_book_id != 0 ) {
            echo '<a href="' . get_the_permalink($review_book_id) . '">' . esc_html(get_the_title($review_book_id)) . '</a>';
        }
        echo '</td>';
        echo '<td>' . esc_html($post_date) . '</td>';
        echo '<td><span class="badge '. esc_attr( $post_statuses ) . '">' . esc_html( ucwords( str_replace( '_', ' ', get_post_status( $post_id ) ) ) ) . '</span></td>';
        echo '<td>';
        if( get_post_status( $post_id ) == 'draft' ) {
            echo '<a class="me-2" href="' . esc_url( '/publish' ) . '"><span class="badge text-bg-info">Publish</span></a>';
        }
        echo '<a class="me-2" href="' . esc_url('/submit-review?reviewid=' . get_the_ID()) . '"><span class="badge text-bg-primary">Edit</span></a>';
        echo '<a href="#" class="wbrDeleteRequestReview" data-id="' . esc_attr( $post_id ) . '"><span class="badge text-bg-danger">Delete</span></a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '</div>;';

    $total_pages = $author_review_posts->max_num_pages;
    if ($total_pages > 1) {
        $class = 'wbr_author_review_pagination';
        echo '<div id="pagination">';
        for ($i = 1; $i <= $total_pages; $i++) {
            if( $i == 1 ) {
                $class = 'wbr_author_review_pagination current';
            }else{
                $class = 'wbr_author_review_pagination';
            }
            echo '<button class="'. $class .'" data-page="' . $i . '">' . $i . '</button>';
        }
        echo '</div>';
    }
    echo '</div></div></div>';
} else {
    echo 'No reviews found.';
}

wp_reset_postdata();