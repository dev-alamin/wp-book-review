<div class="form-group">
    <label class="visually-hidden" for="review-rating">Rating:</label>
    <select class="form-select" name="review-rating" id="review-rating" required>
        <option value="">Your rating</option>
        <?php
        $selected_rating = isset($_GET['reviewid']) ? intval($_GET['reviewid']) : 0;

        $ratings = array(
            5 => '5 Stars',
            4 => '4 Stars',
            3 => '3 Stars',
            2 => '2 Stars',
            1 => '1 Star'
        );
        foreach ($ratings as $value => $label) {
            ?>
            <option value="<?php echo $value; ?>" <?php selected($value, get_post_meta( $selected_rating, '_review_rating', true ) ); ?>><?php echo $label; ?></option>
            <?php
        }
        ?>
    </select>
</div>