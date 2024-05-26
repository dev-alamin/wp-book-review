<?php
/**
 * The template for displaying author archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package YourTheme
 */

get_header();
?>
<style>
    .review-post {
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
}

.campaign-details {
    display: flex;
    flex-direction: column;
}

.campaign-title,
.review-title {
    font-size: 18px;
    margin-bottom: 10px;
}

.campaign-title a,
.review-title a {
    text-decoration: none;
    color: #0073aa;
}

.campaign-title a:hover,
.review-title a:hover {
    text-decoration: underline;
}

.winner-position {
    color: #ff9800;
    font-weight: bold;
    margin-right: 5px;
}

.fa-trophy {
    color: #ff9800;
    margin-right: 5px;
}

.fa-pen {
    color: #0073aa;
    margin-right: 5px;
}

.review-title i,
.campaign-title i {
    margin-right: 8px;
    vertical-align: middle;
}

#reviews-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    min-height: 350px;
}

#reviews-table th,
#reviews-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

#reviews-table th {
    background-color: #f2f2f2;
}

#pagination {
    text-align: center;
    margin: 20px 0;
}

.pagination-button {
    background-color: #0073aa;
    color: #fff;
    border: none;
    padding: 10px 15px;
    margin: 0 5px;
    cursor: pointer;
}

.pagination-button:hover {
    background-color: #005177;
}
.wbr_author_review_pagination.current {
    background: var(--wd-primary-color);
    color: #fff;
}

</style>
<?php 
$author_id     = get_query_var('author');
$author_name   = get_the_author_meta('display_name', $author_id);
$join_date     = get_the_author_meta('user_registered', $author_id);
$author_bio    = get_the_author_meta('description', $author_id);
$review_count  = count_user_posts($author_id, 'review');
$author_avatar = get_avatar(get_the_author_meta('user_email', $author_id), 150);

$author_id = get_query_var('author');

$campaign_posts = new WP_Query( [
    'post_type' => 'review',
    'posts_per_page' => -1,
    'author' => $author_id,
    'meta_query' => [
        [
            'key'     => '__review_winner_option',
            'value'   => wbr_campaign_positions(),
            'compare' => 'IN',
        ]
    ]
] );
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main container" role="main">
            <div class="container">
                <div class="row">
                    <div class="author-profile">
                        <div class="author-avatar">
                            <?php echo $author_avatar; ?>
                            <div class="write-review-button">
                            <a href="<?php echo esc_url(home_url('/submit-review/')); ?>" class="btn btn-primary">Write a Review</a>
                        </div>
                        </div>
                        <div class="author-details">
                            <h2 class="author-name"><?php echo esc_html( ucwords( $author_name ) ); ?></h2>
                            <p class="join-date">Joined: <?php echo date('F j, Y', strtotime($join_date)); ?></p>
                            <?php if ($author_bio) : ?>
                                <p class="author-bio"><?php echo $author_bio; ?></p>
                            <?php endif; ?>
                            <h4 class="review-count">Total Reviews: <?php echo $review_count; ?></h4>
                            <div class="author-achivement mt-5">
                                <h2><?php echo esc_html( ucwords( $author_name . "'s" ) ); ?> Achivement</h2>
                                <?php 
                                while ($campaign_posts->have_posts()) {
                                    $campaign_posts->the_post();
                                
                                    $campaign_id = get_post_meta(get_the_ID(), '_campaign_id', true);
                                    $campaign    = get_post($campaign_id);
                                
                                    // Get campaign title
                                    $campaign_title  = $campaign ? get_the_title($campaign_id) : 'Campaign not found';
                                    $review_title    = get_the_title(get_the_ID());
                                    $winner_position = get_post_meta(get_the_ID(), '__review_winner_option', true);
                                
                                    echo '<div class="review-post">';
                                    echo '<div class="campaign-details">';
                                    echo '<div class="campaign-title"><i class="fa-solid fa-trophy"></i> ' . esc_html( ucwords( $winner_position ) ) . ' <a href="' . get_the_permalink($campaign_id) . '">' . esc_html($campaign_title) . '</a></div>';
                                    echo '<div class="review-title"><i class="fa-solid fa-pen"></i> <a href="' . get_permalink(get_the_ID()) . '">' . esc_html($review_title) . '</a></div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php if( is_user_logged_in() && get_current_user_id() == $author_id ): ?>

                    <?php endif; ?>
                </div>
            </div>
        <hr>
        
                    <?php if( is_user_logged_in() && get_current_user_id() == $author_id ): ?>
                        <?php 
                        $posts_per_page = 5;

                        $author_review_posts_args = array(
                            'post_type'      => 'review',
                            'author'         => $author_id,
                            'posts_per_page' => $posts_per_page,
                            'post_status'    => ['publish', 'pending', 'draft', 'trash', 'private', 'delete_request' ],
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        );
                        
                        $author_review_posts = new WP_Query($author_review_posts_args);
                        
                        if ( $author_review_posts->have_posts() ) {
                            echo '<div class="container mt-3 mb-5 bg-white pt-3">';
                            echo '<div class="row">';
                            echo '<div class="col-lg-12">';
                            echo '<h2>Your Post List - You can edit, request for delete. </h2>';
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
                                echo '<td><img width="100px" src="' . get_the_post_thumbnail_url(get_the_ID(), 'medium') . '"></td>';
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
                                echo '<a id="wbrDeleteRequestReview" data-id="' . esc_attr( $post_id ) . '" href="#"><span class="badge text-bg-danger">Delete</span></a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        
                            echo '</table>';
                        
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
                    endif;
                    ?>

        <div class="author-reviews">
        <?php
// Get the current page number
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Define query arguments
$review_posts_args = array(
    'post_type'      => 'review',
    'author'         => $author_id,
    'posts_per_page' => 6, // Set the number of posts per page
    'paged'          => $paged,
);

// Execute the query
$review_posts = new WP_Query($review_posts_args);

// Check if there are any posts to display
if ($review_posts->have_posts()) :
    echo '<div class="container mt-3">';
    echo '<div class="row" id="reviews-container">';

    // Display the page header
    ?>
    <header class="page-header">
        <h2 class="page-title"><?php printf(__('Reviews by %s', 'textdomain'), get_the_author()); ?></h2>
    </header><!-- .page-header -->
    <?php

    // Loop through the posts
    while ($review_posts->have_posts()) :
        $review_posts->the_post();
        echo '<div class="col-lg-4 col-sm-6 col-xs-12">';
        wbr_output_review_card(get_the_ID());
        echo '</div>';
    endwhile;

    echo '</div>'; // Close .row
    echo '</div>'; // Close .container

    // Display pagination
    echo '<div class="pagination">';
    echo paginate_links(array(
        'total'   => $review_posts->max_num_pages,
        'current' => $paged,
    ));
    echo '</div>';

    // Reset post data
    wp_reset_postdata();
else :
    // If no posts found, display a message
    echo '<p>' . __('No reviews found.', 'textdomain') . '</p>';
endif;
?>

        </div>
        <?php if( have_posts() ): ?>
        <hr>
        <h2>Posts By <?php the_author(); ?></h2>
        <?php do_action( 'woodmart_main_loop' ); ?>
        <?php endif; ?>

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php
get_footer();