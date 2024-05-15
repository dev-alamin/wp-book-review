<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>
<div class="container">
    <div class="row">
            <div class="col-lg-12">
                <div class="wbr-review-form-toggler">
                    <?php 
                    $current_user_has_post = count_user_posts( get_current_user_id(), 'review', true );
                    $user_has_consent = get_user_meta( get_current_user_id(), 'user_agreement_consent', true );

                    if( true == $user_has_consent || ! empty( $user_has_consent ) ): ?>

                        <button class="old-user">Write a review</button>

                        <?php elseif( empty( $user_has_consent ) || false == $user_has_consent ): ?>
						<button class="first-reviewer" data-bs-toggle="modal" data-bs-target="#wbrUserAgreement">Start Writing Review</button>
					
                        <?php 
							$file = __DIR__ . '/views/user-agreement-modal.php'; 
							if( file_exists( $file ) ) {
								include $file;
							}else{
								echo 'File does not exist';
							}
						?>

                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-12">
                <div id="review-submission-form form-submission">
                        <h2>Submit a Review</h2>
                        <form id="review-form" class="form row gx-3 gy-2 align-items-center" action="" method="post" enctype="multipart/form-data">
                            <div class="col-lg-12">
                                <input type="hidden" name="review_nonce" id="review-nonce" value="<?php echo wp_create_nonce( 'submit_review' ); ?>">
                                
                                <div class="form-group">
                                    <label for="review-title">Review Title:</label>
                                    <input type="text" class="form-control submit-review-text" name="review-title" id="review-title">
                                </div>

                                <div class="form-group">
                                    <label for="review-content">Your Review:</label>
                                    <textarea class="form-control textarea-book-reviwe" name="review-content" id="review-contents"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 review-upload-image">
                                <?php include __DIR__ . '/views/component/image-uploader.php'; ?> 
                                <input type="hidden" name="user-id" id="user-id" value="<?php echo get_current_user_id(); ?>">
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="visually-hidden" for="product-id">Select Product:</label>
                                    <select class="form-select select2 js-example-basic-single js-states form-control" style="width: 100%" name="product-id" id="product-id" required>
                                        <option value="">Select a Product</option>
                                        <?php
                                        // Query to retrieve all products
                                        $products_query = new \WP_Query(array(
                                            'post_type'      => 'product',
                                            'posts_per_page' => -1,
                                            'post_status'   => 'publish'
                                        ));

                                        if ($products_query->have_posts()) {
                                            while ($products_query->have_posts()) {
                                                $products_query->the_post();
                                                ?>
                                                <option value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
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
                                        <option selected value="">Your rating</option>
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Stars</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <label class="visually-hidden" for="publish-status">Publish later:</label>
                                <select class="form-select" name="publish-status" id="publish-status">
                                    <option selected value="">Choose status</option>
                                    <option value="publish">Publish</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="visually-hidden" for="campaign_id">Select Campaign:</label>
                                    <select class="form-select form-control" style="width: 100%" name="campaign_id" id="campaign_id">
                                        <option value="">Select a Campaign</option>
                                        <?php
                                        // Query to retrieve all products
                                        $products_query = new WP_Query(array(
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
                                        
                                        if ($products_query->have_posts()) {
                                            while ($products_query->have_posts()) {
                                                $products_query->the_post();
                                                ?>
                                                <option value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
                                                <?php
                                            }
                                        }
                                        wp_reset_postdata(); // Restore global post data
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <input type="submit" class="ct-form-submit-btn" name="publish" value="Submit Review">
                            </div>
                        </form>
                    </div>
            </div>
    </div>
</div>