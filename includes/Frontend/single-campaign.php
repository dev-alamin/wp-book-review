<?php 
get_header(); ?>

<div class="sing-review-campaign-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="<?php echo site_url('/'); ?>">হোম</a>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.78105 8.00047L5.4812 4.70062L6.42401 3.75781L10.6667 8.00047L6.42401 12.2431L5.4812 11.3003L8.78105 8.00047Z" fill="#9A9D9D"/>
                            </svg>
                        </li>
                        <li>
                            <a href="<?php echo the_permalink(); ?>">ক্যাম্পেইন</a>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.78105 8.00047L5.4812 4.70062L6.42401 3.75781L10.6667 8.00047L6.42401 12.2431L5.4812 11.3003L8.78105 8.00047Z" fill="#9A9D9D"/>
                            </svg>
                        </li>
                        <li class="review-text">
                            <?php echo the_title(); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="single-campaign-wrapper-list">
                    <div class="top-left single-top wow fadeInUp" data-wow-duration=".8s" data-wow-delay=".4s">
                        <div class="review-campaign-thumbnail">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </div>

                        <div class="book-prize-left wow fadeInRight" data-wow-offset="100" data-wow-duration="1s" data-wow-delay=".3s">
                            <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/prize/logo.png'; ?>" class="prize-logo" />
                            <h3>বুক রিভিউ প্রতিযোগিতা</h3>
                            <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/prize/identifier.png'; ?>" class="prize-identifier" />
                            <div class="prize-title">
                                <span>নিবেদনে</span>
                                <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/prize/al-fatah.png'; ?>" class="prize-logo" />
                            </div>
                        </div>

                    </div>

                    <div class="content wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                        <?php the_content(); ?>
                        <!-- more book -->
                        <div class="single-more-book">
                            <h5>বই</h5>
                            <ul>
                                <li>
                                    <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/review-image/book-two.png'; ?>" class="prize-logo" />
                                    <h6>বেলা ফুরাবার আগে</h6>
                                    <p>আরিফ আজাদ</p>
                                </li>
                                <li>
                                    <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/review-image/book-two.png'; ?>" class="prize-logo" />
                                    <h6>বেলা ফুরাবার আগে</h6>
                                    <p>আরিফ আজাদ</p>
                                </li>
                            </ul>
                            <h4 class="publication">প্রকাশনী</h4>
                            <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/prize/al-fatah.png'; ?>" class="prize-logo" />
                        </div>
                        <!-- end more book -->
                    </div>
                </div>
            </div>
        <div class="col-lg-4">
            <!-- add this class for sticky sidebar sticky -->
            <div class="single-top  review-campaign-meta-info wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                <div class="single-meta prize-details">
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
                </div>
            </div>
            <!-- end winner list here -->

            <div class="single-top review-campaign-meta-info wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
             
                <div class="single-meta prize-details">

                    <?php  include __DIR__ . '/views/single/single-campaign-prizes.php'; ?>

                    <?php  include __DIR__ . '/views/single/single-campaign-time-table.php'; ?>

                    <div class="large-title-icon mt-20">
                        <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/review-image/review-icon-wrapper.png'; ?>" />
                        <span>নীতিমালা</span>
                    </div>

                    <div class="small-title-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11.0026 16L18.0737 8.92893L16.6595 7.51472L11.0026 13.1716L8.17421 10.3431L6.75999 11.7574L11.0026 16Z" fill="#2A007C"/> </svg>
                        <div class="small-title-content">৬০০ - ২৫০০ শব্দের মধ্যে হতে হবে।</div>
                    </div>

                    <div class="small-title-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11.0026 16L18.0737 8.92893L16.6595 7.51472L11.0026 13.1716L8.17421 10.3431L6.75999 11.7574L11.0026 16Z" fill="#2A007C"/> </svg>
                        <div class="small-title-content">আল ফাতাহ প্রকাশনীর বইয়ের রিভিউ হতে হবে।</div>
                    </div>

                    <div class="all-review">
                        <a href="#">
                            সব নীতিমালা                            
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.9763 10.0006L6.85156 5.87577L8.03007 4.69727L13.3334 10.0006L8.03007 15.3038L6.85156 14.1253L10.9763 10.0006Z" fill="#2A007C"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <?php // include __DIR__ . '/views/single/single-campaign-time-table.php'; ?>

                <div class="join-cta single-meta">
                    <a href="/login">Join FajrFair to Enter</a>
                </div>
            </div>

        </div>
    </div>
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
<!-- recent featured review -->
<div class="recent-featured-review book-review-lists">
    <div class="container">
        <div class="book-review-top">
            <h3>ফিচারড রিভিউ রাইটার</h3>
            <a class="btn-white" href="#">সব রিভিউ দেখুন</a>
        </div>
       <div class="recent-slider-wrapper book-review-list">
            <div class="recent-prev-btn"><button type="button"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/> <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/> </svg></button></div>
            <div class="recent-next-btn"><button type="button"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/> <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/> </svg></button></div>
            <div class="recent-featured-review-list">
            <?php 
            $duration = 1; 
            $delay = 0.6;

            while ($query->have_posts()) : $query->the_post(); 
            $product_id        = get_post_meta( get_the_ID(), '_product_id', true);
            $product_thumbnail = get_the_post_thumbnail_url($product_id, 'thumbnail');
            $authors           = get_the_terms( $product_id, 'authors');
            $author_id         = get_post_field('post_author', get_the_ID());
            $author_data       = get_userdata($author_id);
            $author_url        = get_author_posts_url($author_id);
            $author_avatar     = get_avatar($author_id, 96);
            $author_name       = $author_data ? $author_data->display_name : 'Anonymous';
            $review_rating     = get_post_meta( get_the_ID(), '_review_rating', true );

            ?>
                <div class="book-review-card">
                    <div class="book-review-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
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
                    <h4><a href="<?php the_permalink(); ?>"><?php echo esc_html( wp_trim_words( get_the_title(get_the_ID()), 6, '...' ) ); ?></a></h4>
                    <?php the_excerpt(); ?>
                    <a href="<?php the_permalink(); ?>"><?php esc_html_e( 'সম্পূর্ণ রিভিউ পড়ুন', 'wbr' ); ?></a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
       </div>
    </div>
</div>
<?php endif; ?>
<!-- end recent featured review -->
<?php get_footer();