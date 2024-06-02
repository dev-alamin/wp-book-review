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

<section class="wp-single-wbr wbr-single-bg wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="wbr-review-content">
                    <div class="wbr-review-image wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">'
                        <?php 
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('large', array('class' => 'img-fluid'));
                            }
                        ?>
                    </div>
                    <h2 class="wow fadeInDown" data-wow-duration=".6s" data-wow-delay=".4s"><?php echo wp_kses_post(get_the_title()); ?></h2>

                    <div class="wbr-product-user wow fadeInUp" data-wow-duration=".6s" data-wow-delay=".4s">
                    <a href="<?php echo esc_url($author_url); ?>"><?php echo get_avatar( $author_id, 96, '', '', ); ?></a>
                        <div class="wbr-product-team">
                        <?php if (! empty( $authors ) ): ?>
                            <h3><a href="<?php echo esc_url($author_url); ?>"><strong><?php echo esc_html( strtoupper( $author_name ) ); ?></strong></a></h3>
                            <?php endif; ?>
                            <p>মোট <?php echo ff_english_to_bengali( $total_post ); ?>  রিভিউ লিখেছেন </p>
                        </div>
                        <a class="campaing" href="<?php echo get_the_permalink($campaing); ?>"><?php echo get_the_title($campaing); ?></a>
                        <!-- <button>Button</button> -->
                    </div>
                    <div class="wbr-book-meta-info wow fadeInUp" data-wow-duration=".6s" data-wow-delay=".4s">
                        <div class="reviewer-rating">
                            <h4>রেটিং দিয়েছেন</h4>
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
                                <li>মোট রিভিউ: <?php echo ff_english_to_bengali( $total_review['total_reviews'] ); ?> টি  (<?php  echo ff_english_to_bengali( $total_review['average_rating'] ); ?> রেটিং )</li>
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
                    <div class="wbr-review-text">
                        <p><?php echo wp_kses_post(get_the_content()); ?></p>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
<?php include __DIR__ . '/views/single/related-review.php'; ?>
</section>

<?php get_footer(); ?>