<?php
get_header(); ?>

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
        <li class="review-text">
            ক্যাম্পেইন
        </li>
    </ul>
</div>

<?php 
// Query to retrieve all products
$campaign_query = new WP_Query(array(
    'post_type'      => 'review-campaign',
    'posts_per_page' => 20,
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

if ($campaign_query->have_posts()) : ?>
<!-- recent campaign review -->
 <section class="campaign-review">
    <div class="container">
        <div class="book-review-top">
            <h3><?php esc_html_e( 'বর্তমান ক্যাম্পেইন', 'wbr' ); ?></h3>
            <a class="btn-white" href="/all-review"><?php esc_attr_e( 'সব রিভিউ দেখুন', 'wbr' ); ?></a>
        </div>

        <div class="recent-campaign-wrapper slider-arrow-center">
            <div class="arrow-prev-btn recent-campaign-prev-btn"><button type="button"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/> <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/> </svg></button></div>
            <div class="arrow-next-btn recent-campaign-next-btn"><button type="button"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/> <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/> </svg></button></div>
            
            <div class="campaign-review-slider">
                <?php while( $campaign_query->have_posts() ): 
                $campaign_query->the_post();   
                ?>
                <div class="campaign-review-card">
                    <div class="campaign-review-card-inner">
                        <a href="<?php the_permalink(); ?>">
                            <?php 
                            if( has_post_thumbnail() ) {
                                the_post_thumbnail('medium', ['class'=> 'cover-image' ] );
                            }
                            ?>
                        </a>
                        <div class="campaign-content">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="campaign-content-list">
                            <?php
                            $prizes = carbon_get_post_meta( get_the_ID(), 'prizes' );
                            if ( ! empty( $prizes ) && ! empty( carbon_get_post_meta( get_the_ID(), 'campaign_total_prize_amount' ) ) ) : ?>
                                <div class="campaign-content-list-item">
                                    <p><?php esc_html_e( 'সর্বমোট প্রাইজ মানি', 'wbr' ); ?></p>
                                   <strong> <?php echo get_woocommerce_currency_symbol() .  carbon_get_post_meta( get_the_ID(), 'campaign_total_prize_amount' ); ?></strong>
                                </div>
                            <?php endif; ?>

                            <?php if( ! empty( wbr_get_campaign_days_left( get_the_ID() ) ) ): ?>
                                <div class="campaign-content-list-item">
                                    <p><?php esc_html_e( 'শেষ সময়', 'wbr' ); ?></p>
                                    <?php $raw_date = carbon_get_post_meta( get_the_ID(), 'last_submission_date' ); ?>
                                    <strong><?php  echo wbr_convert_english_date_to_bengali( $raw_date ); ?></strong>

                                    <!-- <strong>১২ আগস্ট ২০২৪</strong> -->
                                </div>
                            <?php endif; ?>

                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn-white"><?php esc_html_e( 'বিস্তারিত', 'wbr' ); ?></a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
 </section>
<?php endif; ?>

<?php 
$recent_eneded_camp = new WP_Query(
    [
        'post_type'      => 'review-campaign',
        'posts_per_page' => 20,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => '_declare_capmaign_result',
                'value'   => 'yes',
                'compare' => '='
            )
        )
    ]
);

if ($recent_eneded_camp->have_posts()) : ?>
<!-- recent campaign review -->
 <section class="campaign-review mb-3">
    <div class="container">
        <div class="book-review-top">
            <h3><?php esc_html_e( 'বিগত দিনের ক্যাম্পেইন', 'wbr' ); ?></h3>
            <a class="btn-white" href="/all-review"><?php esc_html_e( 'সব রিভিউ দেখুন', 'wbr' ); ?></a>
        </div>

        <div class="recent-campaign-wrapper slider-arrow-center">
            <div class="arrow-prev-btn recent-campaign-prev-btn"><button type="button"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/> <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/> </svg></button></div>
            <div class="arrow-next-btn recent-campaign-next-btn"><button type="button"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="24" cy="24" r="23" fill="white" stroke="#E0E0E0" stroke-width="2"/> <path d="M25.1714 24.0007L20.2217 19.0509L21.6359 17.6367L27.9999 24.0007L21.6359 30.3646L20.2217 28.9504L25.1714 24.0007Z" fill="#1C1E29"/> </svg></button></div>
            
            <div class="campaign-review-slider">
                <?php while( $recent_eneded_camp->have_posts() ): 
                $recent_eneded_camp->the_post();   
                ?>
                <div class="campaign-review-card">
                    <div class="campaign-review-card-inner">
                        <a href="<?php the_permalink(); ?>">
                            <?php
                            if( has_post_thumbnail() ) {
                                the_post_thumbnail('medium', ['class'=> 'cover-image' ] );
                            }
                            ?>
                        </a>
                        <div class="campaign-content">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="campaign-content-list">
                            <?php if( ! empty( wbr_get_campaign_days_left( get_the_ID() ) ) ): ?>
                                <div class="campaign-content-list-item">
                                    <p><?php esc_html_e( 'তারিখ', 'wbr' ); ?></p>
                                    <?php $raw_date = carbon_get_post_meta( get_the_ID(), 'result_publish_date' ); ?>
                                    <strong><?php  echo wbr_convert_english_date_to_bengali( $raw_date ); ?></strong>

                                    <!-- <strong>১২ আগস্ট ২০২৪</strong> -->
                                </div>
                            <?php endif; ?>

                           <?php 
                           $all_winners = wbr_get_campaign_winners( get_the_ID(), 1 ); // -1 for all winners

                           if ( ! empty( $all_winners ) ) {
                               foreach ( $all_winners as $winner ) {
                                   $author_url = get_author_posts_url(  $winner['id'] );
                                   echo '<div class="campaign-winner campaign-content-list-item">';
                                   echo '<p>বিজয়ী</p>';
                                   echo '<div class="author-box d-flex">';
                                   echo '<a class="author-box-image" href="' . esc_url( $author_url ) . '">' . get_avatar( $author_id, 96, '', '', ). '</a>';
                                   echo '<a href="' . esc_url( $author_url ) . '">';
                                   echo '<strong>' . esc_html( ucwords( $winner['author'] ) ) . '</strong>';
                                   echo '</a>';
                                   echo '</div>';
                                   echo '</div>';
                               }
                           }
                           
                           ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn-white"><?php esc_html_e( 'বিস্তারিত', 'wbr' ); ?></a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
 </section>
<?php endif; ?>
<?php get_footer(); ?>