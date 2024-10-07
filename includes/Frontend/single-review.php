<?php 
defined( 'ABSPATH' ) || exit;
get_header();
$post_id             = get_the_ID();
$author_id           = get_post_field('post_author', $post_id);
$comment_author_data = get_userdata($author_id);
$book_info           = wbr_get_product_info_by_review( $post_id );
$author_url          = get_author_posts_url($author_id);
$author_avatar       = get_avatar($author_id, 96);
$author_name         = $comment_author_data ? $comment_author_data->display_name : 'Anonymous';
$authors             = get_the_terms($book_info['id'], 'authors');
$publishers          = get_the_terms($book_info['id'], 'publisher');
$product             = wc_get_product($book_info['id']);
$total_post          = count_user_posts($author_id, 'review' );
$total_review        = wpr_get_total_review_and_average( $book_info['id'] );

$campaing = get_post_meta(get_the_ID(), '_campaign_id', true);
?>

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
            <a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a>
        </li>
        <li>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.78105 8.00047L5.4812 4.70062L6.42401 3.75781L10.6667 8.00047L6.42401 12.2431L5.4812 11.3003L8.78105 8.00047Z" fill="#9A9D9D"/>
            </svg>
        </li>
        <li class="review-text">
            রিভিউ
        </li>
    </ul>
</div>

<section class="wp-single-wbr wbr-single-bg">
    <div class="wp-single-wrapper">
        <div class="wbr-review-content">
            <div class="wbr-review-content-wrapper">

                <div class="wbr-review-image wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                    <?php 
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('large', array('class' => 'img-fluid'));
                        }
                    ?>
                </div>
              
                <div class="wbr-author-box">
                    <div class="wbr-product-user wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                        <div class="wbr-product-team">
                            <a class="author-box-image" href="<?php echo esc_url( $author_url ); ?>"><?php echo get_avatar( $author_id, 96, '', '', ); ?></a>
                            <div class="wbr-team-box">
                                <?php if ( ! empty( $authors ) ): ?>
                                    <h3><a href="<?php echo esc_url( $author_url ); ?>">
                                        <strong><?php echo esc_html( strtoupper( $author_name ) ); ?></strong>
                                        </a>
                                    </h3>
                                <?php endif; ?>
                                <ul>
                                    <?php if( ! empty( $total_post ) ): ?>
                                    <li><?php 
                                        printf(
                                            'মোট %s রিভিউ লিখেছেন',
                                            wbr_english_to_bengali( $total_post )
                                        ); ?></li>
                                    <?php endif; ?>
                                    <li>
                                    <?php
                                    printf( esc_html__( '%s দিন আগে রিভিউ টি পোস্ট হয়েছে', 'wbr' ),
                                        human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) )
                                    );
                                    ?>    
                                    </li>
                                </ul>
                                <?php if( ! empty( get_the_title( $campaing ) ) ): ?>
                                <a class="campaing" href="<?php echo esc_url( get_the_permalink( $campaing ) ); ?>">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 6.99999C16.4183 6.99999 20 10.5817 20 15C20 19.4183 16.4183 23 12 23C7.58172 23 4 19.4183 4 15C4 10.5817 7.58172 6.99999 12 6.99999ZM12 8.99999C8.68629 8.99999 6 11.6863 6 15C6 18.3137 8.68629 21 12 21C15.3137 21 18 18.3137 18 15C18 11.6863 15.3137 8.99999 12 8.99999ZM12 10.5L13.3225 13.1797L16.2798 13.6094L14.1399 15.6953L14.645 18.6406L12 17.25L9.35497 18.6406L9.86012 15.6953L7.72025 13.6094L10.6775 13.1797L12 10.5ZM18 1.99999V4.99999L16.6366 6.13755C15.5305 5.5577 14.3025 5.17884 13.0011 5.04948L13 1.99899L18 1.99999ZM11 1.99899L10.9997 5.04939C9.6984 5.17863 8.47046 5.55735 7.36441 6.13703L6 4.99999V1.99999L11 1.99899Z" fill="#FF5900"/>
                                    </svg>
                                    <?php echo esc_html( get_the_title( $campaing ) ); ?>
                                </a>
                                <?php endif; ?>
                            </div>

                        </div>
                        <!-- <button>Button</button> -->
                    </div>
                    <div class="wbr-book-meta-info wow fadeInUp" data-wow-duration=".6s" data-wow-delay=".4s">
                        <div class="reviewer-rating">
                            <?php
                                $rating = intval( $book_info['rating'] );
                                wbr_get_svg_star_rating_icon( $rating );
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="wbr-review-text">
                    <h2 class="wow fadeInDown" data-wow-duration=".6s" data-wow-delay=".4s"><?php echo wp_kses_post(get_the_title()); ?></h2>
                    <p><?php echo wp_kses_post(get_the_content()); ?></p>
                </div>
            </div>
            
            <div class="fajar-post-a-comment">
                <!-- comment form here -->
                <div class="book-review-top">
                    <h3><?php esc_html_e( 'কমেন্ট এবং রেটিং', 'wbr' ); ?></h3>
                </div>

                <div class="comment-list">
                    <?php
                     // Check if comments are open or if there are comments
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                    ?>
                    <!-- book review -->
                    <!-- <div class="book-review-card">
                        <div class="book-user-review">
                            <img src="<?php //echo BOOK_REVIEW_ASSETS . '/images/review-image/user.png'; ?>" />
                            <div class="book-user-info">
                                <h4>Ferdaus Kabir</h4>
                                <p>Posted 2 days ago</p>
                            </div>
                            <div class="book-user-star">
                                <?php //wbr_get_svg_star_rating_icon(); ?>
                            </div>
        
                        </div>
        
                        <div class="book-review-content">
                            <p>মানুষের ইগনোরেন্সের তুলনা করা চলে অনেকটা পোকা মাকড়ের সাথে।পোকা মাকড় যেমন আলো দেখে বোকার মতো আগুনে গিয়ে ঝাপ দিয়ে নিজের ধ্বংস ডেকে আনে,মানুষও তেমনি দুনিয়ার চাকচিক্যে বোকা বনে গিয়ে নিজেকে ধ্বংসের দিকে ঠেলে দেয়।সেই আগুন তাদেরকে গ্রাস করার আগেই অতীতে বোকা বনে যাওয়া কিছু মানুষ সক্ষম হয় আগুনের কাছ থেকে ফিরে আসতে...</p>
                            <a href="#">সম্পূর্ণ রিভিউ পড়ুন </a>
                        </div>
                    </div> -->
                    <!-- end book review -->
                </div>
            </div>
        </div>
        <div class="book-sticky-bar">
            <div class="wbr-book-review-box wow fadeInDown" data-wow-duration=".6s" data-wow-delay=".4s">
                    <div class="author-review book-info">
                        <div class="review-book-img">
                            <?php 
                            $book_image = ! empty( $book_image ) ? $book_image : BOOK_REVIEW_ASSETS . '/images/default-book.png'; ?>
                            <a href="<?php echo esc_url( $book_info['permalink'] ); ?>">
                                <img src="<?php echo esc_url( $book_image ); ?>" alt="<?php echo esc_attr( $book_info['title'] ); ?>">
                            </a>
                        </div>
                        <div class="book-info">
                            <div class="write-name-title">
                                <a href="<?php echo esc_url( $book_info['permalink'] ); ?>"><?php echo esc_html( $book_info['title'] ); ?></a>
                            </div>
                            <div class="fajar_writer-description">
                                <?php
                                    if( ! empty( $authors ) ):
                                        foreach ( $authors as $author ): ?>
                                        <a href="<?php echo get_term_link($author); ?>"><?php echo esc_html( $author->name ); ?></a>
                                    <?php endforeach; 
                                endif; ?>
                            </div>

                            <ul>
                                <li>
                                    <span><?php esc_html_e( 'প্রকাশক', 'wbr' ); ?></span>
                                    <strong>
                                        <?php 
                                            if( ! empty( $publishers ) || is_countable( $publishers ) || is_object( $publishers ) ){
                                            foreach ( $publishers as $publisher ): ?>
                                                <a href="<?php echo get_term_link($publisher); ?>"><?php echo esc_html($publisher->name); ?></a>
                                            <?php endforeach;
                                            }
                                        ?>
                                    </strong>
                                </li>
                                <li>
                                    <span><?php esc_html_e( 'বিষয়', 'wbr' ); ?></span>
                                    <strong>
                                        <?php
                                            $categories = get_the_terms( $book_info['id'], 'product_cat' );
                                            if( ! empty( $categories ) || is_countable( $categories ) || is_object( $categories ) ){
                                            foreach ( $categories as $cat ): 
                                                if( $cat->name != 'Uncategorized' ): ?>
                                                    <a href="<?php echo get_term_link($cat); ?>"><?php echo esc_html($cat->name); ?></a>
                                                <?php 
                                                endif;
                                            endforeach;
                                            }
                                        ?>
                                    </strong>
                                </li>
                                <li>
                                    <span><?php esc_html_e( 'রেটিং', 'wbr' ); ?></span>
                                    <strong class="rating-title">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M8.00032 12.1733L3.29802 14.8055L4.34824 9.51993L0.391846 5.86119L5.74321 5.2267L8.00032 0.333328L10.2574 5.2267L15.6087 5.86119L11.6524 9.51993L12.7026 14.8055L8.00032 12.1733Z" fill="#FFAC4B"/> </svg>
                                        <label for=""> <?php echo wbr_english_to_bengali( $total_review['total_reviews'] ); ?> টি  (<?php  echo wbr_english_to_bengali( $total_review['average_rating'] ); ?> রেটিং )</label>
                                    </strong>
                                </li>
                                <?php if( ! empty( $book_info['regular_price'] ) || $book_info['sale_price'] ): ?>
                                <li>
                                    <span class="price-top-title"><?php esc_html_e( 'মূল্য', 'wbr' ); ?> </span>
                                    <strong class="price-item">
                                        <?php 
                                            if( ! empty( $book_info['regular_price'] ) && ! empty( $book_info['sale_price'] ) ) {
                                                echo '<del>';
                                                echo  wc_price( $book_info['regular_price'] );
                                                echo '</del>';
                                                }elseif( ! empty( $book_info['regular_price'] ) ) {
                                                echo  wc_price( $book_info['regular_price'] );
                                                }
                                            ?>
                                        <?php 
                                        if( ! empty( $book_info['sale_price'] ) ) {
                                            echo wc_price( $book_info['sale_price'] );
                                            }
                                        ?>
                                    </strong>
                                </li>
                                <?php endif; ?>
                            </ul>

                            <?php if ( ! empty( $book_info['id'] ) && ! empty( $book_info['permalink'] ) ) : ?>
                                <div class="price-btn">
                                    <!-- "Buy Now" Button -->
                                    <!-- "Buy Now" Button that adds to cart and redirects to checkout -->
                                    <a href="<?php echo esc_url( wc_get_checkout_url() . '?add-to-cart=' . $book_info['id'] ); ?>"
                                    class="btn btn-style-rectangle btn-color-primary">
                                    <?php esc_html_e( 'এখনি কিনুন', 'wbr' ); ?>
                                    </a>

                                    <!-- WooCommerce's default AJAX Add to Cart Button -->
                                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
                                    data-product_id="<?php echo esc_attr( $book_info['id'] ); ?>"
                                    data-quantity="1"
                                    class="button add_to_cart_button ajax_add_to_cart btn-white">
                                        <?php esc_html_e( 'কার্টে যোগ করুন', 'wbr' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>

<?php 
$archive_featured_review = array (
    'post_type'      => 'review',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'orderby'        => 'rand',
    'order'          => 'ASC',
    'meta_key'       => ['_wbr_is_featured_review'],
    'meta_value'     => 'yes', 
);

$featured_rev = new WP_Query($archive_featured_review);
$options      = get_option( 'wbr_archive_promo_options' );
?>

<!-- book review -->
<div class="book-review-lists">
    <div class="container">
        <div class="book-review-top">
            <h3><?php echo esc_html_e( 'ফিচারড রিভিউ','' ); ?></h3>
            <a class="btn-white" href="<?php echo esc_url('/all-review'); ?>"><?php esc_html_e( 'সব রিভিউ দেখুন', 'wbr' ); ?></a>
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

<?php include __DIR__ . '/views/single/related-review.php'; ?>

<?php get_footer(); ?>