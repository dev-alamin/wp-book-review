<?php 
get_header(); ?>
<div class="sing-review-campaign-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="top-left single-top">
                    <div class="thumb">
                        <?php the_post_thumbnail( 'large' ); ?>
                        <div class="desc">
                            <?php the_title( '<h2>', '</h2>' ); ?>
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </div>
                <?php
                $last_submission_date     = carbon_get_post_meta(get_the_ID(), 'last_submission_date' );
                $has_result_declared      = carbon_get_post_meta( get_the_ID(), 'declare_capmaign_result' );
                $last_submission_date_obj = date_create($last_submission_date);
                $today_date_obj           = new DateTime(); // This will automatically use today's date
                        
                if ($last_submission_date_obj < $today_date_obj && $has_result_declared ) {
                    include __DIR__ . '/views/single/single-campaign-winner.php';
                }
                ?>

                <div class="content">
                    <?php the_content(); ?>
                </div>
            </div>
        <div class="col-lg-5">
            <div class="single-top review-campaign-meta-info">
                <div class="join-cta single-meta">
                    <a href="/login">Join FajrFair to Enter</a>
                    <p>Already have a FajrFair account? <a href="/login">Login</a></p>
                </div>
                <div class="single-meta prize-details">
                    <div class="icon">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <?php 
                    $prizes = carbon_get_post_meta( get_the_ID(), 'prizes' );
                    if ( ! empty( $prizes ) ) :
                    ?>
                        <ul>
                            <?php foreach ( $prizes as $prize ) : ?>
                                <li><?php echo wp_kses_post( $prize['prize_name'] ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <?php include __DIR__ . '/views/single/single-campaign-time-table.php'; ?>
            </div>
        </div>
    </div>
</div>
<div class="submission-heading">
    <h2>Latest submissions</h2>
    <a href="#">Explore all</a>
</div>
<div class="last-submission-container">
    <div class="row justify-content-between">
        <div class="col-12 col-lg-3 col-md-6 col-sm-6">
            <div class="last-submission-wrap">
                <div class="post-image">
                    <a href="#"><img src="https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg" alt=""></a>
                </div>
                <div class="post-info">
                    <h2>this is a title</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam iste fugit quasi alias, incidunt minus. Soluta quae architecto voluptas eveniet.</p>
                </div>
                <div class="author">
                    <div class="author-img">
                        <a href="#"><img src="https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg" alt=""></a>
                    </div>
                    <div class="author-info">
                        <h4>Jhon Dho</h4>
                        <p>about 3 hours ago in Wander</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 col-md-6 col-sm-6">
            <div class="last-submission-wrap">
                <div class="post-image">
                    <a href="#"><img src="https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg" alt=""></a>
                </div>
                <div class="post-info">
                    <h2>this is a title</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam iste fugit quasi alias, incidunt minus. Soluta quae architecto voluptas eveniet.</p>
                </div>
                <div class="author">
                    <div class="author-img">
                        <a href="#"><img src="https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg" alt=""></a>
                    </div>
                    <div class="author-info">
                        <h4>Jhon Dho</h4>
                        <p>about 3 hours ago in Wander</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 col-md-6 col-sm-6">
            <div class="last-submission-wrap">
                <div class="post-image">
                    <a href="#"><img src="https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg" alt=""></a>
                </div>
                <div class="post-info">
                    <h2>this is a title</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam iste fugit quasi alias, incidunt minus. Soluta quae architecto voluptas eveniet.</p>
                </div>
                <div class="author">
                    <div class="author-img">
                        <a href="#"><img src="https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg" alt=""></a>
                    </div>
                    <div class="author-info">
                        <h4>Jhon Dho</h4>
                        <p>about 3 hours ago in Wander</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 col-md-6 col-sm-6">
            <div class="last-submission-wrap">
                <div class="post-image">
                    <a href="#"><img src="https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg" alt=""></a>
                </div>
                <div class="post-info">
                    <h2>this is a title</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam iste fugit quasi alias, incidunt minus. Soluta quae architecto voluptas eveniet.</p>
                </div>
                <div class="author">
                    <div class="author-img">
                        <a href="#"><img src="https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg" alt=""></a>
                    </div>
                    <div class="author-info">
                        <h4>Jhon Dho</h4>
                        <p>about 3 hours ago in Wander</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 col-md-6 col-sm-6">
            <div class="last-submission-wrap">
                <div class="post-image">
                    <a href="#"><img src="https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg" alt=""></a>
                </div>
                <div class="post-info">
                    <h2>this is a title</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam iste fugit quasi alias, incidunt minus. Soluta quae architecto voluptas eveniet.</p>
                </div>
                <div class="author">
                    <div class="author-img">
                        <a href="#"><img src="https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg" alt=""></a>
                    </div>
                    <div class="author-info">
                        <h4>Jhon Dho</h4>
                        <p>about 3 hours ago in Wander</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bk-campaign-heading campaign-single">
    <div class="heading">
        <h3><a href="#">Open challenges</a></h3>
        <p>Challenges you can enter now for a chance to win.</p>
    </div>
</div>
<div class="campaign-wrapper campaign-single-bg">
        <div class="card">
            <div class="card-banner" style="background-image: url(https://dev-to-uploads.s3.amazonaws.com/uploads/articles/nfz3z2osldbm8ymanmoq.jpg);">
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
<?php get_footer();