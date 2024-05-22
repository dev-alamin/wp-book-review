<div class="form-group">
    <label class="visually-hidden" for="product-id">Select Product:</label>
    <select class="form-select select2 js-example-basic-single js-states form-control" style="width: 100%" name="product-id" id="product-id" required>
        <option value="">Select a Product</option>
        <?php
        // Query to retrieve all products
        $products_query = new WP_Query(array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish'
        ));

        if ($products_query->have_posts()) {
            while ($products_query->have_posts()) {
                $products_query->the_post();
                $product_id = get_the_ID();
                $product_title = get_the_title();
                ?>
                <option value="<?php echo $product_id; ?>" <?php selected($product_id, get_post_meta(  $_GET['reviewid'], '_product_id', true )); ?>><?php echo $product_title; ?></option>
                <?php
            }
        }
        wp_reset_postdata(); // Restore global post data
        ?>
    </select>
</div>