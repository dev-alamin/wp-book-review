<?php 
get_header(); ?>
<div class="sing-review-campaign-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="top-left single-top">
                    <div class="thumb">
                        <?php the_post_thumbnail( 'large' ); ?>
                        <div class="desc">
                            <?php the_title( '<h2>', '</h2>' ); ?>
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </div>
                <?php
                    $last_submission_date     = carbon_get_post_meta(get_the_ID(), 'last_submission_date');
                    $has_result_declared      = carbon_get_post_meta(get_the_ID(), 'declare_capmaign_result');

                    // Ensure $last_submission_date is properly parsed as a DateTime object
                    if ($last_submission_date) {
                        $last_submission_date_obj = DateTime::createFromFormat('Y-m-d', $last_submission_date);
                    } else {
                        $last_submission_date_obj = false; // Handle case where date is not set
                    }

                    $today_date_obj = new DateTime();

                    // Check if date objects are valid before comparison
                    if ($last_submission_date_obj && $last_submission_date_obj < $today_date_obj && $has_result_declared) {
                        include __DIR__ . '/views/single/single-campaign-winner.php';
                    }
                ?>

                <div class="content">
                    <?php the_content(); ?>
                </div>
            </div>
        <div class="col-lg-5">
            <div class="single-top review-campaign-meta-info">
                <div class="join-cta single-meta">
                    <a href="/login">Join FajrFair to Enter</a>
                    <p>Already have a FajrFair account? <a href="/login">Login</a></p>
                </div>
                <div class="single-meta prize-details">
                    <div class="icon">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <?php 
                    $prizes = carbon_get_post_meta( get_the_ID(), 'prizes' );
                    if ( ! empty( $prizes ) ) :
                    ?>
                        <ul>
                            <?php foreach ( $prizes as $prize ) : ?>
                                <li><?php echo wp_kses_post( $prize['prize_name'] ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <?php include __DIR__ . '/views/single/single-campaign-time-table.php'; ?>
            </div>
        </div>
    </div>
</div>
<div class="submission-heading">
    <h2>Latest submissions</h2>
    <a href="#">Explore all</a>
</div>

<?php 
$current_post_slug = get_post_field('post_name', get_the_ID());
$args = array(
    'post_type' => 'review',
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'campaign_review',
            'field'    => 'slug',
            'terms'    => $current_post_slug,
        ),
    ),
    'posts_per_page' => 8,
);

$query = new WP_Query($args);

// Check if there are any posts to display
if ($query->have_posts()) : ?>
<div class="last-submission-container">
    <div class="row">
    <?php while ($query->have_posts()) : $query->the_post(); 
    $author_id     = get_the_author_meta('ID');
    $author_name   = get_the_author_meta('display_name');
    $author_avatar = get_avatar_url($author_id, ['size' => 80]);
    $post_time     = human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago';
    ?>

        <div class="col-12 col-lg-3 col-md-4 col-sm-6">
            <div class="last-submission-wrap">
                <div class="post-image">
                    <a href="<?php the_permalink(); ?>">
                       <?php the_post_thumbnail('medium'); ?>
                    </a>
                </div>
                <div class="post-info">
                    <h2><a href="<?php the_permalink(); ?>"><?php echo esc_html( wp_trim_words( get_the_title(get_the_ID()), 6, '...' ) ); ?></a></h2>
                    <?php the_excerpt(); ?>
                </div>
                <div class="author">
                    <div class="author-img">
                        <a href="<?php echo get_author_posts_url($author_id); ?>"><img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>"></a>
                    </div>
                    <div class="author-info">
                        <h4><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo esc_html( ucwords( $author_name ) ); ?></a></h4>
                        <p><?php echo esc_html($post_time); ?> in <?php the_category(', '); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
       </div>
</div>
<?php else :
    echo '<p>No reviews found for this campaign.</p>';
endif; 

// Restore original post data
wp_reset_postdata();

?>

<div class="book-review-campaign-heading campaign-single">
    <div class="heading">
        <h3><a href="#">Open challenges</a></h3>
        <p>Challenges you can enter now for a chance to win.</p>
    </div>
</div>
<?php 
// Query to retrieve all products
$campaign_query = new WP_Query(array(
    'post_type'      => 'review-campaign',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => array(
        array(
            'key'     => '_last_submission_date',
            'value'   => date('Y-m-d'),
            'compare' => '>=',
            'type'    => 'DATE'
        )
    )
));

if ($campaign_query->have_posts()) { ?>
        <div class="book-review-campaign-wrapper">
        <?php 
            while ($campaign_query->have_posts()) {
                $campaign_query->the_post(); ?>
                    <div class="card">
                        <div class="card-banner" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ) ?>)">
                            <div class="category-tag">
                                <svg width="35px" height="20px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                                    <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                                </svg>
                            </div>
                            <div class="card-body">
                                <h2 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <p class="blog-description"><?php echo wp_trim_words( wp_kses_post( get_the_content(get_the_ID() ) ), 15, '' );?></p>
                            </div>
                        </div>
                        <div class="item-price">
                            <?php
                            $prizes = carbon_get_post_meta( get_the_ID(), 'prizes' );
                            if ( ! empty( $prizes ) ) : ?>
                                <div class="price"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="16" class="css-1ug5ziw-ChallengeTile"><path d="M8 13.5v-3m-2 3h4a2 2 0 012 2H4a2 2 0 012-2zm6-12h3v3c0 .796-.316 1.559-.879 2.121A2.996 2.996 0 0112 7.5m-8-6H1v3c0 .796.316 1.559.879 2.121A2.996 2.996 0 004 7.5" fill="none" stroke="#fff"></path><path d="M4 .5h8v6a3.995 3.995 0 01-1.172 2.828 3.995 3.995 0 01-5.656 0A3.995 3.995 0 014 6.5v-6z" fill="none" stroke="#fff"></path></svg>
                                    <?php echo wp_kses_post( $prizes[0]['prize_name'] ); ?>
                                </div>
                            <?php endif; ?>
                            <?php if( ! empty( wbr_get_campaign_days_left( get_the_ID() ) ) ): ?>
                                <div class="price-time"><svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" class="css-1jdzpf4-TimeRemaining"><path d="M8 15A7 7 0 108 1a7 7 0 000 14z" fill="none" stroke="#fff"></path><path d="M8 4v4h4" fill="none" stroke="#fff"></path></svg>
                                    <?php echo esc_html( wbr_get_campaign_days_left( get_the_ID() ) ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>            
            <?php }
            ?>
        </div>
    <?php 
}
wp_reset_postdata();
?>
<?php get_footer();