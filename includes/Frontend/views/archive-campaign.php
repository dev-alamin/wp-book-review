<?php
get_header(); ?>
        <div class="bk-campaign-heading">
            <div class="heading">
                <h2><a href="#">Lorem ipsum dolor sit amet.</a></h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
                    Nobis aspernatur vitae sed cum atque animi temporibus soluta, 
                    itaque ut corporis?</p>
            </div>
        </div>
<?php 
// Query to retrieve all products
$campaign_query = new WP_Query(array(
    'post_type'      => 'review-campaign',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    // 'meta_query'     => array(
    //     array(
    //         'key'     => '_last_submission_date',
    //         'value'   => date('Y-m-d'),
    //         'compare' => '>=',
    //         'type'    => 'DATE'
    //     )
    // )
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

    <div class="book-review-open-campaign">
        <div class="book-review-heading">
            <h5>Recent Winners</h5>
        </div>
    </div>
    <div class="book-review-posts">
        <div class="book-review-post">
            <div class="bk-thumbnail-img">
                <a href="#"><img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ) ?>" alt=""></a>
            </div>
            <div class="book-review-avatar">
                <a href="#">
                    <svg width="30px" height="17px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                        <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                    </svg>
                    <img class="author-img" src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ) ?>" alt="">
                </a>
            </div>
            <div class="book-review-info">
                <a href="#">Admin</a>
                <h3><a href="#">this is a title</a></h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti, optio?</p>
            </div>
        </div>
        <div class="book-review-post">
            <div class="bk-thumbnail-img">
                <a href="#"><img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ) ?>" alt=""></a>
            </div>
            <div class="book-review-avatar">
                <a href="#">
                    <svg width="30px" height="17px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                        <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                    </svg>
                    <img class="author-img" src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ) ?>" alt="">
                </a>
            </div>
            <div class="book-review-info">
                <a href="#">Admin</a>
                <h3><a href="#">this is a title</a></h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti, optio?</p>
            </div>
        </div>
        <div class="book-review-post">
            <div class="bk-thumbnail-img">
                <a href="#"><img src="" alt=""></a>
            </div>
            <div class="book-review-avatar">
                <a href="#">
                    <svg width="30px" height="17px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                        <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                    </svg>
                    <img class="author-img" src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ) ?>" alt="">
                </a>
            </div>
            <div class="book-review-info">
                <a href="#">Admin</a>
                <h3><a href="#">this is a title</a></h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti, optio?</p>
            </div>
        </div>
        <div class="book-review-post">
            <div class="bk-thumbnail-img">
                <a href="#"><img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ) ?>" alt=""></a>
            </div>
            <div class="book-review-avatar">
                <a href="#">
                    <svg width="30px" height="17px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                        <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                    </svg>
                    <img class="author-img" src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ) ?>" alt="">
                </a>
            </div>
            <div class="book-review-info">
                <a href="#">Admin</a>
                <h3><a href="#">this is a title</a></h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti, optio?</p>
            </div>
        </div>
    </div>
<?php get_footer();