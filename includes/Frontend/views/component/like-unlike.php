<?php 
// Get like count and status
$like_count = get_comment_meta( $comment->comment_ID, 'like_count', true );
$like_status = get_comment_meta( $comment->comment_ID, 'like_status', true );

// Display like/unlike buttons
echo '<div class="comment-actions">';
echo '<button class="like-btn" data-comment-id="' . esc_attr( $comment->comment_ID ) . '" data-like-status="' . esc_attr( $like_status ) . '">' . esc_html( $like_count ) . ' Likes</button>';
echo '</div>';