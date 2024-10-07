<div class="container">
    <div class="row">
        <div class="col-lg-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">

        <div class="col-lg-12">
            <div id="review-submission-form" class="form-submission">
                <h2>রিভিউ সাবমিট করুন</h2>
                <div class="review-submit-wrapper">
                    <div class="review-form">
                        <h3>রিভিউ ফর্ম</h3>
                        <form id="review-form" class="form row gx-3 gy-2 align-items-center" action="" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="review_nonce" id="review-nonce" value="<?php echo wp_create_nonce( 'submit_review' ); ?>">

                        <div class="form-group">
                            <label class="form-title" for="product-id">বই সিলেক্ট করুন *</label>
                            <select class="form-select select2 js-example-basic-single js-states form-control" style="width: 100%" name="product-id" id="product-id" required>
                                <option value="">- সিলেক্ট করুন -</option>
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
                        
                        <div class="review-upload-image">
                            <label class="form-title">কভার * </label>
                            <?php include __DIR__ . '/../views/component/image-uploader.php'; ?> 
                            <input type="hidden" name="user-id" id="user-id" value="<?php echo get_current_user_id(); ?>">
                        </div>
                                
                        <div class="form-group">
                            <label class="form-title" for="review-title">রিভিউ টাইটেল *</label>
                            <input type="text" class="form-control submit-review-text" name="review-title" id="review-title" placeholder="সংক্ষেপে আপনার রিভিউ এর একটি টাইটেল দিন">
                        </div>

                        <div class="form-group">
                            <label class="form-title" for="review-content">রিভিউ লিখুন *</label>
                            <textarea class="form-control textarea-book-reviwe" name="review-content" id="review-contents"></textarea>
                        </div>
                        
                        <div class="form-group review-star-icon">
                            <p class="form-title">বই এর রেটিং দিন *</p>
                            <label for="field_1" class="star">
                                <input type="radio" id="field_1" name="review-rating" value="1">                                
                                <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.0011 33.4767L9.06973 40.715L11.9578 26.1798L1.07776 16.1183L15.794 14.3734L22.0011 0.916656L28.208 14.3734L42.9242 16.1183L32.0442 26.1798L34.9323 40.715L22.0011 33.4767Z" fill="#DADADA"/>
                                </svg>
                            </label>
                            <label for="field_2" class="star">
                                <input type="radio" id="field_2" name="review-rating" value="2">                                
                                <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.0011 33.4767L9.06973 40.715L11.9578 26.1798L1.07776 16.1183L15.794 14.3734L22.0011 0.916656L28.208 14.3734L42.9242 16.1183L32.0442 26.1798L34.9323 40.715L22.0011 33.4767Z" fill="#DADADA"/>
                                </svg>
                            </label>
                            <label for="field_3" class="star">
                                <input type="radio" id="field_3" name="review-rating" value="3">                                
                                <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.0011 33.4767L9.06973 40.715L11.9578 26.1798L1.07776 16.1183L15.794 14.3734L22.0011 0.916656L28.208 14.3734L42.9242 16.1183L32.0442 26.1798L34.9323 40.715L22.0011 33.4767Z" fill="#DADADA"/>
                                </svg>
                            </label>
                            <label for="field_4" class="star">
                                <input type="radio" id="field_4" name="review-rating" value="4">                                
                                <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.0011 33.4767L9.06973 40.715L11.9578 26.1798L1.07776 16.1183L15.794 14.3734L22.0011 0.916656L28.208 14.3734L42.9242 16.1183L32.0442 26.1798L34.9323 40.715L22.0011 33.4767Z" fill="#DADADA"/>
                                </svg>
                            </label>
                            <label for="field_5" class="star">
                                <input type="radio" id="field_5" name="review-rating" value="5">                                
                                <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.0011 33.4767L9.06973 40.715L11.9578 26.1798L1.07776 16.1183L15.794 14.3734L22.0011 0.916656L28.208 14.3734L42.9242 16.1183L32.0442 26.1798L34.9323 40.715L22.0011 33.4767Z" fill="#DADADA"/>
                                </svg>
                            </label>
                        </div>

                            
                        <div class="current-campign">
                            <h4><?php esc_html_e( 'আপনার রিভিউ চলমান ক্যাম্পেইন এ সাবমিট করুতে ইচ্ছুক?', 'wbr' ); ?></h4>
                            <p><?php echo esc_html_e( 'চলমান রিভিউ গুলি', 'wbr' ); ?></p>

                            <?php
                                // Query to retrieve all products
                                $campign_query = new WP_Query(array(
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
                                
                                if ($campign_query->have_posts()) { ?>
                                        <div class="current-campign-form">
                                <?php 
                                    while ($campign_query->have_posts()) {
                                        $campign_query->the_post();
                                        ?>
                                        <div class="current-campigin-field">
                                            <label for="<?php echo get_the_ID(); ?>">
                                                <input type="checkbox" name="<?php echo get_the_ID(); ?>" id="<?php echo get_the_ID(); ?>">
                                                <span><?php the_title(); ?></span>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                        </div>
                                    <?php 
                                }
                                wp_reset_postdata(); // Restore global post data
                                ?>
                            </select>
                        </div>
                        <div class="submit-button-here">
                            <input type="submit" id="submit-here" class="ct-form-submit-btn" name="publish" value=" + এখনি সাবমিট করুন">
                            <!-- <input type="submit" id="submit-draft" class="btn-white" name="draft" value="ড্রাফট সেভ করুন"> -->
                            <button type="submit" class="btn-white">ড্রাফট সেভ করুন</button>
                        </div>
                        </form>
                    </div>
                    <!-- end review form -->

                    <div class="review-sidebar">
                        <div class="review-sidebar-inner">
                            <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/notice.png'; ?>" class="background-bg" />
                            <h3>নীতিমালা</h3>
                            <ul>
                                <li>                                    
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11.0026 16L18.0737 8.92893L16.6595 7.51472L11.0026 13.1716L8.17421 10.3431L6.75999 11.7574L11.0026 16Z" fill="#2A007C"/>
                                    </svg>
                                    <span>কপি পেস্ট পোস্ট থেকে বিরত থাকুন।</span>
                                </li>
                                <li>                                    
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11.0026 16L18.0737 8.92893L16.6595 7.51472L11.0026 13.1716L8.17421 10.3431L6.75999 11.7574L11.0026 16Z" fill="#2A007C"/>
                                    </svg>
                                    <span>রিভিউ সহজ এবং সাবলীল রাখুন।</span>
                                </li>
                                <li>                                    
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11.0026 16L18.0737 8.92893L16.6595 7.51472L11.0026 13.1716L8.17421 10.3431L6.75999 11.7574L11.0026 16Z" fill="#2A007C"/>
                                    </svg>
                                    <span>কপিরাইট ইমেজ, বা কন্টেন্ট এর যথাযথ ক্রেডিট দিন।</span>
                                </li>
                            </ul>
                            <button class="first-reviewer btn-white" data-bs-toggle="modal" data-bs-target="#wbrUserAgreement">সম্পূর্ণ নীতিমালা পড়ুন</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script> 
jQuery(document).ready(function($){
    $('.current-campign-form input[type="checkbox"]').on('change', function() {
        // Uncheck all checkboxes except the one that was just clicked
        $('.current-campign-form input[type="checkbox"]').not(this).prop('checked', false);
    });
});
</script>

<?php 
    $file = __DIR__ . '/../views/user-agreement-modal.php'; 
    if( file_exists( $file ) ) {
        include $file;
    }else{
        echo $file . ' File does not exist';
    }
?>