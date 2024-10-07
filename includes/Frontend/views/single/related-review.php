<?php
$post_id = get_the_ID();
$related_reviews_query = new WP_Query(array(
    'post_type' => 'review',
    'posts_per_page' => 4, // Adjust number of related reviews to display
    'post__not_in' => array($post_id), // Exclude the current review
    'meta_query' => array(
        array(
            'key' => '_product_id',
            'value' => $book_info['id']
        )
    )
));

$post_count = $related_reviews_query->found_posts;
?>
<!-- book review -->
<div class="book-review-lists">
    <div class="container">
        <div class="book-review-top">
            <h3><?php echo esc_html_e( 'বইয়ের অন্যান্য রিভিউ', 'wbr' ); ?></h3>
            <?php 
                if ($post_count > 8 ) {
                    echo '<div class="row">'; ?>
                   <a class="btn-white" href="<?php echo esc_url('/all-review'); ?>"><?php esc_html_e( 'সব রিভিউ দেখুন', 'wbr' ); ?></a>
                    <?php echo '</div>';
                }
            ?>
            
        </div>
        <div class="book-review-list">
            <div class="row">
                    <?php
                    if ( $related_reviews_query->have_posts() ) {
                        while ( $related_reviews_query->have_posts() ) {
                            $related_reviews_query->the_post();

                            $product_id        = get_post_meta( get_the_ID(), '_product_id', true);
                            $product_thumbnail = get_the_post_thumbnail_url( $product_id, 'thumbnail');
                            $authors           = get_the_terms( $product_id, 'authors');
                            $author_id         = get_post_field('post_author', get_the_ID());
                            $author_data       = get_userdata( $author_id );
                            $author_url        = get_author_posts_url( $author_id );
                            $author_avatar     = get_avatar( $author_id, 96 );
                            $author_name       = $author_data ? $author_data->display_name : 'Anonymous';
                            $review_rating     = get_post_meta( get_the_ID(), '_review_rating', true );
                            $book_image        = ! empty( $product_thumbnail ) ? $product_thumbnail : BOOK_REVIEW_ASSETS . '/images/default-book.png';
                            ?>
                            
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="book-review-card mb-5">
                                    <div class="book-review-thumbnail">
                                        <?php
                                        if( has_post_thumbnail() ) {
                                            the_post_thumbnail('full'); 
                                        }
                                        ?>
                                        <div class="book-list">
                                            <a href="<?php echo esc_url( get_the_permalink( $product_id ) ); ?>">
                                                <img src="<?php echo esc_url( $book_image ); ?>" alt="<?php esc_attr( get_the_title( $product_id ) ); ?>" />
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
                    }
                    ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
            <?php 
                if ($post_count > 8 ) {
                    echo '<div class="row">';
                    echo ff_get_term_link( get_the_ID());
                    echo '</div>';
                }
            ?>
            </div>
        </div>
    </div>
</div>
