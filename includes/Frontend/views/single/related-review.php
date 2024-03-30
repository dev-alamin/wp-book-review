<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2>বইয়ের অন্যান্য রিভিউ</h2>
            <div class="row">
                <?php 
                $related_reviews_query = new WP_Query(array(
                    'post_type' => 'review',
                    'posts_per_page' => 4, // Adjust number of related reviews to display
                    'post__not_in' => array($post_id), // Exclude the current review
                    'meta_query' => array(
                        array(
                            'key' => '_product_id',
                            'value' => $product_id
                        )
                    )
                ));
                $post_count = $related_reviews_query->found_posts;

                if ($related_reviews_query->have_posts()) {
                    while ($related_reviews_query->have_posts()) {
                        $related_reviews_query->the_post(); ?>
                        <div class="col-lg-3">
                            <div class="card mb-3">
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top img-fluid" alt="<?php the_title_attribute(); ?>">
                                    </a>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body product-user">
                                    <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php echo esc_html(wp_trim_words(get_the_title(), 3)); ?></a></h5>
                                    <p class="card-text"><a href="<?php the_permalink(); ?>"><?php echo esc_html(wp_trim_words(get_the_content(), 10)); ?></a></p>
                                    
                                    <div class="wbr-product-user">
                                    <a href="<?php echo esc_url($author_url); ?>"><?php echo get_avatar( $author_id, 96, '', '', ); ?></a>
                                        <div class="wbr-product-team">
                                        <?php if ($authors): ?>
                                            <h3><a href="<?php echo esc_url($author_url); ?>"><?php echo esc_html( strtoupper( $author_name ) ); ?></a></h3>
                                            <?php endif; ?>
                                            <p>মোট <?php echo ff_english_to_bengali( $total_post ); ?>  রিভিউ লিখেছেন </p>
                                        </div>
                                        <!-- <button>Button</button> -->
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
    <?php 
        if ($post_count > 8 ) {
            echo '<div class="row">';
            echo ff_get_term_link( get_the_ID());
            echo '</div>';
        }
    ?>
</div>