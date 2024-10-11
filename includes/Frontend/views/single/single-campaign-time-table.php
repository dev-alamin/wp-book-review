
<?php
$first_submission_date = carbon_get_post_meta( get_the_ID(), 'first_submission_date' );
$last_submission_date  = carbon_get_post_meta( get_the_ID(), 'last_submission_date' );
$result_publish_date   = carbon_get_post_meta( get_the_ID(), 'result_publish_date' );
?>

<div class="large-title-icon mt-20">
    <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/review-image/calender.svg'; ?>" />
    <span>সময়সীমা</span>
</div>

<div class="small-title-icon">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20ZM15.5355 7.05025L16.9497 8.46447L12 13.4142L10.5858 12L15.5355 7.05025Z" fill="#2A007C"/> </svg>
    <div class="small-title-content"><strong>শেষ সময়ঃ </strong><?php echo esc_html_e( $last_submission_date, 'wbr' ); ?></div>
</div>

<div class="small-title-icon">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M12 3V7H3V3H12ZM16 17V21H3V17H16ZM22 10V14H3V10H22Z" fill="#2A007C"/> </svg>
    <div class="small-title-content"><strong>ফলাফল প্রকাশঃ </strong><?php echo esc_html_e( $result_publish_date, 'wbr' ); ?></div>
</div>