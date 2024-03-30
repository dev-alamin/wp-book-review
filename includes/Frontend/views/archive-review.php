<?php 
get_header(); 
$archive_featured_review = [
    'post_type'      => 'review',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'ASC',
    
];

$featured_rev = new WP_Query($archive_featured_review);
?>
<div class="wbr-archive-page-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="slider">
                    <!-- <img src="https://images.unsplash.com/photo-1707343848610-16f9afe1ae23?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt=""> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wbr-archive-featured-promo section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="archive-featured-review">
                    <div class="featured-review-top-desc">
                        <div class="left">
                            <h2>Featured review</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, labore.</p>
                        </div>
                        <div class="right">
                            <a href="/review">Read all the review</a>
                        </div>
                    </div>
                    <?php                     
                    if ($featured_rev->have_posts()) {
                        echo '<div id="reviews-container">';
                        while ($featured_rev->have_posts()) {
                            $featured_rev->the_post();
                            wbr_output_review_card(get_the_ID());
                        }
                        wp_reset_postdata();
                        // echo '<div class="load-more-rev-container"><button id="load-more-reviews">Load More Reviews</button></div>';
                        echo '</div>';
                    } else {
                        esc_html_e('No review found.', 'wpr');
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="archive-promo-wrapper">
                    <div class="title">
                        <h2>১০০ বছরের মধ্যে যশোর থেকে গোপালগঞ্জ, গোপালগঞ্জ</h2>
                    </div>
                    <div class="description">
                        <p> ১০০ বছরের মধ্যে যশোর থেকে গোপালগঞ্জ, গোপালগঞ্জ থেকে চাঁদপুর ও চাঁদপুর থেকে ফেনী—এসব 
                            অঞ্চলের দক্ষিণাংশ সমুদ্রের অংশ হয়ে যাবে বলে মনে করেন পানিসম্পদ ও জলবায়ু পরিবর্তন–বিশেষজ্ঞ অধ্যাপক আইনুন নিশাত।</p>
                    </div>
                        <div class="cta">
                            <a href="/review">জেনে নিন আজ</a>
                        </div>
                        <div class="review-outcome">
                            <h4>গোপালগঞ্জ থেকে চাঁদপুর ও চাঁদপুর থেকে - </h4>
                            <ul>
                                <li>Benefit item one </li>
                                <li>Benefit item two </li>
                                <li>Benefit item two </li>
                                <li>Benefit item two </li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wbr-featured-campaign-archive section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="campaign-benefit">
                    <h2>Sukun Publishing Fair Review</h2>
                    <h2>First winner will get 10k taka</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="fetured-campaign-info">
                    <h4>The last date of submission</h4>
                    <div class="featured-sub-last-date">
                        12/12/2025
                    </div>
                    <h2>Time remainign</h2>
                    <div class="timer">
                        <div class="day">120</div>
                        <div class="hour">12</div>
                        <div class="minutes">55</div>
                        <div class="second">25</div>
                    </div>
                    <div class="featured-campaing-cta">
                        <a href="/review">See more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wbr-archive-page-leaderboard section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="leaderboard-title">
                    <h2>জানুয়ারি মাসের লিডারবোর্ড</h2>
                </div>
            </div>
                <div class="col-lg-6">
                    <div class="winner-review single-leaderboard">
                        <h4 class="leaderboard-subtitle">Great reviews</h4>
                        <ul class="leaderboard-list">
                            <li><a href="#">Here is some awesome reveiw</a></li>
                            <li><a href="#">Here is some awesome reveiw</a></li>
                            <li><a href="#">Here is some awesome reveiw</a></li>
                            <li><a href="#">Here is some awesome reveiw</a></li>
                            <li><a href="#">Here is some awesome reveiw</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="winner-review-books single-leaderboard">
                        <h4 class="leaderboard-subtitle">Great reviewed books</h4>
                        <ul class="leaderboard-list">
                            <li><a href="#">Here is a great reviewed book</a></li>
                            <li><a href="#">Here is a great reviewed book</a></li>
                            <li><a href="#">Here is a great reviewed book</a></li>
                            <li><a href="#">Here is a great reviewed book</a></li>
                            <li><a href="#">Here is a great reviewed book</a></li>
                        </ul>
                    </div>
                </div>
        </div>
    </div>
</div>
<?php 
if ( have_posts() ) {
    echo '<div class="container mt-3">';
    echo '<div class="row" id="reviews-container">';
    while ( have_posts() ) {
        the_post();
        echo '<div class="col-lg-4 col-sm-6 col-xs-12">';
        wbr_output_review_card( get_the_ID() );
        echo '</div>';
    }
    echo '</div>';
    the_posts_pagination();
    // echo '<div class="load-more-rev-container"><button id="load-more-reviews">Load More Reviews</button></div>';
    echo '</div>';
}

get_footer();
?>