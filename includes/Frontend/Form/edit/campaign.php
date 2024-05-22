<div class="form-group">
    <label class="visually-hidden" for="campaign_id">Select Campaign:</label>

    <?php
    $campaign_id = get_post_meta($post_id, '_campaign_id', true);

    $campaigns_query = new WP_Query(array(
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
    ?>

<select class="form-select form-control" style="width: 100%" name="campaign_id" id="campaign_id">
    <option value="">Select a Campaign</option>
    <?php
    if ($campaigns_query->have_posts()) {
        while ($campaigns_query->have_posts()) {
            $campaigns_query->the_post();
            $campaign_option_id = get_the_ID();
            $campaign_option_title = get_the_title();
            ?>
            <option value="<?php echo $campaign_option_id; ?>" <?php selected($campaign_id, $campaign_option_id); ?>><?php echo $campaign_option_title; ?></option>
            <?php
        }
    }
    wp_reset_postdata(); // Restore global post data
    ?>
</select>

</div>