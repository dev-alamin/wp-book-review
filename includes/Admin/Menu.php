<?php
/**
 * WP Book Review Admin Menu Class
 *
 * @package WPBookReview
 * @subpackage Admin
 * @since 1.0.0
 */
namespace Book\Review\Admin;

/**
 * Class Menu
 *
 * This class handles the creation of the admin menu for the WP Book Review plugin.
 *
 * @since 1.0.0
 */
class Menu {
    /**
     * Constructor function to initialize the Menu class.
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'menu' ] );
        add_action( 'admin_init', [ $this, 'wbr_options'] );
    }

    /**
     * Register options and settings for the WP Book Review plugin.
     *
     * @since 1.0.0
     */
    public function wbr_options(){
        register_setting( 'wbr_archive_promo_options', 'wbr_archive_promo_options', [ $this, 'wbr_sanitize_options' ] );

        add_settings_section( 'wbr_archive_promo_section', 'Archive Promo Settings', [ $this, 'wbr_archive_promo_section_callback' ], 'wbr_archive_promo_settings' );

        add_settings_field( 'archive_promo_slider_image', 'Slider Image', [ $this, 'wbr_archive_promo_slider_image_callback' ], 'wbr_archive_promo_settings', 'wbr_archive_promo_section' );
        add_settings_field( 'archive_promo_title', 'Title', [ $this, 'wbr_archive_promo_title_callback' ], 'wbr_archive_promo_settings', 'wbr_archive_promo_section' );
        add_settings_field( 'archive_promo_description', 'Description', [ $this, 'wbr_archive_promo_description_callback' ], 'wbr_archive_promo_settings', 'wbr_archive_promo_section' );
        add_settings_field( 'archive_promo_cta_text', 'CTA Text', [ $this, 'wbr_archive_promo_cta_text_callback' ], 'wbr_archive_promo_settings', 'wbr_archive_promo_section' );
        add_settings_field( 'archive_promo_cta_link', 'CTA Link', [ $this, 'wbr_archive_promo_cta_link_callback' ], 'wbr_archive_promo_settings', 'wbr_archive_promo_section' );
        add_settings_field( 'archive_promo_list_heading', 'List Heading', [ $this, 'wbr_archive_promo_list_item_callback' ], 'wbr_archive_promo_settings', 'wbr_archive_promo_section' );
        add_settings_field( 'archive_promo_list_items', 'List Item', [ $this, 'wbr_archive_promo_list_items_callback' ], 'wbr_archive_promo_settings', 'wbr_archive_promo_section' );
    }

    /**
     * Sanitize options for the WP Book Review plugin.
     *
     * @since 1.0.0
     */
    public function wbr_sanitize_options( $input ) {
        $sanitized_input = array();

        if ( isset( $input['archive_promo_title'] ) ) {
            $sanitized_input['archive_promo_title'] = sanitize_text_field( $input['archive_promo_title'] );
        }

        if ( isset( $input['archive_promo_description'] ) ) {
            $sanitized_input['archive_promo_description'] = wp_kses_post( $input['archive_promo_description'] );
        }

        if ( isset( $input['archive_promo_cta_text'] ) ) {
            $sanitized_input['archive_promo_cta_text'] = sanitize_text_field( $input['archive_promo_cta_text'] );
        }

        if ( isset( $input['archive_promo_cta_link'] ) ) {
            $sanitized_input['archive_promo_cta_link'] = esc_url( $input['archive_promo_cta_link'] );
        }

        if ( isset( $input['archive_promo_list_heading'] ) ) {
            $sanitized_input['archive_promo_list_heading'] = sanitize_textarea_field( $input['archive_promo_list_heading'] );
        }

        if ( isset( $input['archive_promo_list_items'] ) ) {
            $sanitized_input['archive_promo_list_items'] = sanitize_textarea_field( $input['archive_promo_list_items'] );
        }

        if (isset($input['archive_promo_slider_image'])) {
            $sanitized_input['archive_promo_slider_image'] = esc_url_raw($input['archive_promo_slider_image']);
        }
        
        return $sanitized_input;
    }

    /**
     * Callback function to create the admin menu for the WP Book Review plugin.
     *
     * @since 1.0.0
     */
    public function menu() {
        add_menu_page(
            __( 'Book Review', 'wpr' ),
            __( 'Book Review', 'wpr' ),
            'manage_options',
            'wp-book-review',
            [ $this, 'menu_cb' ],
            'dashicons-star-filled',
            99
        );

        // Add submenu item for settings page
        add_submenu_page(
            'wp-book-review',
            __( 'Archive Page', 'wpr' ),
            __( 'Archive Page', 'wpr' ),
            'manage_options',
            'wp-book-review-settings',
            [ $this, 'settings_page_cb' ]
        );
    }

    /**
     * Callback function for the settings page.
     *
     * @since 1.0.0
     */
    public function settings_page_cb() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'WP Book Review Settings', 'wpr' ); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'wbr_archive_promo_options' ); ?>
                <?php do_settings_sections( 'wbr_archive_promo_settings' ); ?>
                <?php submit_button( __( 'Save Settings', 'wpr' ) ); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Callback function for the admin menu page.
     *
     * @since 1.0.0
     */
    public function menu_cb() {
       $file = __DIR__ . '/views/review-list.php';

       if( file_exists( $file ) ) {
        include $file;
       }else{
        esc_html_e( 'Review list file could not be found. Please ask developer to fix', 'wpr' );
       }
    }

    /**
     * Callback function for options section.
     *
     * @since 1.0.0
     */
    public function wbr_archive_promo_section_callback() {
        echo '<p>Settings for the archive promo section.</p>';
    }  

    /**
     * Callback function for title field.
     *
     * @since 1.0.0
     */
    public function wbr_archive_promo_title_callback() {
        $options = get_option( 'wbr_archive_promo_options' );
        $title = isset( $options['archive_promo_title'] ) ? $options['archive_promo_title'] : '';
        echo '<input type="text" name="wbr_archive_promo_options[archive_promo_title]" value="' . esc_attr( $title ) . '" class="regular-text" />';
    }

    /**
     * Callback function for description field.
     *
     * @since 1.0.0
     */
    public function wbr_archive_promo_description_callback() {
        $options = get_option( 'wbr_archive_promo_options' );
        $description = isset( $options['archive_promo_description'] ) ? $options['archive_promo_description'] : '';
        echo '<textarea name="wbr_archive_promo_options[archive_promo_description]" rows="5" cols="50" class="regular-text">' . esc_textarea( $description ) . '</textarea>';
    }

    /**
     * Callback function for CTA text field.
     *
     * @since 1.0.0
     */
    public function wbr_archive_promo_cta_text_callback() {
        $options = get_option( 'wbr_archive_promo_options' );
        $cta_text = isset( $options['archive_promo_cta_text'] ) ? $options['archive_promo_cta_text'] : '';
        echo '<input type="text" name="wbr_archive_promo_options[archive_promo_cta_text]" value="' . esc_attr( $cta_text ) . '" class="regular-text" />';
    }

    /**
     * Callback function for CTA link field.
     *
     * @since 1.0.0
     */
    public function wbr_archive_promo_cta_link_callback() {
        $options = get_option( 'wbr_archive_promo_options' );
        $cta_link = isset( $options['archive_promo_cta_link'] ) ? $options['archive_promo_cta_link'] : '';
        echo '<input type="text" name="wbr_archive_promo_options[archive_promo_cta_link]" value="' . esc_url( $cta_link ) . '" class="regular-text" />';
    }

    /**
     * Callback function for list heading field.
     *
     * @since 1.0.0
     */
    public function wbr_archive_promo_list_item_callback() {
        $options = get_option( 'wbr_archive_promo_options' );
        $title = isset( $options['archive_promo_list_heading'] ) ? $options['archive_promo_list_heading'] : '';
        echo '<input type="text" name="wbr_archive_promo_options[archive_promo_list_heading]" value="' . esc_attr( $title ) . '" class="regular-text" />';
    }

       /**
     * Callback function for list items field.
     *
     * @since 1.0.0
     */
    public function wbr_archive_promo_list_items_callback() {
        $options = get_option( 'wbr_archive_promo_options' );
        $list_items = isset( $options['archive_promo_list_items'] ) ? $options['archive_promo_list_items'] : '';

        echo '<textarea name="wbr_archive_promo_options[archive_promo_list_items]" rows="5" cols="50" class="regular-text">' . esc_textarea( $list_items ) . '</textarea>';
    }

    public function wbr_archive_promo_slider_image_callback() {
        $options = get_option('wbr_archive_promo_options');
        $slider_image = isset($options['archive_promo_slider_image']) ? $options['archive_promo_slider_image'] : '';
        
        echo '<div>';
        echo '<input type="hidden" name="wbr_archive_promo_options[archive_promo_slider_image]" id="archive_promo_slider_image" value="' . esc_attr($slider_image) . '" />';
        echo '<img src="' . esc_url($slider_image) . '" style="max-width: 350px; height: auto; display: block; margin-bottom: 10px;" id="preview_slider_image" />';
        echo '<input type="button" id="upload_slider_image_button" class="button-secondary" value="' . esc_attr__('Upload/Choose Image', 'wpr') . '" />';
        echo '<input type="button" id="remove_slider_image_button" class="button-secondary" value="' . esc_attr__('Remove Image', 'wpr') . '" style="margin-left: 10px;" />';
        echo '</div>';
        ?>
        <script>
        jQuery(document).ready(function($) {
            $('#upload_slider_image_button').click(function(e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Slider Image',
                    multiple: false
                }).open().on('select', function(e) {
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    $('#archive_promo_slider_image').val(image_url);
                    $('#preview_slider_image').attr('src', image_url);
                });
            });
    
            $('#remove_slider_image_button').click(function(e) {
                e.preventDefault();
                $('#archive_promo_slider_image').val('');
                $('#preview_slider_image').attr('src', '');
            });
        });
        </script>
        <?php
        echo '<p class="description">Upload or choose an image for the slider.</p>';
    }
}
