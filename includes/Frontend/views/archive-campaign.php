<?php
get_header(); ?>
<div class="book-review-campaign-heading wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
    <div class="heading">
        <h2>Lorem ipsum dolor sit amet.</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
            Nobis aspernatur vitae sed cum atque animi temporibus soluta, 
            itaque ut corporis?</p>
    </div>
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

if ($campaign_query->have_posts()) { ?>
        <div class="book-review-campaign-wrapper">
        <?php 
            $duration = 1; 
            $delay = 0.6;
            while ($campaign_query->have_posts()) {
                $campaign_query->the_post(); ?>
                    <div class="card  wow fadeInUp" data-wow-duration="<?php echo $duration; ?>s" data-wow-delay="<?php echo $delay ; ?>s">
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
            <?php 
             $duration += 0.3;
             $delay += 0.3;
            }
            ?>
        </div>
    <?php 
}
wp_reset_postdata();
?>

    <div class="mb-3 book-review-open-campaign  wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
        <div class="book-review-heading">
            <h5>Recent Winners</h5>
        </div>
    </div>
    <?php 
    $winner_query = new WP_Query( [
        'post_type'      => 'review',
        'posts_per_page' => -1,
        'meta_key' => '__review_winner_option',
        'posts_per_page' => 20
    ] );
    ?>

<?php if( $winner_query->have_posts() ) : ?>
    <div class="book-single-achievements mb-5 mt-3">
        <?php
        while( $winner_query->have_posts() ) :
            $winner_query->the_post();
            $campaign_winner_position = carbon_get_post_meta(get_the_ID(), '_review_winner_option');
            if( $campaign_winner_position !== 'default' ): 
                $author_id          = get_the_author_meta('ID');
                $author_name        = get_the_author_meta('display_name', $author_id);
                $author_description = get_the_author_meta('description', $author_id);
                $author_avatar      = get_avatar_url($author_id, array('size' => 96));
                $campaign_id        = wbr_get_product_info_by_review(get_the_ID());
                ?>
                <div class="book-single-achievement wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                    <div class="book-review-thumbnail-img">
                        <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ); ?>" alt=""></a>
                    </div>
                    <div class="book-review-avatar">
                        <a href="<?php echo get_author_posts_url($author_id); ?>">
                            <!-- <svg width="30px" height="17px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                                <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                                <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                            </svg> -->
                            <img class="author-img" src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
                        </a>
                    </div>
                    <div class="book-review-info">
                        <a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo esc_html($author_name); ?></a>
                        <h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( wp_trim_words( get_the_title(), 6 ) ); ?></a></h3>
                        <p><?php echo wbr_number_to_word( $campaign_winner_position ). ' place in ' .  wp_trim_words( get_the_title( $campaign_id['campaign'] ), 10, '...' ); ?></p>
                    </div>
                </div>
            <?php endif;
        endwhile;
        ?>
    </div>
<?php endif; ?>

<?php get_footer();