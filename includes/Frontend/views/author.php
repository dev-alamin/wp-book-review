<?php
/**
 * The template for displaying author archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package YourTheme
 */

get_header();
$author_id     = get_query_var('author');
$author_name   = get_the_author_meta('display_name', $author_id);
$join_date     = get_the_author_meta('user_registered', $author_id);
$author_bio    = get_the_author_meta('description', $author_id);
$review_count  = count_user_posts($author_id, 'review');
$author_avatar = get_avatar(get_the_author_meta('user_email', $author_id), 150);
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main container" role="main">
            <div class="container">
                <div class="row">
                    <div class="author-profile">
                        <div class="author-avatar"><?php echo $author_avatar; ?></div>
                        <div class="author-details">
                            <h2 class="author-name"><?php echo esc_html( ucwords( $author_name ) ); ?></h2>
                            <p class="join-date">Joined: <?php echo date('F j, Y', strtotime($join_date)); ?></p>
                            <?php if ($author_bio) : ?>
                                <p class="author-bio"><?php echo $author_bio; ?></p>
                            <?php endif; ?>
                            <p class="review-count">Total Reviews: <?php echo $review_count; ?></p>
                        </div>
                    </div>
                    <div class="write-review-button">
                        <a href="<?php echo esc_url(home_url('/submit-review/')); ?>" class="btn btn-primary">Write a Review</a>
                    </div>
                </div>
            </div>
        <hr>

        <div class="author-reviews">
            <?php
            // Display posts from the 'review' custom post type by the author
            $author_id = get_query_var('author');
            $review_posts_args = array(
                'post_type' => 'review',
                'author'    => $author_id
            );
            $review_posts = new WP_Query($review_posts_args);

            if ($review_posts->have_posts()) :
                echo '<div class="container mt-3">';
                echo '<div class="row" id="reviews-container">';
                ?>
                <header class="page-header">
                    <h2 class="page-title"><?php printf(__('Reviews by %s', 'textdomain'), get_the_author()); ?></h2>
                </header><!-- .page-header -->

                <?php
                while ($review_posts->have_posts()) :
                    $review_posts->the_post();
                    echo '<div class="col-lg-4 col-sm-6 col-xs-12">';
                    wbr_output_review_card( get_the_ID() );
                    echo '</div>';
                    endwhile;
                echo '</div>';
                echo '</div>';
                // Reset post data
                wp_reset_postdata();

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