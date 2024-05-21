<?php 
$post_id = $_GET['reviewid']; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div id="review-submission-form form-submission">
                <h2><?php echo 'Edit Review'; ?></h2>
                <form id="review-form" class="form row gx-3 gy-2 align-items-center" action="" method="post" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <input type="hidden" name="review_nonce" id="review-nonce" value="<?php echo isset($_GET['reviewid']) ? wp_create_nonce( 'edit_review_' . $_GET['reviewid'] ) : wp_create_nonce( 'submit_review' ); ?>">
                        <?php if(isset($_GET['reviewid'])): ?>
                        <input type="hidden" name="review_id" value="<?php echo $_GET['reviewid']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="review-title">Review Title:</label>
                            <input type="text" class="form-control submit-review-text" name="review-title" id="review-title" value="<?php echo isset($_GET['reviewid']) ? esc_attr(get_the_title($_GET['reviewid'])) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="review-content">Your Review:</label>
                            <textarea class="form-control textarea-book-reviwe" name="review-content" id="review-contents"><?php echo isset($_GET['reviewid']) ? wp_kses_post( get_post_field( 'post_content', $post_id ) ) : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 review-upload-image">
                        <?php include __DIR__ . '/../views/component/image-uploader.php'; ?> 
                        <input type="hidden" name="user-id" id="user-id" value="<?php echo get_current_user_id(); ?>">
                    </div>
                    <div class="col-lg-6">
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
                    </div>
                    <div class="col-lg-6">
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

                    </div>
                    
                    <div class="col-lg-6">
                        <label class="visually-hidden" for="publish-status">Publish later:</label>
                        <select class="form-select" name="publish-status" id="publish-status">
                            <option value="">Choose status</option>
                            <option value="publish" <?php selected(get_post_status( $post_id ) ?? '', 'publish'); ?>>Publish</option>
                            <option value="draft" <?php selected(get_post_status( $post_id ) ?? '', 'draft'); ?>>Draft</option>
                        </select>

                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="visually-hidden" for="campaign_id">Select Campaign:</label>
                        
                            <?php
                            $campaign_id = get_post_meta($post_id, '_campaign_id', true);

                            $campaigns_query = new WP_Query(array(
                                'post_type'      => 'review-campaign',
                                'posts_per_page' => -1,
                                'post_status'    => 'publish',
                                'meta_query'     => array(
                                    array(
                                        'key'     => '_last_submission_date',
                                        'value'   => date('Y-m-d'),
                                        'compare' => '>=',
                                        'type'    => 'DATE'
                                    )
                                )
                            ));
                            ?>

                        <select class="form-select form-control" style="width: 100%" name="campaign_id" id="campaign_id">
                            <option value="">Select a Campaign</option>
                            <?php
                            if ($campaigns_query->have_posts()) {
                                while ($campaigns_query->have_posts()) {
                                    $campaigns_query->the_post();
                                    $campaign_option_id = get_the_ID();
                                    $campaign_option_title = get_the_title();
                                    ?>
                                    <option value="<?php echo $campaign_option_id; ?>" <?php selected($campaign_id, $campaign_option_id); ?>><?php echo $campaign_option_title; ?></option>
                                    <?php
                                }
                            }
                            wp_reset_postdata(); // Restore global post data
                            ?>
                        </select>

                        </div>
                    </div>
                    <div class="col-lg-12 text-center mb-4 mt-3">
                        <input type="submit" class="ct-form-submit-btn" name="publish" value="<?php echo isset($_GET['reviewid']) ? 'Update Review' : 'Submit Review'; ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
