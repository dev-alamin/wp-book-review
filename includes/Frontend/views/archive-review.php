<?php
get_header();
$sliders = carbon_get_theme_option( 'wbr_archive_slider' );

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

if( $paged == 1 ) :
$archive_featured_review = array (
    'post_type'      => 'review',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'orderby'        => 'rand',
    'order'          => 'ASC',
    'meta_key'       => ['_wbr_is_top_featured_review', '_wbr_is_featured_review'],
    'meta_value'     => 'yes', 
);

$featured_rev = new WP_Query($archive_featured_review);
$options      = get_option( 'wbr_archive_promo_options' );
?>

<div class="loaderify">
    <div id="loadify">
        <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/loader.gif'; ?>" class="background-bg" />
    </div>
</div>

<?php if( ! empty( $sliders ) ): ?>
<div class="wbr-archive-page-container">
    <div class="review__slider-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="wbr-archive-slider">

                    <?php                     
                    if ( ! empty( $sliders ) ) : 
                        foreach ( $sliders as $slider ) :
                            $slider_image       = wp_get_attachment_image_url( $slider['slider_image'], 'full' );
                            $slider_heading     = $slider['slider_heading'];
                            $slider_button_text = $slider['slider_button_text'];
                            $slider_button_link = $slider['slider_button_link'];
                    ?>
                    
                    <div class="wbr-archive-slider-single">
                       <img src="<?php echo esc_url( $slider_image ); ?>" class="background-bg" />
                       <div class="container">
                            <div class="slider-content">
                                <h2><?php echo esc_html( $slider_heading ); ?></h2>
                                <a href="<?php echo esc_url( $slider_button_link ); ?>">
                                    <?php echo esc_html( $slider_button_text ); ?>
                                </a>
                            </div>
                       </div>
                    </div>

                    <?php 
                        endforeach; 
                    endif;
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- book review -->
<div class="book-review-lists">
    <div class="container">
        <div class="book-review-top">
            <h3><?php echo esc_html_e( 'ফিচারড রিভিউ','' ); ?></h3>
            <a class="btn-white" href="<?php echo esc_url('/all-review'); ?>">সব রিভিউ দেখুন</a>
        </div>
        <div class="book-review-list">
            <div class="row">

                    <?php
                    if ( $featured_rev->have_posts() ) {
                        while ( $featured_rev->have_posts() ) {
                            $featured_rev->the_post();

                            $product_id        = get_post_meta( get_the_ID(), '_product_id', true);
                            $product_thumbnail = get_the_post_thumbnail_url($product_id, 'thumbnail');
                            $authors           = get_the_terms( $product_id, 'authors');
                            $author_id         = get_post_field('post_author', get_the_ID());
                            $author_data       = get_userdata($author_id);
                            $author_url        = get_author_posts_url($author_id);
                            $author_avatar     = get_avatar($author_id, 96);
                            $author_name       = $author_data ? $author_data->display_name : 'Anonymous';
                            $review_rating     = get_post_meta( get_the_ID(), '_review_rating', true );
                            //wbr_output_review_card(get_the_ID());
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="book-review-card mb-5">
                                    <div class="book-review-thumbnail">
                                         <?php the_post_thumbnail('full'); ?>
                                        <div class="book-list">
                                            <a href="<?php echo esc_url( get_the_permalink( $product_id ) ); ?>">
                                                <img src="<?php echo esc_url( $product_thumbnail ); ?>" alt="<?php esc_attr( get_the_title( $product_id ) ); ?>" />
                                            </a>
                                            <div class="book-list-content">
                                               <a href="<?php echo esc_url( get_the_permalink( $product_id ) ); ?>">
                                                    <h4><?php echo esc_html( get_the_title( $product_id ) ); ?></h4>
                                               </a>
                                                <p>
                                                <?php if( ! empty( $authors ) ):
                                                foreach ( $authors as $author ): ?>
                                                <?php echo esc_html( wp_trim_words( $author->name, '5', '...') ); ?>
                                                <?php endforeach;
                                                    endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="book-user-review">
                                        <?php echo get_avatar( $author_id, 96, '', '', ); ?>
                                        <div class="book-user-info">
                                            <h4><a href="<?php echo esc_url($author_url); ?>"><?php echo esc_html( strtoupper( $author_name ) ); ?></a></h4>
                                            <p> <?php
                                            printf( esc_html__( 'Posted %s ago', 'wbr' ),
                                                human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) )
                                            );
                                            ?>
                                            </p>
                                        </div>
                                        <div class="book-user-star">
                                           <?php wbr_get_svg_star_rating_icon( $review_rating ); ?>
                                        </div>
                                    </div>
                                    <div class="book-review-content">
                                        <a class="review-title" href="<?php the_permalink(); ?>"><?php the_title( '<h4>', '</h4>' ); ?></a>
                                        <p>  <?php echo esc_html( wp_trim_words( get_the_content(), '55', '' ) ); ?></p>
                                        <a href="<?php the_permalink(); ?>"><?php esc_html_e( 'সম্পূর্ণ রিভিউ পড়ুন ', 'wbr' ); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?
                        }
                        wp_reset_postdata();
                    } else {
                        esc_html_e('No review found.', 'wpr');
                    }
                    ?>
            </div>
        </div>
    </div>
</div>
<!-- end book review -->
<?php if ( carbon_get_theme_option( 'wbr_post_review_show' ) ) : ?>
<!-- post review -->
<div class="post-a-review">
    <div class="container">
        <div class="post-a-review-wrapper wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
            <div class="row">
                <div class="col-lg-4">
                    <div class="post-a-review-wrapper-item">
                        <h3><?php echo esc_html( carbon_get_theme_option( 'wbr_post_review_heading' ) ); ?></h3>
                        <p><?php echo esc_html( carbon_get_theme_option( 'wbr_post_review_subheading' ) ); ?></p>
                        <a href="<?php echo esc_url( carbon_get_theme_option( 'wbr_post_review_button_link' ) ); ?>" class="btn-white">
                            <?php echo esc_html( carbon_get_theme_option( 'wbr_post_review_button_text' ) ); ?>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <h4 class="lead-text-one font-weight-bold text-white"><?php esc_html_e( 'কেন রিভিউ পোষ্ট করবেন', 'wbr' ); ?></h4>
                    <ul>
                        <?php
                        $reasons = carbon_get_theme_option( 'wbr_post_review_reasons' );
                        if ( ! empty( $reasons ) ) :
                            foreach ( $reasons as $reason ) :
                                $reason_text = $reason['reason_text'];
                                $reason_icon = wp_get_attachment_image_url( $reason['reason_icon'], 'full' );
                        ?>
                            <li class="text-white lead-text-one">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11.0026 16L18.0737 8.92893L16.6595 7.51472L11.0026 13.1716L8.17421 10.3431L6.75999 11.7574L11.0026 16Z" fill="white"></path>
                            </svg>
                                <?php echo esc_html( $reason_text ); ?>
                            </li>
                        <?php 
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <?php 
                    $promo_image = wp_get_attachment_image_url( carbon_get_theme_option( 'wbr_post_review_promo_image' ), 'full' );
                    if ( $promo_image ) : ?>
                        <img src="<?php echo esc_url( $promo_image ); ?>" class="promo-image" />
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- end post review -->
<?php if ( carbon_get_theme_option( 'wbr_book_review_show' ) ) : ?>
<div class="book-review-price">
    <div class="container">

        <div class="book-review-wrapper">
            <div class="book-prize-left wow fadeInRight" data-wow-offset="100" data-wow-duration="1s" data-wow-delay=".3s">
                <img src="<?php echo esc_url( wp_get_attachment_image_url( carbon_get_theme_option( 'wbr_book_review_logo' ), 'full' ) ); ?>" class="prize-logo" />
                <h3><?php echo esc_html( carbon_get_theme_option( 'wbr_book_review_heading' ) ); ?></h3>
                <img src="<?php echo esc_url( wp_get_attachment_image_url( carbon_get_theme_option( 'wbr_book_review_identifier' ), 'full' ) ); ?>" class="prize-identifier" />
                <div class="prize-title">
                    <span><?php echo esc_html( carbon_get_theme_option( 'wbr_book_review_presented_text' ) ); ?></span>
                    <img src="<?php echo esc_url( wp_get_attachment_image_url( carbon_get_theme_option( 'wbr_book_review_presented_logo' ), 'full' ) ); ?>" class="prize-logo" />
                </div>
                <div class="btn-group">
                    <a href="<?php echo esc_url( carbon_get_theme_option( 'wbr_book_review_post_review_link' ) ); ?>" class="btn btn-style-rectangle btn-color-primary">
                        <?php echo esc_html( carbon_get_theme_option( 'wbr_book_review_post_review_button' ) ); ?>
                    </a>
                    <a href="<?php echo esc_url( carbon_get_theme_option( 'wbr_book_review_details_link' ) ); ?>" class="btn-white">
                        <?php echo esc_html( carbon_get_theme_option( 'wbr_book_review_details_button' ) ); ?>
                    </a>
                </div>
            </div>

            <div class="book-prize-right wow fadeInLeft" data-wow-offset="100" data-wow-duration="1s" data-wow-delay=".8s">
                <div class="prize-money-time">
                    <div class="item">
                        <p>সর্বমোট প্রাইজ মানি</p>
                        <h4><?php echo esc_html( carbon_get_theme_option( 'wbr_book_review_prize_money' ) ); ?></h4>
                    </div>
                    <div class="item">
                        <p>শেষ সময়</p>
                        <h4><?php echo esc_html( carbon_get_theme_option( 'wbr_book_review_deadline' ) ); ?></h4>
                    </div>
                </div>
                <div class="time-remaining">
                    <p>সময় বাকি আছে</p>

                    <div class="tick" data-did-init="handleTickInit">
                       <div data-repeat="true"
                            data-layout="horizontal center fit"
                            data-transform="preset(d, h, m, s) -> delay">
                           <div class="tick-group">
                               <div data-key="value"
                                    data-repeat="true"
                                    data-transform="pad(00) -> split -> delay">
                                   <span data-view="text"></span>
                               </div>
                               <span data-key="label"
                                     data-view="text"
                                     class="tick-label"></span>
                           </div>
                       </div>
                   </div>

                    <script>
                        function handleTickInit(tick) {
                            var targetDate = '<?php echo esc_js( carbon_get_theme_option( 'wbr_book_review_countdown_target' ) ); ?>';
                            Tick.count.down(targetDate).onupdate = function(value) {
                                tick.value = value;
                            };
                        }
                    </script>
                </div>
            </div>

        </div>

    </div>
</div>
<?php endif; ?>

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
}
?>

<div class="wbr-archive-page-leaderboard section-padding wbr-leaderboard-page-cls">
    <div class="container">
        <div class="leaderboard-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="leaderboard-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                        <h2>জানুয়ারি মাসের লিডারবোর্ড</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="winner-review single-leaderboard wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                        <h4 class="leaderboard-subtitle">ভালো রিভিউ</h4>
                        <?php $most_liked_reviews = wbr_get_most_commented_posts( 'review' ); ?>
    
                        <ul class="leaderboard-list">
                            <?php foreach ($most_liked_reviews as $result): 
                                $product = get_post_meta( $result->ID, '_product_id', true );
                                ?>
                                <li>
                                    <div class="product-left">
                                        <?php if (has_post_thumbnail($result->ID)): ?>
                                        <a href="<?php echo esc_url(get_permalink($result->ID)); ?>">
                                            <img src="<?php echo esc_url(get_the_post_thumbnail_url($result->ID, 'thumbnail')); ?>" alt="<?php echo esc_attr($result->post_title); ?>">
                                        </a>
                                    <?php endif; ?>
                            
                                    <div class="book-review-bk-info">
                                        <a href="<?php echo esc_url(get_permalink($result->ID)); ?>">
                                           <strong> <?php echo esc_html(wp_trim_words($result->post_title, 7)); ?></strong>
                                        </a>
                                        <?php if( $product ): ?>

                                        <p class="author-title">
                                            <?php 
                                            $author_id   = get_post_field('post_author', $result->ID );
                                            $author_data = get_userdata($author_id);
                                            $author_name = $author_data ? $author_data->display_name : 'Anonymous';
                                            echo esc_html( ucwords( $author_name ) );
                                            ?>
                                        </p>
                                        
                                        <div class="book-user-star">
                                            <?php wbr_get_svg_star_rating_icon(); ?>
                                        </div>

                                    </div>
                                    </div>

                                    <div class="book-list">
                                        <?php 
                                        $book_info = wbr_get_product_info_by_review( $result->ID );
                                        $book_cover = $book_info['thumbnail_url'];
                                        $authors = get_the_terms($book_info['id'], 'authors');

                                        ?>
                                        <img src="<?php echo esc_url( $book_cover ); ?>" />
                                        <div class="book-list-content">
                                            <h4><?php echo esc_attr( $book_info['title'] ); ?></h4>
                                            <p>
                                            <?php if( ! empty( $authors ) ):
                                                foreach ( $authors as $author ): ?>
                                                <?php echo esc_html( wp_trim_words( $author->name, '5', '...') ); ?>
                                            <?php endforeach; 
                                                endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="winner-review-books single-leaderboard wow fadeInUp" data-wow-duration="1s" data-wow-delay=".8s">
                        <?php 
                        $results = wbr_get_top_reviewed_books();
                        if ( $results ) {
                            echo '<h4 class="leaderboard-subtitle">ভালো বই সমূহ</h4>';
                            echo '<ul class="leaderboard-list">';
                                foreach ($results as $result):
                                $review_id         = $result->id;
                                $product_id        = get_post_meta($review_id, '_product_id', true);
                                $product_thumbnail = get_the_post_thumbnail_url($product_id, 'thumbnail');
                                $term_link         = get_the_permalink($product_id);
                                $term              = get_term($result->term_id, 'review_book');
                                ?>
                                <?php if ( $term && ! is_wp_error( $term ) ): ?>
                                    <li>
                                        <a href="<?php echo esc_url($term_link); ?>">
                                            <div class="archive-review-item">
                                                <div class="book-reviews-left">
                                                    <div class="thumbnail-title-wrapper">
                                                        <?php if ($product_thumbnail): ?>
                                                            <img src="<?php echo esc_url($product_thumbnail); ?>" alt="<?php echo esc_attr(get_the_title($product_id)); ?>">
                                                        <?php endif; ?>
                                                        <?php echo esc_html(wp_trim_words($result->name, 7)); ?> 
                                                    </div>
                                                    <span class="book-authors">
                                                        <?php
                                                        $authors = wp_get_post_terms($product_id, 'authors');

                                                        if ( $authors && ! is_wp_error( $authors ) ) {
                                                            
                                                            $author_names = array_map( function( $author ) {
                                                                return $author->name;
                                                            }, $authors);

                                                            echo esc_html( wp_trim_words( implode( ', ', $author_names ), '5', '...' ) );
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                                <div class="total-review">
                                                    <span>
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M8.00041 12.1733L3.29811 14.8055L4.34833 9.51994L0.391937 5.86121L5.7433 5.22672L8.00041 0.333344L10.2575 5.22672L15.6088 5.86121L11.6525 9.51994L12.7027 14.8055L8.00041 12.1733Z" fill="#FFAC4B"></path>
                                                        </svg>
                                                    </span>
                                                    <span>
                                                        <?php
                                                            $average_rating = wpr_get_total_review_and_average( $product_id );
                                                            echo esc_html( wbr_english_to_bengali( $average_rating['average_rating'] ) ); 
                                                        ?>
                                                    </span>
                                                    <span>• <?php echo esc_html( wbr_english_to_bengali( $result->review_count ) ); ?> রিভিউ </span>
                                                </div>
                                            </div>
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
</div>

<?php 
$featured_writer_args  = array (
    'post_type'      => 'review',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => 'rand',
    'order'          => 'ASC',
    'meta_key'       => [ '_wbr_is_featured_review'],
    'meta_value'     => 'yes', 
);

$featured_writer = new WP_Query( $featured_writer_args );
?>
<!-- recent featured review -->
<div class="recent-featured-review">
    <div class="container">
        <div class="book-review-top">
            <h3>ফিচারড রিভিউ রাইটার</h3>
            <a class="btn-white" href="#">সব রিভিউ দেখুন</a>
        </div>
       <div class="recent-slider-wrapper">
            <div class="recent-prev-btn">
                <button type="button">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/>
                        <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/>
                    </svg>
                </button>
            </div>
            <div class="recent-next-btn">
                <button type="button">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/>
                        <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/>
                    </svg>
                </button>
            </div>
            <div class="recent-featured-review-list">
                <?php if ( $featured_writer->have_posts() ) : ?>
                    <?php while ( $featured_writer->have_posts() ) : $featured_writer->the_post(); ?>
                        <!-- start feature review card -->
                        <div class="featured-review-card">
                            <?php 
                            // Fetch author avatar
                            $author_id     = get_the_author_meta('ID');
                            $author_avatar = get_avatar_url( $author_id, ['size' => '150'] );
                            $review_count  = count_user_posts($author_id, 'review');
                            ?>

                            <img class="user-image" src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php the_author(); ?>" />
                            <h4 class="author-title"><?php the_author(); ?></h4>
                            <p><?php echo $review_count; ?> টি রিভিউ দিয়েছেন</p>
                            <p class="recent-review-title">সাম্প্রতিক রিভিউ</p>
                            <h5><?php the_title(); ?></h5>
                            <p class="post-date">Posted <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></p>

                            <div class="book-user-review">
                                <?php 
                                // Assuming you have custom meta fields for the book title and author
                                $product_id     = get_post_meta( get_the_ID(), '_product_id', true );
                                $book_title     = get_the_title( $product_id );
                                $authors        = get_the_terms( $product_id, 'authors' );
                                $post_thumbnail = get_the_post_thumbnail_url( $product_id );
                                ?>

                                <img src="<?php echo esc_url( $post_thumbnail ); ?>" alt="<?php echo esc_attr( $book_title ); ?>" />
                                <div class="book-user-info">
                                    <h4><?php echo esc_html( $book_title ); ?></h4>
                                    
                                    <p><?php if( ! empty( $authors ) ):
                                        foreach ( $authors as $author ): ?>
                                        <?php echo esc_html( wp_trim_words( $author->name, '5', '...') ); ?>
                                        <?php endforeach;
                                            endif; ?>
                                    </p>
                                </div>
                                <div class="book-user-star">
                                    <!-- Display a star rating (assuming you have a rating system) -->
                                    <?php
                                    $review_rating = get_post_meta( get_the_ID(), '_review_rating', true );
                                    wbr_get_svg_star_rating_icon($review_rating);
                                    ?>
                                </div>
                            </div>

                            <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="view-profile">প্রফাইল দেখুন</a>
                        </div>
                        <!-- end feature review card -->
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
       </div>
    </div>
</div>
<!-- end recent featured review -->

<?php
// Step 1: Query the reviews where '_wbr_is_featured_review' is set to 'yes'
$featured_review_args = array (
    'post_type'      => 'review',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => 'rand',
    'order'          => 'ASC',
    'meta_key'       => '_wbr_is_featured_review',
    'meta_value'     => 'yes',
    'fields'         => 'ids', // Only fetch the IDs of the reviews to save memory
);

$featured_reviews = new WP_Query( $featured_review_args );

// Step 2: Collect the product IDs linked to these reviews and ensure uniqueness
$product_ids = array();
if ( $featured_reviews->have_posts() ) {
    foreach ( $featured_reviews->posts as $review_id ) {
        $product_id = get_post_meta( $review_id, '_product_id', true );
        if ( $product_id ) {
            $product_ids[] = $product_id;
        }
    }
}

// Step 3: Make sure the product IDs are unique
$product_ids = array_unique( $product_ids );

// Step 4: If there are any unique product IDs, query the products (books)
if ( !empty( $product_ids ) ) {
    $featured_book_args = array(
        'post_type'      => 'product', // Assuming 'product' is the post type for books
        'post_status'    => 'publish',
        'posts_per_page' => 4, // Match the number of reviews
        'post__in'       => $product_ids, // Only query the products with the collected unique IDs
        'orderby'        => 'post__in', // Maintain the same order as the product_ids array
    );

    $featured_books = new WP_Query( $featured_book_args );
}
?>

<!-- recent featured review -->
<div class="recent-featured-review">
    <div class="container">
        <div class="book-review-top">
            <h3>ফিচারড বই</h3>
            <a class="btn-white" href="#">সবগুলো দেখুন</a>
        </div>
        <div class="recent-slider-wrapper slider-arrow-center">
            <div class="arrow-prev-btn book-prev-btn">
                <button type="button">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> 
                        <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/> 
                        <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/> 
                    </svg>
                </button>
            </div>
            <div class="arrow-next-btn book-next-btn">
                <button type="button">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> 
                        <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/> 
                        <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/> 
                    </svg>
                </button>
            </div>
            <div class="featured-slider-book">

                <?php if ( $featured_books->have_posts() ) : ?>
                    <?php while ( $featured_books->have_posts() ) : $featured_books->the_post(); ?>
                        <?php 
                            $product_id     = get_post_meta( get_the_ID(), '_product_id', true );
                            $book_title     = get_the_title( $product_id );
                            $authors        = get_the_terms( $product_id, 'authors' );
                            $post_thumbnail = get_the_post_thumbnail_url( $product_id );
                            $rating         = get_post_meta( $product_id, '_average_rating', true );
                            $review_count   = get_post_meta( $product_id, '_review_count', true );
                        ?>
                        
                        <!-- start feature review card -->
                        <div class="featured-review-card wow fadeInUp" data-wow-offset="100" data-wow-duration="1s" data-wow-delay=".4s">
                            <a href="<?php echo esc_url( get_the_permalink( $product_id ) ); ?>">
                                <img class="book-image" src="<?php echo esc_url( $post_thumbnail ); ?>" alt="<?php echo esc_attr( $book_title ); ?>" />
                            </a>
                            <a href="<?php echo esc_url( get_the_permalink( $product_id ) ); ?>">
                                <h4 class="author-title"><?php echo esc_html( $book_title ); ?></h4>
                            </a>
                            <?php if ( $authors && ! is_wp_error( $authors ) ) : ?>
                                <?php foreach ( $authors as $author ) : ?>
                                    <p><?php echo esc_html( $author->name ); ?></p>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <div class="total-review">
                                <span>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.00041 12.1733L3.29811 14.8055L4.34833 9.51994L0.391937 5.86121L5.7433 5.22672L8.00041 0.333344L10.2575 5.22672L15.6088 5.86121L11.6525 9.51994L12.7027 14.8055L8.00041 12.1733Z" fill="#FFAC4B"></path>
                                    </svg>
                                </span>
                                <?php 
                                $review_rating = wpr_get_total_review_and_average( $product_id ); ?>
                                <span><?php echo esc_html( wbr_english_to_bengali( $review_rating['average_rating'] ) );  ?></span>
                                <span>• <?php echo esc_html(  wbr_english_to_bengali( $review_rating['total_reviews'] ) ); ?> রিভিউ</span> <!-- have to do -->
                            </div>
                        </div>
                        <!-- end feature review card -->
                    <?php endwhile; ?>
                <?php else : ?>
                    <p><?php esc_html_e( 'No featured books found.', 'webgen' ); ?></p>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>

            </div>
        </div>
    </div>
</div>
<!-- end recent featured review -->

<!-- recent featured review -->
<div class="recent-featured-review">
    <div class="container">
        <div class="book-review-top">
            <h3>ভিডিও রিভিউ</h3>
            <a class="btn-white" href="#">সবগুলো দেখুন</a>
        </div>
       <div class="recent-slider-wrapper slider-arrow-center">
            <div class="arrow-prev-btn video-prev-btn"><button type="button"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/> <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/> </svg></button></div>
            <div class="arrow-next-btn video-next-btn"><button type="button"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/> <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/> </svg></button></div>
            
            <div class="video-slider-review">

                <!-- start feature review card video -->
                <div class="featured-review-card-video">
                    
                    <div class="featured-review-card-inner">

                        <video controls="false">
                            <source src="<?php echo BOOK_REVIEW_ASSETS . '/images/book/video.mp4'; ?>" type="video/mp4">
                        </video>

                        <div class="video-overlay"></div>

                        <div class="play-pause-btn">
                            <button type="button" class="btn-play activated">                                
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 29.3334C8.63622 29.3334 2.66669 23.3638 2.66669 16.0001C2.66669 8.63628 8.63622 2.66675 16 2.66675C23.3638 2.66675 29.3334 8.63628 29.3334 16.0001C29.3334 23.3638 23.3638 29.3334 16 29.3334ZM14.1626 11.2195C14.075 11.1611 13.972 11.13 13.8667 11.13C13.5722 11.13 13.3334 11.3687 13.3334 11.6633V20.3369C13.3334 20.4422 13.3646 20.5451 13.423 20.6327C13.5863 20.8778 13.9175 20.9441 14.1626 20.7806L20.6678 16.4438C20.7263 16.4047 20.7766 16.3545 20.8156 16.2959C20.9791 16.0509 20.9128 15.7197 20.6678 15.5563L14.1626 11.2195Z" fill="white"/>
                                </svg>   
                                <span>Play</span> 
                            </button>
                            <button type="button" class="btn-pause">                                
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M360-320h80v-320h-80v320Zm160 0h80v-320h-80v320ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>   
                                <span>pause</span>
                            </button>
                        </div>
                    
                        <div class="book-user-review">
                        <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/review-image/book.png'; ?>" />
                            <div class="book-user-info">
                                <div class="user-bio-infor">
                                    <h4>Ferdaus Kabir</h4>
                                <div class="book-user-star">
                                <?php wbr_get_svg_star_rating_icon(); ?>

                                </div>
                                </div>

                                <p>Posted 2 days ago</p>
                            </div>

                            
        
                        </div>
                    </div>

                </div>
                <!-- end feature review card video -->

                <!-- start feature review card video -->
                <div class="featured-review-card-video">
                    
                    <div class="featured-review-card-inner">

                        <video controls="false">
                            <source src="<?php echo BOOK_REVIEW_ASSETS . '/images/book/video.mp4'; ?>" type="video/mp4">
                        </video>

                        <div class="video-overlay"></div>

                        <div class="play-pause-btn">
                            <button type="button" class="btn-play activated">                                
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 29.3334C8.63622 29.3334 2.66669 23.3638 2.66669 16.0001C2.66669 8.63628 8.63622 2.66675 16 2.66675C23.3638 2.66675 29.3334 8.63628 29.3334 16.0001C29.3334 23.3638 23.3638 29.3334 16 29.3334ZM14.1626 11.2195C14.075 11.1611 13.972 11.13 13.8667 11.13C13.5722 11.13 13.3334 11.3687 13.3334 11.6633V20.3369C13.3334 20.4422 13.3646 20.5451 13.423 20.6327C13.5863 20.8778 13.9175 20.9441 14.1626 20.7806L20.6678 16.4438C20.7263 16.4047 20.7766 16.3545 20.8156 16.2959C20.9791 16.0509 20.9128 15.7197 20.6678 15.5563L14.1626 11.2195Z" fill="white"/>
                                </svg>   
                                <span>Play</span> 
                            </button>
                            <button type="button" class="btn-pause">                                
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M360-320h80v-320h-80v320Zm160 0h80v-320h-80v320ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>   
                                <span>pause</span>
                            </button>
                        </div>
                    
                        <div class="book-user-review">
                        <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/review-image/book.png'; ?>" />
                            <div class="book-user-info">
                                <div class="user-bio-infor">
                                    <h4>Ferdaus Kabir</h4>
                                <div class="book-user-star">
                                <?php wbr_get_svg_star_rating_icon(); ?>

                                </div>
                                </div>

                                <p>Posted 2 days ago</p>
                            </div>

                            
        
                        </div>
                    </div>

                </div>
                <!-- end feature review card video -->

                <!-- start feature review card video -->
                <div class="featured-review-card-video">
                    
                    <div class="featured-review-card-inner">

                        <video controls="false">
                            <source src="<?php echo BOOK_REVIEW_ASSETS . '/images/book/video.mp4'; ?>" type="video/mp4">
                        </video>

                        <div class="video-overlay"></div>

                        <div class="play-pause-btn">
                            <button type="button" class="btn-play activated">                                
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 29.3334C8.63622 29.3334 2.66669 23.3638 2.66669 16.0001C2.66669 8.63628 8.63622 2.66675 16 2.66675C23.3638 2.66675 29.3334 8.63628 29.3334 16.0001C29.3334 23.3638 23.3638 29.3334 16 29.3334ZM14.1626 11.2195C14.075 11.1611 13.972 11.13 13.8667 11.13C13.5722 11.13 13.3334 11.3687 13.3334 11.6633V20.3369C13.3334 20.4422 13.3646 20.5451 13.423 20.6327C13.5863 20.8778 13.9175 20.9441 14.1626 20.7806L20.6678 16.4438C20.7263 16.4047 20.7766 16.3545 20.8156 16.2959C20.9791 16.0509 20.9128 15.7197 20.6678 15.5563L14.1626 11.2195Z" fill="white"/>
                                </svg>   
                                <span>Play</span> 
                            </button>
                            <button type="button" class="btn-pause">                                
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M360-320h80v-320h-80v320Zm160 0h80v-320h-80v320ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>   
                                <span>pause</span>
                            </button>
                        </div>
                    
                        <div class="book-user-review">
                        <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/review-image/book.png'; ?>" />
                            <div class="book-user-info">
                                <div class="user-bio-infor">
                                    <h4>Ferdaus Kabir</h4>
                                <div class="book-user-star">
                                <?php wbr_get_svg_star_rating_icon(); ?>
                                </div>
                                </div>

                                <p>Posted 2 days ago</p>
                            </div>

                            
        
                        </div>
                    </div>

                </div>
                <!-- end feature review card video -->

                <!-- start feature review card video -->
                <div class="featured-review-card-video">
                    
                    <div class="featured-review-card-inner">

                        <video controls="false">
                            <source src="<?php echo BOOK_REVIEW_ASSETS . '/images/book/video.mp4'; ?>" type="video/mp4">
                        </video>

                        <div class="video-overlay"></div>

                        <div class="play-pause-btn">
                            <button type="button" class="btn-play activated">                                
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 29.3334C8.63622 29.3334 2.66669 23.3638 2.66669 16.0001C2.66669 8.63628 8.63622 2.66675 16 2.66675C23.3638 2.66675 29.3334 8.63628 29.3334 16.0001C29.3334 23.3638 23.3638 29.3334 16 29.3334ZM14.1626 11.2195C14.075 11.1611 13.972 11.13 13.8667 11.13C13.5722 11.13 13.3334 11.3687 13.3334 11.6633V20.3369C13.3334 20.4422 13.3646 20.5451 13.423 20.6327C13.5863 20.8778 13.9175 20.9441 14.1626 20.7806L20.6678 16.4438C20.7263 16.4047 20.7766 16.3545 20.8156 16.2959C20.9791 16.0509 20.9128 15.7197 20.6678 15.5563L14.1626 11.2195Z" fill="white"/>
                                </svg>   
                                <span>Play</span> 
                            </button>
                            <button type="button" class="btn-pause">                                
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M360-320h80v-320h-80v320Zm160 0h80v-320h-80v320ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>   
                                <span>pause</span>
                            </button>
                        </div>
                    
                        <div class="book-user-review">
                        <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/review-image/book.png'; ?>" />
                            <div class="book-user-info">
                                <div class="user-bio-infor">
                                    <h4>Ferdaus Kabir</h4>
                                <div class="book-user-star">
                                <?php wbr_get_svg_star_rating_icon(); ?>
                                </div>
                                </div>
                                <p>Posted 2 days ago</p>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end feature review card video -->

                <!-- start feature review card video -->
                <div class="featured-review-card-video">
                    <div class="featured-review-card-inner">
                        <video controls="false">
                            <source src="<?php echo BOOK_REVIEW_ASSETS . '/images/book/video.mp4'; ?>" type="video/mp4">
                        </video>
                        <div class="video-overlay"></div>
                        <div class="play-pause-btn">
                            <button type="button" class="btn-play activated">                                
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 29.3334C8.63622 29.3334 2.66669 23.3638 2.66669 16.0001C2.66669 8.63628 8.63622 2.66675 16 2.66675C23.3638 2.66675 29.3334 8.63628 29.3334 16.0001C29.3334 23.3638 23.3638 29.3334 16 29.3334ZM14.1626 11.2195C14.075 11.1611 13.972 11.13 13.8667 11.13C13.5722 11.13 13.3334 11.3687 13.3334 11.6633V20.3369C13.3334 20.4422 13.3646 20.5451 13.423 20.6327C13.5863 20.8778 13.9175 20.9441 14.1626 20.7806L20.6678 16.4438C20.7263 16.4047 20.7766 16.3545 20.8156 16.2959C20.9791 16.0509 20.9128 15.7197 20.6678 15.5563L14.1626 11.2195Z" fill="white"/>
                                </svg>   
                                <span>Play</span> 
                            </button>
                            <button type="button" class="btn-pause">                                
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M360-320h80v-320h-80v320Zm160 0h80v-320h-80v320ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>   
                                <span>pause</span>
                            </button>
                        </div>
                    
                        <div class="book-user-review">
                        <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/review-image/book.png'; ?>" />
                            <div class="book-user-info">
                                <div class="user-bio-infor">
                                    <h4>Ferdaus Kabir</h4>
                                <div class="book-user-star">
                                <?php wbr_get_svg_star_rating_icon(); ?>
                                </div>
                                </div>
                                <p>Posted 2 days ago</p>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end feature review card video -->

                <!-- start feature review card video -->
                <div class="featured-review-card-video">
                    
                    <div class="featured-review-card-inner">

                        <video controls="false">
                            <source src="<?php echo BOOK_REVIEW_ASSETS . '/images/book/video.mp4'; ?>" type="video/mp4">
                        </video>

                        <div class="video-overlay"></div>

                        <div class="play-pause-btn">
                            <button type="button" class="btn-play activated">                                
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 29.3334C8.63622 29.3334 2.66669 23.3638 2.66669 16.0001C2.66669 8.63628 8.63622 2.66675 16 2.66675C23.3638 2.66675 29.3334 8.63628 29.3334 16.0001C29.3334 23.3638 23.3638 29.3334 16 29.3334ZM14.1626 11.2195C14.075 11.1611 13.972 11.13 13.8667 11.13C13.5722 11.13 13.3334 11.3687 13.3334 11.6633V20.3369C13.3334 20.4422 13.3646 20.5451 13.423 20.6327C13.5863 20.8778 13.9175 20.9441 14.1626 20.7806L20.6678 16.4438C20.7263 16.4047 20.7766 16.3545 20.8156 16.2959C20.9791 16.0509 20.9128 15.7197 20.6678 15.5563L14.1626 11.2195Z" fill="white"/>
                                </svg>   
                                <span>Play</span> 
                            </button>
                            <button type="button" class="btn-pause">                                
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M360-320h80v-320h-80v320Zm160 0h80v-320h-80v320ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>   
                                <span>pause</span>
                            </button>
                        </div>
                    
                        <div class="book-user-review">
                        <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/review-image/book.png'; ?>" />
                            <div class="book-user-info">
                                <div class="user-bio-infor">
                                    <h4>Ferdaus Kabir</h4>
                                <div class="book-user-star">
                                    <?php wbr_get_svg_star_rating_icon(); ?>
                                </div>
                                </div>
                                <p>Posted 2 days ago</p>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end feature review card video -->
                
            </div>
       </div>
    </div>
</div>
<!-- end recent featured review -->

<?php 
endif; // End pagination condition

// if ( have_posts() ) {
//     echo '<div class="container mt-3 wbr-archive-page-cls mb-5">';
//     echo '<div class="row" id="reviews-container">';
//     $duration = 1; 
//     $delay = 0.6;
//     while ( have_posts() ) {
//         the_post();
//         ?>
<!-- //             <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="<?php // echo $duration; ?>s" data-wow-delay="<?php // echo $delay ; ?>s"> -->
                 <?php
//                     wbr_output_review_card( get_the_ID() );
//                 ?>
<!-- //             </div> -->
         <?php
//         $duration += 0.3;
//         $delay += 0.3;
//     }
//     echo '</div>';
//     global $wp_query;
//     $total_pages = $wp_query->max_num_pages;
//     $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
//     wbr_custom_pagination( $wp_query->max_num_pages, $paged);
//      echo '<div class="load-more-rev-container"><button id="load-more-reviews">Load More Reviews</button></div>';
//     echo '</div>';
// }

get_footer();
?>