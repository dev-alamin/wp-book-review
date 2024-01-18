<?php 
$truncated_content = wp_trim_words( $comment_content, 20, '...' );

// Display a truncated version of the comment content with a "Read More" button
echo '<p class="card-text truncated-comment">' . esc_html( $truncated_content ) . '</p>';

// Check if the full comment content should be hidden
if (strlen($comment_content) > strlen($truncated_content)) {
    echo '<button class="show-more-btn" data-comment-id="' . esc_attr( $comment->comment_ID ) . '">'. esc_html__( 'Read More', 'wpr' ) .'</button>';
    echo '<div class="full-comment" style="display: none;">' . esc_html( $comment_content ) . '</div>'; // Container for full comment content
    echo '<button class="show-less-btn" data-comment-id="' . esc_attr( $comment->comment_ID ) . '" style="display: none;">'. esc_html__( 'Show Less', 'wpr' ) .'</button>';
}