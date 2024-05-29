<?php 
get_header(); 
$archive_featured_review = array(
    'post_type'      => 'review',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => 'rand',
    'order'          => 'ASC',
    'meta_key'       => ['_wbr_is_top_featured_review', '_wbr_is_featured_review'],
    'meta_value'     => 'yes', 
);

$featured_rev = new WP_Query($archive_featured_review);

$options = get_option('wbr_archive_promo_options');
?>
<div class="wbr-archive-page-container wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="slider">
                    <img src="<?php echo $options['archive_promo_slider_image']; ?>" alt="Fajr Fair Review banner">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wbr-archive-featured-promo section-padding wbr-archive-page-cls">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="archive-featured-review wow fadeInUp" data-wow-duration=".6s" data-wow-delay=".3s">
                    <?php                     
                    if ($featured_rev->have_posts()) {
                        echo '<div id="reviews-container">';
                        while ($featured_rev->have_posts()) {
                            $featured_rev->the_post();
                            wbr_output_review_card(get_the_ID());
                            break;
                        }
                        echo '</div>';
                        wp_reset_postdata();
                    } else {
                        esc_html_e('No review found.', 'wpr');
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="archive-promo-wrapper  wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                    <div class="title">
                        <h2><?php echo esc_html( $options['archive_promo_title'] ); ?></h2>
                    </div>
                    <div class="description">
                        <p><?php echo wp_kses_post( $options['archive_promo_description'] ); ?></p>
                    </div>
                    <div class="cta">
                        <a href="<?php echo esc_url( $options['archive_promo_cta_link'] ); ?>"><?php echo esc_html( $options['archive_promo_cta_text'] ); ?></a>
                    </div>
                    <div class="review-outcome">
                    <h4><?php echo esc_html( $options['archive_promo_list_heading'] ); ?></h4>
                        <ul>
                            <?php
                            // Explode list items and display as list items
                            $list_items = explode( PHP_EOL, $options['archive_promo_list_items'] );
                            foreach( $list_items as $list ) {
                                echo '<li>' . $list . '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Additional row for three posts -->
        <div class="row mt-5">
    <?php
    $count = 0;
    $duration = 1;
    $delay = 0.6;
    while ($featured_rev->have_posts()) {
        $featured_rev->the_post();
        if ($count < 3) { ?>
            <div class="col-lg-4 col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="<?php echo $duration; ?>s" data-wow-delay="<?php echo $delay; ?>ss">
                <?php wbr_output_review_card(get_the_ID()); ?>
            </div>
        <?php 
        } else {
            break; // Exit the loop if we have displayed three posts
        }
        $count++;     
        $duration += 0.3;
        $delay += 0.3;  
    }
    wp_reset_postdata();
    ?>
        </div>
    </div>
</div>

<?php
// Query to retrieve the latest review campaign post
$latest_campaign_args = array(
    'post_type'      => 'review-campaign',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => array(
        array(
            'key'     => '_last_submission_date',
            'value'   => date('Y-m-d'),
            'compare' => '>=',
            'type'    => 'DATE'
        )
    )
);

$latest_campaign_query = new WP_Query($latest_campaign_args);

if ($latest_campaign_query->have_posts()) {
    while ($latest_campaign_query->have_posts()) {
        $latest_campaign_query->the_post();
        $campaign_name            = carbon_get_post_meta(get_the_ID(), 'campaign_name' );
        $last_submission_date     = carbon_get_post_meta(get_the_ID(), 'last_submission_date' );
        $last_submission_date_obj = date_create($last_submission_date);
        $today_date_obj           = new DateTime();
    if ($last_submission_date_obj >= $today_date_obj) {
?>
<div class="wbr-featured-campaign-archive section-padding wbr-campaign-page-cls">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="campaign-benefit">
                    <h2><?php the_title( '<h2>', '</h2>'); ?></h2>
                    <?php  $prizes = carbon_get_post_meta( get_the_ID(), 'prizes' ); ?>
                    <h2><?php echo wp_kses_post( $prizes[0]['prize_name']); ?></h2>
                    <div class="featured-campaign-cta">
                        <a href="<?php echo get_permalink(); ?>">See more</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="fetured-campaign-info">
                    <h4>The last date of submission</h4>
                    <div class="featured-sub-last-date">
                        <?php echo date('Y/m/d', strtotime($last_submission_date)); ?> <!-- Format the date as 'Y/m/d' -->
                    </div>
                    <h2>Time remaining</h2>
                    <div class="timer">
                        <div class="day">0</div>
                        <div class="hour">0</div>
                        <div class="minutes">0</div>
                        <div class="second">0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }
?>

<script>
// Countdown timer
function updateCountdown(endDate) {
    var now = new Date();
    var timeLeft = endDate.getTime() - now.getTime();

    if (timeLeft < 0) {
        document.querySelector('.timer').innerHTML = 'Campaign ended';
        return;
    }

    var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    // Update countdown elements
    document.querySelector('.day').innerHTML = days + ' d';
    document.querySelector('.hour').innerHTML = hours + ' h';
    document.querySelector('.minutes').innerHTML = minutes + ' m';
    document.querySelector('.second').innerHTML = seconds + ' s';
}

// Set the countdown timer
var lastSubmissionDate = new Date("<?php echo date('Y/m/d', strtotime($last_submission_date)); ?>");
updateCountdown(lastSubmissionDate); // Update countdown immediately to avoid initial NaN
setInterval(function() {
    updateCountdown(lastSubmissionDate);
}, 1000);
</script>

<?php
    }
    wp_reset_postdata();
} else {
    // No review campaign post found
    echo 'No review campaign post found.';
}
?>

<div class="wbr-archive-page-leaderboard section-padding wbr-leaderboard-page-cls">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="leaderboard-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                    <h2>জানুয়ারি মাসের লিডারবোর্ড</h2>
                    <h4>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quasi, beatae!</h4>
                    <div class="description">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, autem eos 
                            similique itaque quam placeat porro sed doloribus modi a ex facere atque qui molestias, 
                            dolores accusantium, voluptates saepe optio tempora. Voluptate earum vitae repellendus itaque 
                            debitis necessitatibus nisi dolorum? Illum molestias suscipit aliquam asperiores nesciunt
                            quod corrupti, sequi velit.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="winner-review single-leaderboard wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                    <h4 class="leaderboard-subtitle">Great reviews</h4>
                    <?php $most_liked_reviews = wbr_get_most_commented_posts( 'review' ); ?>

                    <ul class="leaderboard-list">
                        <?php foreach ($most_liked_reviews as $result): 
                            $product = get_post_meta( $result->ID, '_product_id', true );
                            ?>
                            <li>
                                <?php if (has_post_thumbnail($result->ID)): ?>
                                    <a href="<?php echo esc_url(get_permalink($result->ID)); ?>">
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url($result->ID, 'thumbnail')); ?>" alt="<?php echo esc_attr($result->post_title); ?>">
                                    </a>
                                <?php endif; ?>
                        
                                <div class="book-review-bk-info">
                                    <a href="<?php echo esc_url(get_permalink($result->ID)); ?>">
                                        <?php echo esc_html(wp_trim_words($result->post_title, 7)); ?>
                                    </a>
                                    <?php if( $product ): ?>
                                    <a href="<?php echo esc_url( get_permalink( $product ) ); ?>">
                                        <?php echo esc_html( get_the_title( $product ) ); ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="winner-review-books single-leaderboard wow fadeInUp" data-wow-duration="1s" data-wow-delay=".8s">
                    <?php 
                    $results = wbr_get_top_reviewed_books();
                    if ( $results ) {
                        echo '<h4 class="leaderboard-subtitle">Great reviewed books</h4>';
                        echo '<ul class="leaderboard-list">';
                            foreach ($results as $result):
                            $review_id = $result->id;
                            $product_id = get_post_meta($review_id, '_product_id', true);
                            $product_thumbnail = get_the_post_thumbnail_url($product_id, 'thumbnail');
                            $term_link = get_the_permalink($product_id);
                        
                            $term = get_term($result->term_id, 'review_book');
                            ?>
                            <?php if ($term && !is_wp_error($term)): ?>
                                <li>
                                    <a href="<?php echo esc_url($term_link); ?>">
                                        <div class="thumbnail-title-wrapper">
                                            <?php if ($product_thumbnail): ?>
                                                <img src="<?php echo esc_url($product_thumbnail); ?>" alt="<?php echo esc_attr(get_the_title($product_id)); ?>">
                                            <?php endif; ?>
                                            <?php echo esc_html(wp_trim_words($result->name, 7)); ?> 
                                            <span class="review-count">(<?php echo esc_html($result->review_count); ?>)</span>
                                        </div>
                                        <span class="book-authors">
                                            <?php
                                            $authors = wp_get_post_terms($product_id, 'authors');
                                            if ($authors && !is_wp_error($authors)) {
                                                $author_names = array_map(function($author) {
                                                    return $author->name;
                                                }, $authors);
                                                echo esc_html(implode(', ', $author_names));
                                            }
                                            ?>
                                        </span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li><?php echo esc_html($result->name); ?> | Reviews: <?php echo esc_html($result->review_count); ?> | Error: Empty Term</li>
                            <?php endif; ?>
                        <?php endforeach; 
                        echo '</ul>';
                    } else {
                        echo 'No reviews found.';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
if ( have_posts() ) {
    echo '<div class="container mt-3 wbr-archive-page-cls">';
    echo '<div class="row" id="reviews-container">';
    $duration = 1; 
    $delay = 0.6;
    while ( have_posts() ) {
        the_post();
        ?>
            <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="<?php echo $duration; ?>s" data-wow-delay="<?php echo $delay ; ?>s">
                <?php
                    wbr_output_review_card( get_the_ID() );
                ?>
            </div>
        <?php
        $duration += 0.3;
        $delay += 0.3;
    }
    echo '</div>';
    the_posts_pagination();
    // echo '<div class="load-more-rev-container"><button id="load-more-reviews">Load More Reviews</button></div>';
    echo '</div>';
}

get_footer();
?>