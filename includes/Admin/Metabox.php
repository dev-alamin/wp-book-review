<?php 
namespace Book\Review\Admin;
use \Carbon_Fields\Container;
use \Carbon_Fields\Field;
\Carbon_Fields\Carbon_Fields::boot();

class Metabox {
    public function __construct() {
        $this->carbon_init();
    }

    public function carbon_init() {
        Container::make( 'theme_options', __( 'FajrFair Extra Options', 'crb' ) )
        ->set_icon( 'dashicons-admin-settings' )
        ->add_fields( array(
            Field::make('date_time', 'ff_countdown_date_and_time', 'Countdown Date & Time'),
            Field::make( 'media_gallery', 'option_ff_book_preview_images', __( 'Upload Images for Book Preview, Read a bit' ) )
                        ->set_type( array( 'image' ) ),

            Field::make( 'separator', 'crb_style_options', 'Book Top Sidebar' ),

            Field::make( 'text', 'ff_to_payment_method', __( 'Payment Method' ) )
                ->set_default_value( 'Cash on Delivery' ),
            Field::make( 'text', 'ff_to_delivery_charge', __( 'Delivery Charge' ) )
                ->set_default_value( 'Tk. 70' ),
            Field::make( 'text', 'ff_to_phone_number', __( 'Phone Number' ) )
                ->set_default_value( '+880 1740723487 (For order)' ),
            Field::make( 'text', 'ff_to_contact_email', __( 'Contact Email' ) )
                ->set_default_value( 'sales@fazarfair.com' ),

            Field::make( 'complex', 'ff_single_book_slides', 'Slides' )
            ->set_layout( 'tabbed-horizontal' )
            ->add_fields( array(
                Field::make( 'text', 'link', 'Slider Link' ),
                Field::make( 'image', 'image', 'Slider Image' ),
            ) ),
        ) );

        Container::make( 'post_meta', 'Book Preview Images' )
            ->where( 'post_type', '=', 'product' )
            ->add_fields( array(
                Field::make( 'media_gallery', '_ff_book_preview_images', __( 'Upload Images for Book Preview, Read a bit' ) )
                        ->set_type( array( 'image' ) ),

                Field::make( 'text', '_ff_book_isbn', __( 'ISBN' ) ),

                Field::make( 'text', '_ff_book_edition', __( 'Edition' ) ),
            
                Field::make( 'text', '_ff_book_pages', __( 'Number of Pages' ) ),

                Field::make( 'text', 'ff_book_special_notice', __( 'Special Notice' ) ),

                // New field for Book Publish Date
                Field::make( 'date', '_ff_book_publish_date', __( 'Publish Date (If upcoming book)' ) ),
                // Repeatable field for Gift Text
                Field::make( 'complex', '_ff_book_gift_text', 'Gift With Book' )
                ->set_layout( 'tabbed-horizontal' )
                ->add_fields( array(
                    Field::make( 'text', 'title', 'Title' ),
                ) ),
            ));
        
        // Add fields to taxonomy 'author'
        Container::make( 'term_meta', 'Author Image' )
            ->where( 'term_taxonomy', '=', 'authors' ) // Target the 'author' taxonomy
            ->add_fields( array(
                Field::make( 'image', 'author_image', __( 'Author Image' ) ),
            ) );

            // Add fields to taxonomy 'publishers'
            Container::make( 'term_meta', 'Publisher Image' )
            ->where( 'term_taxonomy', '=', 'publisher' ) // Target the 'publishers' taxonomy
            ->add_fields( array(
                Field::make( 'image', 'publisher_image', __( 'Publisher Image' ) ),
            ) );

            Container::make( 'post_meta', 'Campaign Details' )
        ->where( 'post_type', '=', 'review-campaign' )
        ->add_fields( array(
            // Repeater field for prizes
            Field::make( 'text', 'campaign_name', 'Campaign Name' ),
            Field::make( 'complex', 'prizes', 'Prizes' )
                ->set_layout( 'tabbed-horizontal' )
                ->add_fields( array(
                    Field::make( 'text', 'prize_name', 'Prize' ),
                ) ),

            Field::make( 'date', 'last_submission_date', 'Last Date of Submission' ),
            // Select field to choose WooCommerce product
            Field::make( 'select', 'wc_product_id', __( 'Choose Product' ) )
                ->set_options( $this->get_all_product() ),
            
        ) );

    }

    public function get_all_product(){
        if( ! class_exists('Woocommerce' ) ) {
            return;
        }
        
        // Retrieve WooCommerce products
        $products = get_posts( array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
        ) );

        // Initialize an empty array to store product options
        $product_options = array();

        // Loop through products to construct options array
        foreach ( $products as $product ) {
            $product_options[ $product->ID ] = $product->post_title;
        }

        return $product_options;
    }
}