<?php 
if ( $product_comments ) {
    echo '<div class="container mt-3"><div class="row">';
    foreach ( $product_comments as $product_id => $product_comments_list ) {
        $post       = $product_id;
        $post_title = get_the_title( $post );
        $price      = get_post_meta( $post, '_price', true );
        $permalink  = get_the_permalink( $post );
        ?>

        <div class="col-lg-4 col-sm-6">
            <div class="card wpr-card mb-3">
                <div class="card-header wpr-card-header">
                    <div class="row">
                        <div class="col">
                            <h5> <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $post_title ); ?></a></h5>
                            <div class="wpr-book-info">
                                <p><i class="fa-solid fa-bangladeshi-taka-sign"></i> <?php echo esc_html__( 'Price : ', 'wpr' ) . wc_price( $price ); ?> </p>
                                <p> <i class="fa-solid fa-pen-to-square"></i><?php echo wbr_get_author( $post ); ?> </p>
                                <p> <i class="fas fa-newspaper"></i> <?php echo wbr_get_publisher( $post, '' ); ?></p>
                            </div>
                        </div>
                        <div class="wpr-review-product-thumb col">
                            <?php echo wbr_get_book_cover( $post ); ?>
                        </div>
                        <a href="<?php echo esc_url( $permalink ); ?>" class="btn btn-primary"><?php esc_html_e( 'Buy Book', 'wbr' ); ?></a>
                    </div>
                </div>

                <div class="card-body wpr-card-body" data-simplebar>
                    <!-- Loop through comments for the current product -->
                    <?php foreach ( $product_comments_list as $comment ) : ?>
                        <div class="comment-entry wpr-single-comment">
                            <?php
                            $author_name = get_comment_author( $comment );
                            $author_url  = get_author_posts_url( $comment->user_id );
                            $comment_content = wp_kses_post( $comment->comment_content ); // Sanitize content

                            echo 'Reviewer: ' . ( $author_url ? '<a href="' . $author_url . '">' . esc_html( $author_name ) . '</a>' : esc_html( $author_name ) );
                           
                            include __DIR__ . '/component/comment-rating.php';
                            include __DIR__ . '/component/comment-text.php';
                            include __DIR__ . '/component/like-unlike.php';
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
        <?php
    }
    echo '</div></div>';
} else {
    echo 'No comments found.';
}
