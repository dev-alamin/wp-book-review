<?php 
if ( $product_comments ) {
    echo '<div class="container mt-3"><div class="row">';
    foreach ( $product_comments as $product_id => $product_comments_list ) {
        $post       = $product_id;
        $post_title = get_the_title( $post );
        $thumbnail  = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
        $price      = get_post_meta( $post, '_price', true );
        $permalink  = get_the_permalink( $post );
        $price      = get_post_meta( $post, '_price', true );

        // Get the publisher and author terms
        $publishers = get_the_terms( $post, 'publisher' );
        $authors    = get_the_terms( $post, 'authors' );

        ?>
        <div class="col-lg-4 col-sm-6">
            <div class="card wpr-card mb-3">
                <div class="card-header wpr-card-header">
                        <div class="row">
                            <div class="col">
                                <h5> <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $post_title ); ?></a></h5>
                                <div class="wpr-book-info">
                                    <p>Price : <?php echo  wc_price( $price ); ?> </p>
                                    <?php
                                    if ($authors) :
                                        $authors_count = count($authors);
                                        $authors_names = array();

                                        foreach ($authors as $author) {
                                            $authors_names[] = $author->name;
                                        }

                                        ?>
                                        <p>
                                            <?php
                                            echo $authors_count === 1 ? 'Author' : 'Authors';
                                            echo ': ' . esc_html(implode(', ', $authors_names));
                                            ?>
                                        </p>
                                    <?php endif; ?>

                                <?php if ( $publishers ) : ?>
                                <p>Publisher: <?php echo esc_html( $publishers[0]->name ); ?></p>
                                <?php endif; ?>
                                </div>
                            </div>
                            <div class="wpr-review-product-thumb col">
                                <?php if ( $thumbnail ) : ?>
                                   <a href="<?php echo esc_url( $permalink ); ?>"> <img src="<?php echo esc_url( $thumbnail[0] ); ?>" alt="<?php echo esc_attr( $post_title ); ?>" class="product-thumbnail"></a>
                                <?php endif; ?>
                            </div>
                        </div>


                </div>
                <div class="card-body wpr-card-body">
                    <!-- Loop through comments for the current product -->
                    <?php foreach ( $product_comments_list as $comment ) : ?>
                        <div class="comment-entry wpr-single-comment">
                            <?php
                            $author_name = get_comment_author( $comment );
                            $author_url  = get_author_posts_url( $comment->user_id );

                            echo 'Reviewer: ' . ( $author_url ? '<a href="' . $author_url . '">' . esc_html( $author_name ) . '</a>' : esc_html( $author_name ) );

                            $comment_rating = get_comment_meta( $comment->comment_ID, 'rating', true );
                            echo '<div class="rating">';
                            $this->display_star_rating( $comment_rating );
                            echo '</div>';
                            ?>
                            <p class="card-text"><?php echo esc_html( $comment->comment_content ); ?></p>
                        </div>
                    <?php endforeach; ?>
                    <a href="<?php echo esc_url( $permalink ); ?>" class="btn btn-primary">Buy Book</a>
                </div>
            </div>
        </div>
        <?php
    }
    echo '</div></div>';
} else {
    echo 'No comments found.';
}
