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
    'orderby' => 'meta_value_num',
] );

if ($query->have_posts()) {
    $sorted_posts = [];
    echo '<div class="css-1iq6df2-Stack"><ol class="css-n40nsq-Stack">';
    while ($query->have_posts()) {
        $query->the_post();
        $campaign_winner_position = carbon_get_post_meta(get_the_ID(), '_review_winner_option');

        if( $campaign_winner_position !== 'default' ):
            
            // Determine the icon URL based on the meta data value
            $icon_url = '';
            switch ($campaign_winner_position) {
                case '1':
                    $icon_url = 'https://res.cloudinary.com/jerrick/image/upload/c_fit,h_46,q_auto,w_46/65d3888a68c0b9001dff852f.svg';
                    break;
                case '2':
                    $icon_url = 'https://res.cloudinary.com/jerrick/image/upload/c_fit,h_46,q_auto,w_46/65d3889a003b2a001d60cadd.svg';
                    break;
                case '3':
                    $icon_url = 'https://res.cloudinary.com/jerrick/image/upload/c_fit,h_46,q_auto,w_46/65d388ab7c2af2001dc1ba43.png';
                    break;
                // Add more cases for other possible values if needed
                default:
                    // Default icon URL if meta value doesn't match any case
                    $icon_url = 'https://res.cloudinary.com/jerrick/image/upload/c_fit,h_46,q_auto,w_46/65d388b5625c07001c2b1ca1.png';
                    break;
            }

            ?>
            <li class="css-clqcwg-WinningSubmissionsItem">
                <div class="css-135czbg-Box" style="margin-left: var(--flex-column-gap); margin-top: var(--flex-row-gap);">
                    <span class="css-xbbxo2-Image">
                        <img alt="" src="<?php echo esc_url($icon_url); ?>" class="css-d4o6ih-Box">
                    </span>
                </div>
                <div class="css-tmez72-Flex-Track" style="margin-left: var(--flex-column-gap); margin-top: var(--flex-row-gap);">
                    <div class="css-9nhow0-Stack">
                        <h3 class="css-xry9lh-Heading">
                            <a class="css-edl77t-TextLink-TextLink" href="<?php echo get_permalink(); ?>">
                                <span class="css-hxndjc-Track-TextLink">
                                    <span class="css-12xm57y-Flex-Track">
                                        <span class="css-q7znrj-Text"><?php echo get_the_title(); ?></span>
                                    </span>
                                </span>
                            </a>
                        </h3>
                        <div class="css-1vltnl5-Box">
                            <p class="css-f9m7v0-Text">
                                <span class="css-1puhnsk-Text">By</span>
                                <?php echo get_the_author_meta('display_name'); ?>
                                <span aria-label="Published <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago" role="text" class="css-8qj45b-TimeAgo"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</span>
                            </p>
                        </div>
                    </div>
                </div>
            </li>
            <?php
        endif;
    }
    echo '</ol>';
    // echo '<p class="css-h0upcn-Text">This challenge has now concluded. <a class="css-hp162s-TextLink-TextLink" href="/challenges/love-unraveled/submissions"><span class="css-hxndjc-Track-TextLink"><span class="css-12xm57y-Flex-Track"><span class="css-q7znrj-Text">View all winners and submissions</span></span></span></a>.</p>
    echo '</div>';
    wp_reset_postdata();
}
?>

</div>