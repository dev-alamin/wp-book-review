<?php 
defined( 'ABSPATH' ) || exit;
get_header();
$post_id             = get_the_ID();
$author_id           = get_post_field('post_author', $post_id);
$comment_author_data = get_userdata($author_id);
$product_id          = get_post_meta($post_id, '_product_id', true);
$author_url          = get_author_posts_url($author_id);
$author_avatar       = get_avatar($author_id, 96);
$author_name         = $comment_author_data ? $comment_author_data->display_name : 'Anonymous';
$authors             = get_the_terms($product_id, 'authors');
$product             = wc_get_product($product_id);
$book_rating         = get_post_meta($post_id, '_review_rating', true);
$regular_price       = get_post_meta( $product_id, '_regular_price', true );
$sale_price          = get_post_meta( $product_id, '_sale_price', true );
?>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="wbr-review-content">
                <h2><?php echo wp_kses_post(get_the_title()); ?></h2>
               
                <?php if ($authors): ?>
                    <p class="wbr-product-authors">Product Authors:
                        <?php foreach ($authors as $author): ?>
                            <a href="<?php echo get_term_link($author); ?>"><?php echo esc_html($author->name); ?></a>
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>
                <div class="wbr-review-image">
                    <?php 
                        if (has_post_thumbnail()) {
                            // the_post_thumbnail('large', array('class' => 'img-fluid'));
                        }
                    ?>
                </div>
                <div class="wbr-book-meta-info">
                    <div class="">
                       <h4><?php echo get_the_title( get_the_ID()); ?> বই িনেয় টুকেরা কথা</h4>
                       
                            <?php echo get_avatar( $author_id, 32, '', '', array('class' => 'rounded-circle mr-2')); ?>
                            <p class="wbr-review-author"><a href="<?php echo esc_url($author_url); ?>"><?php echo esc_html($author_name); ?></a></p>
                            <p class="m-0"><?php echo esc_html(get_the_author()); ?></p>
                            <p class="m-0"><?php echo count_user_posts($author_id, 'review' ); ?> Posts</p>

                            <div class="reviewer-rating">
                                <h4>রেটিং দিয়েছেন</h4>
                                <?php 
                                    $rating = intval($book_rating); // Convert rating to an integer
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
                <div class="reviewed-book-info">
                    <h4><?php echo esc_html( get_the_title( $product_id ) ); ?></h4>
                        <div class="review-book-image">
                            <?php echo get_the_post_thumbnail( $product_id, 'thumbnail' ); 
                                echo esc_html( get_the_title( $product_id ) );
                                if( ! empty( $authors ) || is_countable( $authors ) || is_object( $authors ) ){
                                    foreach ( $authors as $author): ?>
                                    <a href="<?php echo get_term_link($author); ?>"><?php echo esc_html($author->name); ?></a>
                                    <?php endforeach; 
                                }

                                $categories = get_the_terms( $product_id, 'product_cat' );
                                if( ! empty( $categories ) || is_countable( $categories ) || is_object( $categories ) ){
                                foreach ( $categories as $cat ): ?>
                                    <a href="<?php echo get_term_link($cat); ?>"><?php echo esc_html($cat->name); ?></a>
                                <?php endforeach;
                                }

                                $total_review =  wpr_get_total_review_and_average( $product_id );

                                echo '<p>Total reviews' . $total_review['total_reviews'] . '</p>';
                                echo '<p>Average rating' . $total_review['average_rating'] . '</p>';

                                if( ! empty( $regular_price ) ) {
                                    echo '<p>Regular Price: ' .  wc_price( $regular_price ) . '</p>';
                                }

                                if( ! empty( $sale_price ) ) {
                                    echo '<p>Sale Price: ' .  wc_price( $sale_price ) . '</p>';
                                }

                            ?>

                        </div>
                </div>
                <div class="wbr-review-text">
                    <p><?php echo wp_kses_post(get_the_content()); ?></p>
                </div>
            </div>
            <?php 
            // Comment Form
            comment_form(array(
                'title_reply' => 'Leave a Review',
                'comment_notes_after' => '',
                'class_form' => 'wbr-comment-form',
                'class_submit' => 'btn btn-primary',
                'comment_field' => '<div class="form-group"><label for="comment" class="wbr-comment-label">Your Review:</label><textarea id="comment" name="comment" class="form-control" cols="45" rows="8" required></textarea></div>',
            ));
            ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/views/single/related-review.php'; ?>

<?php get_footer(); ?>