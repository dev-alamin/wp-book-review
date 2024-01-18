<?php 
$comment_rating = get_comment_meta( $comment->comment_ID, 'rating', true );
echo '<div class="rating">';
    $this->display_star_rating( $comment_rating );
echo '</div>';