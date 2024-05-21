<?php
// Query to retrieve all products
$products_query = new WP_Query(array(
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

if ($products_query->have_posts()) { ?>
<?php 
    while ($products_query->have_posts()) {
        $products_query->the_post();
        the_title('<h1>', '</h1>' );
    }
    ?>
    <?php 
}
wp_reset_postdata();