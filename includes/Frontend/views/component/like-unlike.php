<?php 
// Get like count and status
$like_count = get_comment_meta( $comment->comment_ID, 'like_count', true );
$like_status = get_comment_meta( $comment->comment_ID, 'like_status', true );

// Display like/unlike buttons
echo '<div class="comment-actions">';
    echo '<button class="like-btn" data-comment-id="' . esc_attr( $comment->comment_ID ) . '" data-like-status="' . esc_attr( $like_status ) . '">' . esc_html( $like_count ) . ' <i class="fa-regular fa-thumbs-up"></i>Like</button>';
    echo '<button class="comment-btn" data-comment-id="' . esc_attr( $comment->comment_ID ) . '" data-like-status="' . esc_attr( $like_status ) . '">' . esc_html( $like_count ) . ' <i class="far fa-comment"></i></i>Comment</button>';
    echo '<button class="share-btn" data-comment-id="' . esc_attr( $comment->comment_ID ) . '" data-like-status="' . esc_attr( $like_status ) . '">' . esc_html( $like_count ) . '<i class="fas fa-share"></i>Share</button>';
echo '</div>';