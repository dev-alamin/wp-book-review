<div class="winners-list">
<?php
$product_id = carbon_get_post_meta(get_the_ID(), 'wc_product_id');
$current_post_slug = get_post_field('post_name', get_the_ID());
// $args = array(
//     'post_type'      => 'review',
//     'posts_per_page' => -1, // Retrieve all posts
//     'meta_query'     => array(
//         array(
//             'key'     => '_product_id',
//             'value'   => $product_id,
//             'compare' => '=', // Use '=' to match exact value
//         ),
//     ),
// );
// $query = new WP_Query($args);

$query = new WP_Query( [
    'post_type'      => 'review',
    'posts_per_page' => -1,
    'tax_query'      => [
        [
            'taxonomy' => 'campaign_review',
            'field'    => 'slug',
            'terms'    => $current_post_slug,
        ],
    ],
    'meta_key' => '__review_winner_option',
    'order'    => 'ASC',
    'orderby'  => 'meta_value_num',
] );

if ($query->have_posts()) {
    $sorted_posts = [];
    ?>
    <div class="large-title-icon">
        <img src="<?php echo BOOK_REVIEW_ASSETS . '/images/review-image/result.png'; ?>" />
        <span>ফলাফল</span>
    </div>
    <?php
    $increament_number = 0;
    while ($query->have_posts()) {
        $query->the_post();
        $index = $increament_number++;
        $campaign_winner_position = carbon_get_post_meta(get_the_ID(), '_review_winner_option');

        if( $campaign_winner_position !== 'default' ):
            
            // Determine the icon URL based on the meta data value
            $icon_url = '';
            switch ( $campaign_winner_position ) {
                case '1':
                    $icon_url = BOOK_REVIEW_ASSETS . '/images/review-image/first.png';
                    break;
                case '2':
                    $icon_url = BOOK_REVIEW_ASSETS . '/images/review-image/first-two.png';
                    break;
                case '3':
                    $icon_url = BOOK_REVIEW_ASSETS . '/images/review-image/third.png';
                    break;
                // Add more cases for other possible values if needed
                default:
                    // Default icon URL if meta value doesn't match any case
                    $icon_url = BOOK_REVIEW_ASSETS . '/images/review-image/badge.png';
                    break;
            }

            ?>

                    <div class="small-title-icon with-number">
                        <span><?php echo esc_html_e( $campaign_winner_position, 'wbr' ); ?></span>
                        <img src="<?php echo esc_url( $icon_url ); ?>" />
                        <div class="small-title-content"><?php echo get_the_author_meta( 'display_name' ); ?></div>
                    </div>
            <?php
        endif;
    }
    // echo '<p class="css-h0upcn-Text">This challenge has now concluded. <a class="css-hp162s-TextLink-TextLink" href="/challenges/love-unraveled/submissions"><span class="css-hxndjc-Track-TextLink"><span class="css-12xm57y-Flex-Track"><span class="css-q7znrj-Text">View all winners and submissions</span></span></span></a>.</p>
    ?>
    <div class="all-review mt-20">
        <a href="#">
            সম্পূর্ণ লিস্ট দেখুন                         
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.9763 10.0006L6.85156 5.87577L8.03007 4.69727L13.3334 10.0006L8.03007 15.3038L6.85156 14.1253L10.9763 10.0006Z" fill="#2A007C"/>
            </svg>
        </a>
    </div>
    <?php 
    wp_reset_postdata();
}
?>

</div>