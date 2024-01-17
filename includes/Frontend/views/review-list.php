<?php 
// Comment Loop
if ( $comments ) {
    echo '<div class="container"><div class="row">';
    foreach ( $comments as $comment ) {
                $post       = $comment->comment_post_ID;
                $post_title = get_the_title( $post );
                $thumbnail  = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'single-post-thumbnail' );
                $price      = get_post_meta( $post, '_price', true );
                $permalink  = get_the_permalink( $post );
        ?>
                <div class="col-lg-4 col-sm-6">
                    <div class="card wpr-card mb-3" style="background-color: #CFE2FF;">
                        <div class="card-header">
                            <h5><span class="badge badge-secondary bg-primary">New</span> 
                            <?php
                            $author_name = get_comment_author( $comment->comment_ID );
                            echo 'Reviewer: ' . esc_html( $author_name ) . ' - ' . $comment->comment_post_ID . '<br>';
                            ?>
                        </h5>                          
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <p class=""><?php echo esc_html( $post_title ) ?></p>
                                </div>
                                <div class="col">
                                    <p class="">লেখক - আরিফ আজাদ</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p class="">প্রকাশনী - সমকালীন প্রকাশন</p>
                                </div>
                                <div class="col">
                                    <p class="">বিষয় - আত্মশুদ্ধি ও আত্ম-উন্নয়ন </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="wpr-post-thumbnail col">
                                   <img src="<?php echo $thumbnail[0]; ?>" alt="">
                                </div>
                                <div class="col">
                                    <?php echo 'Price: ' . $price; ?>
                                </div>
                            </div>
                            <p class="card-text"><?php echo get_comment_meta( $comment->comment_ID, 'review_title', true ); ?></p>
                            <p><?php echo get_comment_meta( $comment->comment_ID, 'rating', true ); ?> </p>
                            <p class="card-text"><?php echo esc_html( $comment->comment_content ); ?></p>
                            <a href="<?php echo esc_url( $permalink ); ?>" class="btn btn-primary">Buy Book</a>
                        </div>
                        
                    </div>
                </div>

        <?php
    }
    echo '</div></div>';
}