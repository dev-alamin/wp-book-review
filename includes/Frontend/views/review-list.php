

<?php 
if ($comments) {
    echo '<div class="container mt-3"><div class="row">';
    foreach ($comments as $comment) {
        $post         = $comment->comment_post_ID;
        $post_title   = get_the_title($post);
        $price        = get_post_meta($post, '_price', true);
        $permalink    = get_the_permalink($post);
        $comment_link = get_comment_link( $comment );
        ?>
        <div class="col-lg-4 col-sm-6 col-xs-12">
            <div class="card wpr-card mb-5">
                <div class="card-header wpr-card-header">
                    <div class="header-banner">
                        <div class="thumbnail">
                            <?php echo wbr_get_book_cover( $post, $comment ); ?>
                        </div>
                        <div class="right-title">
                            <h5> <a href="<?php echo esc_url($comment_link); ?>"><?php echo esc_html($post_title); ?></a></h5>
                            <p class="label-text"> বই নিয়ে টুকেরা কথা</p>
                            <p><i class="fa-solid fa-pen-to-square"></i><?php echo wbr_get_authors($post, false); ?> </p>
                        </div>
                    </div>
                </div>
                <div class="card-body wpr-card-body" data-simplebar>
                    <div class="title-description">
                        <h5> 
                            <a href="<?php echo esc_url($comment_link); ?>">
                                <?php
                                 echo esc_html($post_title); 
                                 esc_html_e( ' বই নিয়ে টুকেরা কথা', 'wbr' ); 
                                ?>
                            </a>
                        </h5>
                    </div>
                    <!-- Display the individual comment -->
                    <div class="comment-entry wpr-single-comment">
                        <?php
                        $author_url  = get_author_posts_url($comment->user_id);
                        $author_avatar = get_avatar($comment->user_id, 96); // Get the author's avatar (adjust the size as needed)

                       $args = array(
                            'user_id' => $comment->user_id,
                            'count'   => true,
                        );
                        
                        $comment_count = get_comments( $args );

                        include __DIR__ . '/component/comment-text.php';

                       // Output the author's avatar and comment count
                       echo '<div class="author-meta">';
                       echo '<div class="author-avatar"> <a href="' . esc_url($author_url) . '"> ' . $author_avatar . '</a></div>';
                       echo '<div class="author-and-count">';
                           echo wbr_get_comment_author_name( $comment );
                           echo '<p>মোট ' . $comment_count . ' টি পর্যালোচনা লিখেছেন</p>';
                       echo '</div>';
                      echo '</div>';

                        $single_page = false;
                        if( $single_page ) {
                            include __DIR__ . '/component/comment-rating.php';
                            include __DIR__ . '/component/like-unlike.php';
                        }
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    echo '</div></div>';
} else {
    // echo 'No comments found.';
}
