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

$campaign_posts = new WP_Query( [
    'post_type'      => 'review',
    'posts_per_page' => -1,
    'author'         => $author_id,
    'meta_query'     => [
            [
                'key'     => '__review_winner_option',
                'value'   => wbr_campaign_positions(),
                'compare' => 'IN',
            ]
        ],
    'meta_key' => '__review_winner_option',
    'order'    => 'ASC',
    'orderby'  => 'meta_value_num',
] );
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main container" role="main">
        <?php include __DIR__ . '/author/author-profile.php'; ?>
        <hr>
        <?php if( is_user_logged_in() && get_current_user_id() == $author_id ): ?>
            <?php include __DIR__ . '/author/author-review-table.php'; ?>
        <?php endif; ?>

        <div class="author-reviews">
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $review_posts_args = array(
            'post_type'      => 'review',
            'author'         => $author_id,
            'posts_per_page' => 6,
            'paged'          => $paged,
        );

        $review_posts = new WP_Query($review_posts_args);

        if ($review_posts->have_posts()) :
            echo '<div class="container mt-3">';
            echo '<div class="row" id="reviews-container">';

            // Display the page header
            ?>
            <div class="page-header">
                <h2 class="page-title"><?php printf(__('Reviews by %s', 'textdomain'), get_the_author()); ?></h2>
            </div><!-- .page-header -->
            <?php
            $duration = 1; 
            $delay = 0.6;
            // Loop through the posts
            while ($review_posts->have_posts()) :
                $review_posts->the_post();
                ?>
                    <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="<?php echo $duration; ?>s" data-wow-delay="<?php echo $delay ; ?>s">
                        <?php
                            wbr_output_review_card(get_the_ID());
                        ?>
                    </div>
                <?php
                $duration += 0.3;
                $delay += 0.3;
            endwhile;

            echo '</div>'; // Close .row
            echo '</div>'; // Close .container
            wbr_custom_pagination( $review_posts->max_num_pages, $paged);
            wp_reset_postdata();
        else :
            echo '<p>' . __('No reviews found.', 'textdomain') . '</p>';
        endif;
        ?>

        </div>
        <?php
        $post_query_args = array(
            'author'         => $author_id,
            'post_type'      => 'post',
            'posts_per_page' => 8,
            'post_status'    => 'publish'
        );

        $post_query = new WP_Query( $post_query_args );

        if( $post_query->have_posts() ): ?>
        <hr>
        <div class="container">
            <div class="row">
            <h2>Posts By <?php the_author(); ?></h2>
            </div>
            <div class="row">

            <?php
            while( $post_query->have_posts() ) {
                $post_query->the_post();
                echo '<div class="col-lg-4 mb-5">';
                    echo '<div class="border bg-light p-3">';
                    if( has_post_thumbnail() ) {
                        the_post_thumbnail( 'full' );
                    }
                    echo '<p class="mt-2">' . get_the_date('j F, Y') . '</p>';
                    the_title( '<a href="'. get_permalink() . '"><h2>', '</h2></a>' );
                    the_excerpt();

                    echo '<a class="p-2" style="background:var(--wd-primary-color)" href="'. get_permalink() . '">' . 'Read more</a>';
                    echo '</div>';
                echo '</div>';
            }
        wbr_custom_pagination( $post_query->max_num_pages, $paged);
        wp_reset_postdata(); // Reset query data
        ?>
        </div>
        </div>
        <?php endif; ?>

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php
get_footer();