<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2>বইয়ের অন্যান্য রিভিউ</h2>
            <div class="row">
                <?php 
                $related_reviews_query = new WP_Query(array(
                    'post_type' => 'review',
                    'posts_per_page' => 3, // Adjust number of related reviews to display
                    'post__not_in' => array($post_id), // Exclude the current review
                    'meta_query' => array(
                        array(
                            'key' => '_product_id',
                            'value' => $product_id
                        )
                    )
                ));

                if ($related_reviews_query->have_posts()) {
                    while ($related_reviews_query->have_posts()) {
                        $related_reviews_query->the_post(); ?>
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <?php if (has_post_thumbnail()): ?>
                                    <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" class="card-img-top img-fluid" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                                <div class="card-body product-user">
                                    <h5 class="card-title"><?php the_title(); ?></h5>
                                    <p class="card-text"><?php echo esc_html(wp_trim_words(get_the_content(), 10)); ?></p>
                                    
                                    <div class="wbr-product-user">
                                        <?php echo get_avatar( $author_id, 32, '', '', ); ?>
                                        <div class="wbr-product-team">
                                            <h3>ফজর ফায়ার টীম</h3>
                                            <p>মোট ২৩টি  রিভিউ লিখেছেন </p>
                                        </div>
                                        <button>বাটন থাকেত পাের</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    wp_reset_postdata();
                } else {
                    echo '<p>No other reviews found for this product.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>