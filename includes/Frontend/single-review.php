<?php 
defined( 'ABSPATH' ) || exit;
get_header();

$post_id             = get_the_date();
$post_title          = get_the_title($post_id);
$author_id           = get_post_meta($post_id, '_comment_author_id', true);
$comment_author_data = get_userdata($author_id);
$author_url          = get_author_posts_url($author_id);
$author_avatar       = get_avatar($author_id, 96); // Adjust the size as needed
$comments            = get_comments(array('post_id' => $post_id));
$product_id          = get_post_meta($post_id, '_associated_product_id', true);
$remove_review       = str_replace('Review', ' ', $post_title);
$comment_author_id   = get_post_meta($post_id, '_comment_author_id', true);
$author_url          = get_author_posts_url($comment_author_id);
$author_avatar       = get_avatar($comment_author_id, 96);
$comment_author_name = get_post_meta($post_id, '_comment_author_name', true);
$comment_author_url  = get_post_meta($post_id, '_comment_author_url', true);
$comment_count       = get_post_meta($post_id, '_comment_count', true);
$author_name         = $comment_author_data ? $comment_author_data->display_name : 'Anonymous';
$authors             = get_the_terms($product_id, 'authors');
$product             = wc_get_product($product_id);
$book_rating         = get_post_meta($post_id, '_comment_rating', true);
// $average_rating      = $product->get_average_rating();
?>
<div class="container">
<div class="single-page-container row">
    <div class="header-section">
        <div class="thumbnail">
            <a href="<?php echo get_the_permalink($product_id); ?>">
                <?php the_post_thumbnail(); ?>
            </a>
        </div>
        <div class="right-title">
            <h1><a href="<?php the_permalink(); ?>" target="_blank"><?php echo $remove_review ? esc_html($remove_review) : esc_html($post_title); ?></a></h1>
            <p class="label-text"><?php esc_html_e('বই নিয়ে টুকেরা কথা', 'wpr'); ?></p>
            <?php
            if ($authors && !is_wp_error($authors)) {
                echo '<p class="author-list"><i class="fa-solid fa-pen-to-square ml-3"></i>';
                $author_links = array();

                foreach ($authors as $author) {
                    $author_links[] = '<a href="' . esc_url(get_term_link($author)) . '">' . esc_html($author->name) . '</a>';
                }

                echo implode(', ', $author_links);
                echo '</p>';
            }
            ?>
        </div>
    </div>

    <div class="body-section" data-simplebar>
        <div class="title-description">
                <?php the_content(); ?>
        </div>

        <!-- Display the individual comment -->
        <div class="comment-entry wpr-single-comment">
            <div class="author-meta">
                <div class="author-avatar">
                    <a href="<?php echo esc_url($comment_author_url); ?>">
                        <?php echo $author_avatar; ?>
                    </a>
                </div>
                <div class="author-and-count">
                    <a href="<?php echo esc_url($comment_author_url); ?>">
                        <?php echo esc_html($author_name); ?>
                    </a>
                    <p>মোট <?php echo $comment_count; ?> টি পর্যালোচনা লিখেছেন</p>
                </div>
            </div>
        </div>

        <?php // Loop through comments
        foreach ($comments as $comment) : ?>
            <div class="comment-entry wpr-single-comment">
                <div class="author-meta">
                    <div class="author-avatar">
                        <a href="<?php echo esc_url(get_comment_author_url($comment)); ?>">
                            <?php echo get_avatar($comment, 96); ?>
                        </a>
                    </div>
                    <div class="author-and-count">
                        <a href="<?php echo esc_url(get_comment_author_url($comment)); ?>">
                            <?php echo get_comment_author($comment); ?>
                        </a>
                        <p><?php echo get_comment_text($comment); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
<?php get_footer(); ?>