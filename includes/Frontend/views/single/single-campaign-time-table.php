<div class="single-meta time-table">
        <div class="icon">
            <i class="fa-regular fa-calendar"></i>
        </div>
        <div class="single-time">
        <?php
        $first_submission_date = carbon_get_post_meta( get_the_ID(), 'first_submission_date' );
        $last_submission_date  = carbon_get_post_meta( get_the_ID(), 'last_submission_date' );
        $result_publish_date   = carbon_get_post_meta( get_the_ID(), 'result_publish_date' );
        ?>

        <div class="single-time">
            <div class="schedule-headline">
                <h4> <?php echo esc_html( wbr_get_campaign_days_left( get_the_ID() ) ); ?></h4>
            </div>
            <div class="single-schedule">
                <h3>Submission open</h3>
                <p><?php echo date_format( date_create( $first_submission_date ), 'M d, Y' ); ?></p>
            </div>
            <div class="single-schedule">
                <h3>Submission close</h3>
                <p><?php echo date_format( date_create( $last_submission_date ), 'M d, Y' ); ?></p>
            </div>
            <div class="single-schedule">
                <h3>Results</h3>
                <p><?php echo date_format( date_create( $result_publish_date ), 'M d, Y' ); ?></p>
            </div>
        </div>
    </div>
</div>