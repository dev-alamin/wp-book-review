<?php
get_header();
// Query to retrieve all products
$products_query = new WP_Query(array(
    'post_type'      => 'review-campaign',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    // 'meta_query'     => array(
    //     array(
    //         'key'     => '_last_submission_date',
    //         'value'   => date('Y-m-d'),
    //         'compare' => '>=',
    //         'type'    => 'DATE'
    //     )
    // )
));

if ($products_query->have_posts()) { ?>
<?php 
    while ($products_query->have_posts()) {
        $products_query->the_post();
        $post_thumbnail = get_the_post_thumbnail_url();
        ?>
        <div class="bk-campaign-heading">
            <div class="heading">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_content(); ?>
            </div>
        </div>
        <div class="campaign-wrapper">
            <div class="card">
                <div class="card-banner" style="background-image: url(https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg)">
                    <div class="category-tag">
                        <svg width="35px" height="20px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                            <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                        </svg>
                    </div>
                    <div class="card-body">
                        <h2 class="blog-title">What is the most popular burger?</h2>
                        <p class="blog-description">Mediation has transformed my life. These are the best practices to get into the habit</p>
                    </div>
                </div>
                

                <div class="item-price">
                    <div class="price"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="16" class="css-1ug5ziw-ChallengeTile"><path d="M8 13.5v-3m-2 3h4a2 2 0 012 2H4a2 2 0 012-2zm6-12h3v3c0 .796-.316 1.559-.879 2.121A2.996 2.996 0 0112 7.5m-8-6H1v3c0 .796.316 1.559.879 2.121A2.996 2.996 0 004 7.5" fill="none" stroke="#fff"></path><path d="M4 .5h8v6a3.995 3.995 0 01-1.172 2.828 3.995 3.995 0 01-5.656 0A3.995 3.995 0 014 6.5v-6z" fill="none" stroke="#fff"></path></svg>$500<!-- --> Grand Prize</div>
                    <div class="price-time"><svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" class="css-1jdzpf4-TimeRemaining"><path d="M8 15A7 7 0 108 1a7 7 0 000 14z" fill="none" stroke="#fff"></path><path d="M8 4v4h4" fill="none" stroke="#fff"></path></svg>3 days left</div>
                </div>
            </div>
            <div class="card">
                <div class="card-banner" style="background-image: url(https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg)">
                    <div class="category-tag">
                        <svg width="35px" height="20px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                            <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                        </svg>
                    </div>
                    <div class="card-body">
                        <h2 class="blog-title">What is the most popular burger?</h2>
                        <p class="blog-description">Mediation has transformed my life. These are the best practices to get into the habit</p>
                    </div>
                </div>
                

                <div class="item-price">
                    <div class="price"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="16" class="css-1ug5ziw-ChallengeTile"><path d="M8 13.5v-3m-2 3h4a2 2 0 012 2H4a2 2 0 012-2zm6-12h3v3c0 .796-.316 1.559-.879 2.121A2.996 2.996 0 0112 7.5m-8-6H1v3c0 .796.316 1.559.879 2.121A2.996 2.996 0 004 7.5" fill="none" stroke="#fff"></path><path d="M4 .5h8v6a3.995 3.995 0 01-1.172 2.828 3.995 3.995 0 01-5.656 0A3.995 3.995 0 014 6.5v-6z" fill="none" stroke="#fff"></path></svg>$500<!-- --> Grand Prize</div>
                    <div class="price-time"><svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" class="css-1jdzpf4-TimeRemaining"><path d="M8 15A7 7 0 108 1a7 7 0 000 14z" fill="none" stroke="#fff"></path><path d="M8 4v4h4" fill="none" stroke="#fff"></path></svg>3 days left</div>
                </div>
            </div>
            <div class="card">
                <div class="card-banner" style="background-image: url(https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg)">
                    <div class="category-tag">
                        <svg width="35px" height="20px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                            <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                        </svg>
                    </div>
                    <div class="card-body">
                        <h2 class="blog-title">What is the most popular burger?</h2>
                        <p class="blog-description">Mediation has transformed my life. These are the best practices to get into the habit</p>
                    </div>
                </div>
                

                <div class="item-price">
                    <div class="price"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="16" class="css-1ug5ziw-ChallengeTile"><path d="M8 13.5v-3m-2 3h4a2 2 0 012 2H4a2 2 0 012-2zm6-12h3v3c0 .796-.316 1.559-.879 2.121A2.996 2.996 0 0112 7.5m-8-6H1v3c0 .796.316 1.559.879 2.121A2.996 2.996 0 004 7.5" fill="none" stroke="#fff"></path><path d="M4 .5h8v6a3.995 3.995 0 01-1.172 2.828 3.995 3.995 0 01-5.656 0A3.995 3.995 0 014 6.5v-6z" fill="none" stroke="#fff"></path></svg>$500<!-- --> Grand Prize</div>
                    <div class="price-time"><svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" class="css-1jdzpf4-TimeRemaining"><path d="M8 15A7 7 0 108 1a7 7 0 000 14z" fill="none" stroke="#fff"></path><path d="M8 4v4h4" fill="none" stroke="#fff"></path></svg>3 days left</div>
                </div>
            </div>
            <div class="card">
                <div class="card-banner" style="background-image: url(https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg)">
                    <div class="category-tag">
                        <svg width="35px" height="20px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                            <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                        </svg>
                    </div>
                    <div class="card-body">
                        <h2 class="blog-title">What is the most popular burger?</h2>
                        <p class="blog-description">Mediation has transformed my life. These are the best practices to get into the habit</p>
                    </div>
                </div>
                <div class="item-price">
                    <div class="price"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="16" class="css-1ug5ziw-ChallengeTile"><path d="M8 13.5v-3m-2 3h4a2 2 0 012 2H4a2 2 0 012-2zm6-12h3v3c0 .796-.316 1.559-.879 2.121A2.996 2.996 0 0112 7.5m-8-6H1v3c0 .796.316 1.559.879 2.121A2.996 2.996 0 004 7.5" fill="none" stroke="#fff"></path><path d="M4 .5h8v6a3.995 3.995 0 01-1.172 2.828 3.995 3.995 0 01-5.656 0A3.995 3.995 0 014 6.5v-6z" fill="none" stroke="#fff"></path></svg>$500<!-- --> Grand Prize</div>
                    <div class="price-time"><svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" class="css-1jdzpf4-TimeRemaining"><path d="M8 15A7 7 0 108 1a7 7 0 000 14z" fill="none" stroke="#fff"></path><path d="M8 4v4h4" fill="none" stroke="#fff"></path></svg>3 days left</div>
                </div>
            </div>
            <div class="card">
                <div class="card-banner" style="background-image: url(https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg)">
                    <div class="category-tag">
                        <svg width="35px" height="20px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                            <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                        </svg>
                    </div>
                    <div class="card-body">
                        <h2 class="blog-title">What is the most popular burger?</h2>
                        <p class="blog-description">Mediation has transformed my life. These are the best practices to get into the habit</p>
                    </div>
                </div>
                

                <div class="item-price">
                    <div class="price"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="16" class="css-1ug5ziw-ChallengeTile"><path d="M8 13.5v-3m-2 3h4a2 2 0 012 2H4a2 2 0 012-2zm6-12h3v3c0 .796-.316 1.559-.879 2.121A2.996 2.996 0 0112 7.5m-8-6H1v3c0 .796.316 1.559.879 2.121A2.996 2.996 0 004 7.5" fill="none" stroke="#fff"></path><path d="M4 .5h8v6a3.995 3.995 0 01-1.172 2.828 3.995 3.995 0 01-5.656 0A3.995 3.995 0 014 6.5v-6z" fill="none" stroke="#fff"></path></svg>$500<!-- --> Grand Prize</div>
                    <div class="price-time"><svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" class="css-1jdzpf4-TimeRemaining"><path d="M8 15A7 7 0 108 1a7 7 0 000 14z" fill="none" stroke="#fff"></path><path d="M8 4v4h4" fill="none" stroke="#fff"></path></svg>3 days left</div>
                </div>
            </div>
            <div class="card">
                <div class="card-banner" style="background-image: url(https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg)">
                    <div class="category-tag">
                        <svg width="35px" height="20px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                            <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                        </svg>
                    </div>
                    <div class="card-body">
                        <h2 class="blog-title">What is the most popular burger?</h2>
                        <p class="blog-description">Mediation has transformed my life. These are the best practices to get into the habit</p>
                    </div>
                </div>
                

                <div class="item-price">
                    <div class="price"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="16" class="css-1ug5ziw-ChallengeTile"><path d="M8 13.5v-3m-2 3h4a2 2 0 012 2H4a2 2 0 012-2zm6-12h3v3c0 .796-.316 1.559-.879 2.121A2.996 2.996 0 0112 7.5m-8-6H1v3c0 .796.316 1.559.879 2.121A2.996 2.996 0 004 7.5" fill="none" stroke="#fff"></path><path d="M4 .5h8v6a3.995 3.995 0 01-1.172 2.828 3.995 3.995 0 01-5.656 0A3.995 3.995 0 014 6.5v-6z" fill="none" stroke="#fff"></path></svg>$500<!-- --> Grand Prize</div>
                    <div class="price-time"><svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" class="css-1jdzpf4-TimeRemaining"><path d="M8 15A7 7 0 108 1a7 7 0 000 14z" fill="none" stroke="#fff"></path><path d="M8 4v4h4" fill="none" stroke="#fff"></path></svg>3 days left</div>
                </div>
            </div>
        </div>
        <div class="bk-o-campaign">
            <div class="bk-oc-heading">
                <h5>Recent Winners</h5>
            </div>
        </div>
        <div class="bk-recent-posts">
            <div class="bk-recent-post">
                <div class="bk-thumbnail-img">
                    <a href="#"><img src="<?php echo  $post_thumbnail; ?>" alt=""></a>
                </div>
                <div class="bk-user-avatar">
                    <a href="#">
                        <svg width="30px" height="17px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                            <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                        </svg>
                        <img class="author-img" src="<?php echo  $post_thumbnail; ?>" alt="">
                    </a>
                </div>
                <div class="bk-recent-info">
                    <a href="#">Admin</a>
                    <h3><a href="#">this is a title</a></h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti, optio?</p>
                </div>
            </div>
            <div class="bk-recent-post">
                <div class="bk-thumbnail-img">
                    <a href="#"><img src="<?php echo  $post_thumbnail; ?>" alt=""></a>
                </div>
                <div class="bk-user-avatar">
                    <a href="#">
                        <svg width="30px" height="17px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                            <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                        </svg>
                        <img class="author-img" src="<?php echo  $post_thumbnail; ?>" alt="">
                    </a>
                </div>
                <div class="bk-recent-info">
                    <a href="#">Admin</a>
                    <h3><a href="#">this is a title</a></h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti, optio?</p>
                </div>
            </div>
            <div class="bk-recent-post">
                <div class="bk-thumbnail-img">
                    <a href="#"><img src="<?php echo  $post_thumbnail; ?>" alt=""></a>
                </div>
                <div class="bk-user-avatar">
                    <a href="#">
                        <svg width="30px" height="17px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                            <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                        </svg>
                        <img class="author-img" src="<?php echo  $post_thumbnail; ?>" alt="">
                    </a>
                </div>
                <div class="bk-recent-info">
                    <a href="#">Admin</a>
                    <h3><a href="#">this is a title</a></h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti, optio?</p>
                </div>
            </div>
            <div class="bk-recent-post">
                <div class="bk-thumbnail-img">
                    <a href="#"><img src="<?php echo  $post_thumbnail; ?>" alt=""></a>
                </div>
                <div class="bk-user-avatar">
                    <a href="#">
                        <svg width="30px" height="17px" viewBox="0 0 35 20" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100%" height="100%" rx="4" fill="#FA2562"></rect>
                            <path d="M13.571 14l2.656-8h-1.815l-1.804 5.625h-.023L10.804 6H9l2.588 8h1.983zM22.03 6h1.613v3.194h3.177v1.612h-3.177V14H22.03v-3.194h-3.178V9.194h3.178V6z" fill="#fff"></path>
                        </svg>
                        <img class="author-img" src="<?php echo  $post_thumbnail; ?>" alt="">
                    </a>
                </div>
                <div class="bk-recent-info">
                    <a href="#">Admin</a>
                    <h3><a href="#">this is a title</a></h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti, optio?</p>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <?php 
}
wp_reset_postdata();

get_footer();