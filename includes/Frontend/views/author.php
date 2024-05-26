<?php
/**
 * The template for displaying author archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package YourTheme
 */

get_header();

$author_id     = get_query_var('author');
$author_name   = get_the_author_meta('display_name', $author_id);
$join_date     = get_the_author_meta('user_registered', $author_id);
$author_bio    = get_the_author_meta('description', $author_id);
$review_count  = count_user_posts($author_id, 'review');
$author_avatar = get_avatar(get_the_author_meta('user_email', $author_id), 150);

$author_id = get_query_var('author');

$campaign_posts = new WP_Query( [
    'post_type' => 'review',
    'posts_per_page' => -1,
    'author' => $author_id,
    'meta_query' => [
        [
            'key'     => '__review_winner_option',
            'value'   => wbr_campaign_positions(),
            'compare' => 'IN',
        ]
    ]
] );
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main container" role="main">
            <div class="container">
                <div class="row">
                    <div class="author-profile">
                        <div class="author-avatar">
                            <?php echo $author_avatar; ?>
                            <div class="write-review-button">
                                <a href="<?php echo esc_url(home_url('/submit-review/')); ?>" class="btn btn-primary">Write a Review</a>
                            </div>
                        </div>
                        <div class="author-details">
                            <h2 class="author-name"><?php echo esc_html( ucwords( $author_name ) ); ?></h2>
                            <?php if ($author_bio) : ?>
                                <p class="author-bio"><?php echo $author_bio; ?></p>
                            <?php endif; ?>
                            <div class="author-join-review">
                                <p class="join-date"><i class="fa-solid fa-calendar-days"></i> Joined: <?php echo date('F j, Y', strtotime($join_date)); ?></p>
                                <p class="review-count"><i class="fa-solid fa-file-lines"></i> Total Reviews: <?php echo $review_count; ?></p>
                            </div>
                           
                            <div class="author-achivement mt-3">
                                <h2><?php echo esc_html( ucwords( $author_name . "'s" ) ); ?> Achivement</h2>
                                <div class="author-achievement-price">
                                    <?php 
                           
                                    while ($campaign_posts->have_posts()) {
                                        $campaign_posts->the_post();
                                        $winner_position = get_post_meta(get_the_ID(), '__review_winner_option', true);

                                        if("first" == $winner_position){
                                            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none"><path fill="#D4AF37" fill-rule="evenodd" d="m31.858 4.41.035.01c.91.248 1.689.791 2.259 1.363.567.568 1.106 1.343 1.355 2.247l1.007 3.553.006.022c.195.718.69 1.915 1.032 2.508l.013.024 1.818 3.237.01.019c.444.81.607 1.725.607 2.526 0 .8-.163 1.717-.607 2.526l-.01.019-1.812 3.227c-.364.666-.86 1.875-1.056 2.56l-1.005 3.624-.001.006c-.248.907-.788 1.685-1.357 2.255-.567.569-1.341 1.11-2.246 1.36l-3.544 1.01-.023.005c-.715.196-1.908.69-2.5 1.034l-.023.013-3.23 1.822-.02.01c-.808.446-1.725.61-2.526.61-.8 0-1.717-.164-2.526-.61l-.019-.01-3.22-1.816c-.664-.364-1.869-.86-2.552-1.058L8.107 35.5l-.006-.002c-.907-.25-1.684-.791-2.253-1.362-.567-.568-1.106-1.343-1.355-2.247l-1.007-3.553-.006-.022c-.195-.718-.69-1.915-1.032-2.508l-.013-.024-1.818-3.237-.01-.019C.163 21.716 0 20.801 0 20c0-.8.163-1.717.607-2.526l.01-.019 1.812-3.227c.365-.668.862-1.881 1.058-2.566v-.002l1.006-3.549c.25-.904.788-1.679 1.355-2.247.567-.569 1.341-1.11 2.246-1.36l3.544-1.01.023-.006c.715-.195 1.908-.69 2.5-1.033l.023-.013L17.414.62l.02-.01C18.241.164 19.158 0 19.96 0c.8 0 1.717.164 2.526.61l.019.01 3.22 1.816c.657.36 1.845.851 2.532 1.052l3.601.922Zm-4.186 1.222c-.848-.243-2.22-.81-3.028-1.255l-3.23-1.82c-.808-.446-2.1-.446-2.908 0l-3.23 1.82c-.768.446-2.14 1.012-3.03 1.255L8.694 6.644c-.888.243-1.817 1.174-2.06 2.064L5.625 12.27c-.242.85-.807 2.226-1.251 3.035l-1.818 3.238c-.444.81-.444 2.105 0 2.914l1.818 3.238c.444.769 1.009 2.145 1.251 3.035l1.01 3.562c.242.89 1.17 1.821 2.06 2.064l3.634 1.012c.848.243 2.22.81 3.028 1.255l3.23 1.82c.808.446 2.1.446 2.908 0l3.23-1.82c.768-.446 2.14-1.012 3.03-1.255l3.553-1.012c.888-.243 1.817-1.174 2.06-2.064l1.009-3.643c.242-.85.807-2.226 1.252-3.035l1.817-3.238c.444-.81.444-2.105 0-2.914l-1.818-3.238c-.444-.769-1.009-2.145-1.251-3.035l-1.01-3.562c-.242-.89-1.17-1.821-2.06-2.064l-3.634-.93Z" clip-rule="evenodd"/><path fill="#D4AF37" d="M15.547 15.754c.488 0 .962-.041 1.423-.122.46-.082.873-.217 1.239-.407.38-.19.698-.433.955-.731.27-.298.447-.664.528-1.097h1.89v14.222h-2.54V17.582h-3.495v-1.828Z"/></svg>';
                                        }else if("second" == $winner_position){
                                            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none"><path fill="#BBB" fill-rule="evenodd" d="M31.858 4.41l.035.01c.91.248 1.689.791 2.259 1.363.567.568 1.106 1.343 1.355 2.247l1.007 3.553.006.022c.195.718.69 1.915 1.032 2.508l.013.024 1.818 3.237.01.019c.444.81.607 1.725.607 2.526 0 .8-.163 1.717-.607 2.526l-.01.019-1.812 3.227c-.364.666-.86 1.875-1.056 2.56l-1.005 3.624-.001.006c-.248.907-.788 1.685-1.357 2.255-.567.569-1.341 1.11-2.246 1.36l-3.544 1.01-.023.005c-.715.196-1.908.69-2.5 1.034l-.023.013-3.23 1.822-.02.01c-.808.446-1.725.61-2.526.61-.8 0-1.717-.164-2.526-.61l-.019-.01-3.22-1.816c-.664-.364-1.869-.86-2.552-1.058L8.107 35.5l-.006-.002c-.907-.25-1.684-.791-2.253-1.362-.567-.568-1.106-1.343-1.355-2.247l-1.007-3.553-.006-.022c-.195-.718-.69-1.915-1.032-2.508l-.013-.024-1.818-3.237-.01-.019C.163 21.716 0 20.801 0 20c0-.8.163-1.717.607-2.526l.01-.019 1.812-3.227c.365-.668.862-1.881 1.058-2.566v-.002l1.006-3.549c.25-.904.788-1.679 1.355-2.247.567-.569 1.341-1.11 2.246-1.36l3.544-1.01.023-.006c.715-.195 1.908-.69 2.5-1.033l.023-.013L17.414.62l.02-.01C18.241.164 19.158 0 19.96 0c.8 0 1.717.164 2.526.61l.019.01 3.22 1.816c.657.36 1.845.851 2.532 1.052l3.601.922zm-4.186 1.222c-.848-.243-2.22-.81-3.028-1.255l-3.23-1.82c-.808-.446-2.1-.446-2.908 0l-3.23 1.82c-.768.446-2.14 1.012-3.03 1.255L8.694 6.644c-.888.243-1.817 1.174-2.06 2.064L5.625 12.27c-.242.85-.807 2.226-1.251 3.035l-1.818 3.238c-.444.81-.444 2.105 0 2.914l1.818 3.238c.444.769 1.009 2.145 1.251 3.035l1.01 3.562c.242.89 1.17 1.821 2.06 2.064l3.634 1.012c.848.243 2.22.81 3.028 1.255l3.23 1.82c.808.446 2.1.446 2.908 0l3.23-1.82c.768-.446 2.14-1.012 3.03-1.255l3.553-1.012c.888-.243 1.817-1.174 2.06-2.064l1.009-3.643c.242-.85.807-2.226 1.252-3.035l1.817-3.238c.444-.81.444-2.105 0-2.914l-1.818-3.238c-.444-.769-1.009-2.145-1.251-3.035l-1.01-3.562c-.242-.89-1.17-1.821-2.06-2.064l-3.634-.93z" clip-rule="evenodd"/><path fill="#BBB" d="M24.632 26.888h-9.711c.013-1.179.298-2.208.853-3.089.555-.88 1.314-1.645 2.275-2.296.461-.338.942-.663 1.443-.975.501-.325.962-.67 1.382-1.036.42-.366.765-.759 1.036-1.178.27-.434.413-.928.427-1.483 0-.258-.034-.529-.102-.813a1.974 1.974 0 00-.345-.813 1.967 1.967 0 00-.732-.63c-.311-.176-.718-.264-1.219-.264-.46 0-.846.095-1.158.285a2.052 2.052 0 00-.732.751 4.001 4.001 0 00-.406 1.118c-.081.433-.128.9-.142 1.402h-2.316c0-.786.101-1.51.304-2.174.217-.678.535-1.26.955-1.748.42-.487.928-.867 1.524-1.137.61-.285 1.314-.427 2.113-.427.867 0 1.592.142 2.174.427.583.284 1.05.643 1.402 1.076.366.434.623.908.772 1.423.15.5.224.982.224 1.442 0 .57-.088 1.084-.264 1.544a5.15 5.15 0 01-.712 1.28c-.297.38-.636.732-1.015 1.057-.38.325-.772.63-1.179.914a31.62 31.62 0 01-1.219.813 20.74 20.74 0 00-1.138.772 6.512 6.512 0 00-.894.813c-.257.27-.433.562-.528.873h6.928v2.073z"/></svg>';
                                        }else{
                                            $icon = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="46" height="46">
                                            <path d="M0 0 C5.79895896 3.26459912 7.73031024 9.39497305 9.63671875 15.484375 C10.69851949 22.79900233 8.23306524 29.09612795 4.63671875 35.484375 C-0.23540044 39.95048425 -6.80040089 42.11234398 -13.23828125 43.046875 C-19.33041198 42.72295803 -26.29810132 39.8807884 -31.08203125 36.140625 C-34.8057628 31.3270208 -37.15921501 23.71409988 -36.8203125 17.6640625 C-35.66183715 12.13902623 -33.72599878 5.6501994 -29.48828125 1.765625 C-18.87550905 -4.63325235 -11.21122916 -4.65100928 0 0 Z M-23.36328125 3.484375 C-24.27078125 3.87625 -25.17828125 4.268125 -26.11328125 4.671875 C-29.41605362 7.33244163 -30.12356594 10.5390648 -31.36328125 14.484375 C-31.69328125 15.144375 -32.02328125 15.804375 -32.36328125 16.484375 C-32.83676291 21.57430288 -31.59721567 24.93376786 -29.36328125 29.484375 C-28.97140625 30.391875 -28.57953125 31.299375 -28.17578125 32.234375 C-25.51521462 35.53714737 -22.30859145 36.24465969 -18.36328125 37.484375 C-17.70328125 37.814375 -17.04328125 38.144375 -16.36328125 38.484375 C-11.27335337 38.95785666 -7.91388839 37.71830942 -3.36328125 35.484375 C-2.00203125 34.8965625 -2.00203125 34.8965625 -0.61328125 34.296875 C2.68949112 31.63630837 3.39700344 28.4296852 4.63671875 24.484375 C4.96671875 23.824375 5.29671875 23.164375 5.63671875 22.484375 C5.88458892 18.33933839 5.88458892 18.33933839 4.63671875 14.484375 C3.97671875 14.484375 3.31671875 14.484375 2.63671875 14.484375 C2.57484375 13.22625 2.51296875 11.968125 2.44921875 10.671875 C2.02118014 7.18548338 2.02118014 7.18548338 -0.42578125 4.671875 C-1.39515625 4.28 -2.36453125 3.888125 -3.36328125 3.484375 C-4.00136719 3.20851563 -4.63945312 2.93265625 -5.296875 2.6484375 C-12.41007704 -0.28290096 -16.30772036 0.08258671 -23.36328125 3.484375 Z " fill="#66A1FF" transform="translate(36.36328125,3.515625)"/>
                                            <path d="M0 0 C0.87269531 -0.01417969 1.74539062 -0.02835938 2.64453125 -0.04296875 C5.3394777 0.20127371 6.93732717 0.70096049 9.1875 2.1875 C10.28559194 5.48177581 10.29946276 6.85161172 9.1875 10.1875 C9.28018505 12.25368749 9.28018505 12.25368749 9.625 14.375 C9.810625 15.633125 9.99625 16.89125 10.1875 18.1875 C8.5375 18.5175 6.8875 18.8475 5.1875 19.1875 C4.94 18.218125 4.6925 17.24875 4.4375 16.25 C3.81875 14.7340625 3.81875 14.7340625 3.1875 13.1875 C1.15506452 12.21872943 1.15506452 12.21872943 -0.8125 12.1875 C-0.8125 14.4975 -0.8125 16.8075 -0.8125 19.1875 C-2.1325 19.1875 -3.4525 19.1875 -4.8125 19.1875 C-5.0063211 16.20861874 -5.19285102 13.22959754 -5.375 10.25 C-5.43107422 9.39986328 -5.48714844 8.54972656 -5.54492188 7.67382812 C-5.61743164 6.46049805 -5.61743164 6.46049805 -5.69140625 5.22265625 C-5.7385376 4.4737915 -5.78566895 3.72492676 -5.83422852 2.95336914 C-5.78842096 -0.76939576 -3.06213929 0.02241683 0 0 Z M-0.8125 5.1875 C-0.8125 6.1775 -0.8125 7.1675 -0.8125 8.1875 C0.8375 8.1875 2.4875 8.1875 4.1875 8.1875 C4.1875 7.1975 4.1875 6.2075 4.1875 5.1875 C2.5375 5.1875 0.8875 5.1875 -0.8125 5.1875 Z " fill="#66A1FF" transform="translate(20.8125,13.8125)"/>
                                            </svg>';
                                        }
                                    
                                        $campaign_id = get_post_meta(get_the_ID(), '_campaign_id', true);
                                        $campaign    = get_post($campaign_id);
                                    
                                        // Get campaign title
                                        $campaign_title  = $campaign ? get_the_title($campaign_id) : 'Campaign not found';
                                        $review_title    = get_the_title(get_the_ID());
                                       
                                    
                                        echo '<div class="review-post">';
                                        echo '<div class="campaign-details">';
                                        echo '<div class="campaign-title">'. $icon .' <a href="' . get_the_permalink($campaign_id) . '">' . esc_html($campaign_title) . '</a></div>';
                                        echo '<div class="review-title"><i class="fa-solid fa-pen"></i> <a href="' . get_permalink(get_the_ID()) . '">' . esc_html($review_title) . '</a></div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if( is_user_logged_in() && get_current_user_id() == $author_id ): ?>

                    <?php endif; ?>
                </div>
            </div>
        <hr>
        
                    <?php if( is_user_logged_in() && get_current_user_id() == $author_id ): ?>
                        <?php 
                        $posts_per_page = 5;

                        $author_review_posts_args = array(
                            'post_type'      => 'review',
                            'author'         => $author_id,
                            'posts_per_page' => $posts_per_page,
                            'post_status'    => ['publish', 'pending', 'draft', 'trash', 'private', 'delete_request' ],
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        );
                        
                        $author_review_posts = new WP_Query($author_review_posts_args);
                        
                        if ( $author_review_posts->have_posts() ) {
                            echo '<div class="container mt-3 mb-5 bg-white pt-3">';
                            echo '<div class="row">';
                            echo '<div class="col-lg-12">';
                            echo '<h2>Your Post List - You can edit, request for delete. </h2>';
                            echo '<div class="book-review-table">';
                            echo '<table id="reviews-table">';
                            echo '<tr>';
                            echo '<th>#</th>';
                            echo '<th>Review Title</th>';
                            echo '<th>Thumbnail</th>';
                            echo '<th>Book</th>';
                            echo '<th>Date</th>';
                            echo '<th> Status </th>';
                            echo '<th>Actions</th>';
                            echo '</tr>';
                       
                           $serial = 1;
                           while ( $author_review_posts->have_posts() ) {
                               $author_review_posts->the_post();
                               $post_id = get_the_ID();
                               $post_title = get_the_title();
                               $post_date = get_the_date();
                               $review_book = get_post_meta(get_the_ID(), '_product_id', true);
                               $review_book_id = $review_book ? $review_book : '0';
                               $post_statuses = wbr_get_post_status_badge_class( $post_id );
                       
                               echo '<tr>';
                               echo '<td>' . esc_html($serial++) . '</td>';
                               echo '<td><a href="'.get_the_permalink(get_the_ID()).'">' . esc_html(wp_trim_words($post_title, 8, '')) . '</a></td>';
                               echo '<td><img width="50px" src="' . get_the_post_thumbnail_url(get_the_ID(), 'medium') . '"></td>';
                               echo '<td>';
                               if( $review_book_id && $review_book_id != 0 ) {
                                   echo '<a href="' . get_the_permalink($review_book_id) . '">' . esc_html(get_the_title($review_book_id)) . '</a>';
                               }
                               echo '</td>';
                               echo '<td>' . esc_html($post_date) . '</td>';
                               echo '<td><span class="badge '. esc_attr( $post_statuses ) . '">' . esc_html( ucwords( str_replace( '_', ' ', get_post_status( $post_id ) ) ) ) . '</span></td>';
                               echo '<td>';
                               if( get_post_status( $post_id ) == 'draft' ) {
                                   echo '<a class="me-2" href="' . esc_url( '/publish' ) . '"><span class="badge text-bg-info">Publish</span></a>';
                               }
                               echo '<a class="me-2" href="' . esc_url('/submit-review?reviewid=' . get_the_ID()) . '"><span class="badge text-bg-primary">Edit</span></a>';
                               echo '<a href="#" class="wbrDeleteRequestReview" data-id="' . esc_attr( $post_id ) . '"><span class="badge text-bg-danger">Delete</span></a>';
                               echo '</td>';
                               echo '</tr>';
                           }
                       
                           echo '</table>';
                           echo '</div>;';
                        
                            $total_pages = $author_review_posts->max_num_pages;
                            if ($total_pages > 1) {
                                $class = 'wbr_author_review_pagination';
                                echo '<div id="pagination">';
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    if( $i == 1 ) {
                                        $class = 'wbr_author_review_pagination current';
                                    }else{
                                        $class = 'wbr_author_review_pagination';
                                    }
                                    echo '<button class="'. $class .'" data-page="' . $i . '">' . $i . '</button>';
                                }
                                echo '</div>';
                            }
                            echo '</div></div></div>';
                        } else {
                            echo 'No reviews found.';
                        }
                        
                        wp_reset_postdata();
                    endif;
                    ?>

        <div class="author-reviews">
        <?php
// Get the current page number
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Define query arguments
$review_posts_args = array(
    'post_type'      => 'review',
    'author'         => $author_id,
    'posts_per_page' => 6, // Set the number of posts per page
    'paged'          => $paged,
);

// Execute the query
$review_posts = new WP_Query($review_posts_args);

// Check if there are any posts to display
if ($review_posts->have_posts()) :
    echo '<div class="container mt-3">';
    echo '<div class="row" id="reviews-container">';

    // Display the page header
    ?>
    <header class="page-header">
        <h2 class="page-title"><?php printf(__('Reviews by %s', 'textdomain'), get_the_author()); ?></h2>
    </header><!-- .page-header -->
    <?php

    // Loop through the posts
    while ($review_posts->have_posts()) :
        $review_posts->the_post();
        echo '<div class="col-lg-4 col-sm-6 col-xs-12">';
        wbr_output_review_card(get_the_ID());
        echo '</div>';
    endwhile;

    echo '</div>'; // Close .row
    echo '</div>'; // Close .container

    // Display pagination
    echo '<div class="pagination">';
    echo paginate_links(array(
        'total'   => $review_posts->max_num_pages,
        'current' => $paged,
    ));
    echo '</div>';

    // Reset post data
    wp_reset_postdata();
else :
    // If no posts found, display a message
    echo '<p>' . __('No reviews found.', 'textdomain') . '</p>';
endif;
?>

        </div>
        <?php if( have_posts() ): ?>
        <hr>
        <h2>Posts By <?php the_author(); ?></h2>
        <?php do_action( 'woodmart_main_loop' ); ?>
        <?php endif; ?>

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php
get_footer();