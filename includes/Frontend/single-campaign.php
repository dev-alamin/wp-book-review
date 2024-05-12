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
<?php get_footer();