<?php
$post_id = $_GET['reviewid']; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div id="review-submission-form form-submission">
                <h2><?php echo 'Edit Review'; ?></h2>
                <form id="review-edit-form" class="form row gx-3 gy-2 align-items-center" action="" method="post" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <input type="hidden" name="review_nonce" id="review-nonce" value="<?php echo wp_create_nonce( 'edit_review' ); ?>">
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
                        <!-- Product / Book Selection section  -->
                        <?php include __DIR__ . '/edit/product.php'; ?>
                    </div>
                    <div class="col-lg-6">
                    <!-- Rating Selection  -->
                    <?php include __DIR__ . '/edit/rating.php'; ?>

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
                        <!-- Campaign Selection  -->
                        <?php include __DIR__ . '/edit/campaign.php'; ?>
                    </div>
                    <div class="col-lg-12 text-center mb-4 mt-3">
                        <input type="submit" class="ct-form-submit-btn" name="publish" value="<?php echo isset($_GET['reviewid']) ? 'Update Review' : 'Submit Review'; ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
