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
                            <a class="author-box-image" href="<?php echo esc_url($author_url); ?>"><?php echo get_avatar( $author_id, 96, '', '', ); ?></a>
                            <div class="wbr-team-box">
                                <?php if (! empty( $authors ) ): ?>
                                    <h3><a href="<?php echo esc_url($author_url); ?>"><strong><?php echo esc_html( strtoupper( $author_name ) ); ?></strong></a></h3>
                                <?php endif; ?>
                                <ul><li>মোট <?php echo wbr_english_to_bengali( $total_post ); ?>  রিভিউ লিখেছেন</li> <li>১ দিন আগে রিভিউ টি পোস্ট হয়েছে</li></ul>
                                <a class="campaing" href="<?php echo get_the_permalink($campaing); ?>">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 6.99999C16.4183 6.99999 20 10.5817 20 15C20 19.4183 16.4183 23 12 23C7.58172 23 4 19.4183 4 15C4 10.5817 7.58172 6.99999 12 6.99999ZM12 8.99999C8.68629 8.99999 6 11.6863 6 15C6 18.3137 8.68629 21 12 21C15.3137 21 18 18.3137 18 15C18 11.6863 15.3137 8.99999 12 8.99999ZM12 10.5L13.3225 13.1797L16.2798 13.6094L14.1399 15.6953L14.645 18.6406L12 17.25L9.35497 18.6406L9.86012 15.6953L7.72025 13.6094L10.6775 13.1797L12 10.5ZM18 1.99999V4.99999L16.6366 6.13755C15.5305 5.5577 14.3025 5.17884 13.0011 5.04948L13 1.99899L18 1.99999ZM11 1.99899L10.9997 5.04939C9.6984 5.17863 8.47046 5.55735 7.36441 6.13703L6 4.99999V1.99999L11 1.99899Z" fill="#FF5900"/>
                                    </svg>
                                    <?php echo get_the_title($campaing); ?>
                                </a>
                            </div>

                        </div>
                        <!-- <button>Button</button> -->
                    </div>
                    <div class="wbr-book-meta-info wow fadeInUp" data-wow-duration=".6s" data-wow-delay=".4s">
                        <div class="reviewer-rating">
                            <?php 
                                $rating = intval( $book_info['rating'] ); // Convert rating to an integer
                                $filled_stars = min(5, max(0, $rating)); // Ensure the rating is between 0 and 5

                                for ($i = 0; $i < $filled_stars; $i++) {
                                    echo '<i class="fas fa-star text-warning"></i>';
                                }

                                for ($i = $filled_stars; $i < 5; $i++) {
                                    echo '<i class="far fa-star text-warning"></i>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="wbr-review-text">
                    <h2 class="wow fadeInDown" data-wow-duration=".6s" data-wow-delay=".4s"><?php echo wp_kses_post(get_the_title()); ?></h2>
                    <p><?php echo wp_kses_post(get_the_content()); ?></p>
                </div>
            </div>
        </div>
        <div class="book-sticky-bar">
        <div class="wbr-book-review-box wow fadeInDown" data-wow-duration=".6s" data-wow-delay=".4s">
                <div class="review-header">
                    <h5>যে বই সম্পর্কে রিভিউ লেখা হয়েছে</h5>
                </div>
                <div class="author-review book-info">
                <div class="review-book-img">
                    <?php 
                    $book_image = ! empty( $book_image ) ? $book_image : BOOK_REVIEW_ASSETS . '/images/default-book.png';

                    ?>
                    <a href="<?php esc_url( $book_info['permalink'] ); ?>">
                        <img src="<?php echo esc_url( $book_image ); ?>" alt="<?php echo esc_attr( $book_info['title'] ); ?>">
                    </a>
                </div>
                <div class="book-info">
                    <ul>
                        <li>বই: <a style="color: var(--wd-primary-color);" href="<?php echo esc_url( $book_info['permalink'] ); ?>"><?php echo esc_html( $book_info['title'] ); ?></a> </li>
                        <li>লেখক: 
                        <?php
                        if( ! empty( $authors ) ):
                            foreach ( $authors as $author ): ?>
                            <a style="color: var(--wd-primary-color);" href="<?php echo get_term_link($author); ?>"><?php echo esc_html( $author->name ); ?></a>
                        <?php endforeach; 
                        endif; ?>
                        </li>
                        <li>বিষয়:
                            <?php 
                                $categories = get_the_terms( $book_info['id'], 'product_cat' );
                                if( ! empty( $categories ) || is_countable( $categories ) || is_object( $categories ) ){
                                foreach ( $categories as $cat ): ?>
                                    <a style="color: var(--wd-primary-color);" href="<?php echo get_term_link($cat); ?>"><?php echo esc_html($cat->name); ?></a>
                                <?php endforeach;
                                }
                            ?>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="book-price">
                    <ul>
                        <li>মোট রিভিউ: <?php echo wbr_english_to_bengali( $total_review['total_reviews'] ); ?> টি  (<?php  echo wbr_english_to_bengali( $total_review['average_rating'] ); ?> রেটিং )</li>
                        <li>
                            <?php 
                            if( ! empty( $book_info['regular_price'] ) && !empty( $book_info['sale_price'] ) ) {
                                echo 'মূল্য: <del>';
                                echo  wc_price( $book_info['regular_price'] );
                                echo '</del>';
                                }elseif( !empty( $book_info['regular_price'] ) ) {
                                echo 'মূল্য: ';
                                echo  wc_price( $book_info['regular_price'] );
                                }
                            ?>
                        <?php 
                        if( ! empty( $book_info['sale_price'] ) ) {
                            echo wc_price( $book_info['sale_price'] );
                            echo ' টাকা';
                            }
                        ?>
                    </li>
                    </ul>
                    <div class="price-btn">
                        <button><a style="color: #fff;" href="<?php echo esc_url( $book_info['permalink'] ); ?>">বইটি  কিনুন </a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<?php include __DIR__ . '/views/single/related-review.php'; ?>

<?php get_footer(); ?>