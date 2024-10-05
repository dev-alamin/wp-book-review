<?php 
namespace Book\Review\Admin;

 if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use \Carbon_Fields\Container;
use \Carbon_Fields\Field;
\Carbon_Fields\Carbon_Fields::boot();


class Options {
    public function __construct() {
        $this->carbon_init();
    }

    public function carbon_init() {
            // Default options page
        $wbr_options_container = Container::make( 'theme_options', __( 'Book Review Options', 'wbr' ) )
        ->add_fields( array(
            Field::make( 'complex', 'wbr_archive_slider', __( 'Archive Slider' ) )
                ->add_fields( array(
                    Field::make( 'image', 'slider_image', __( 'Slider Image' ) ),
                    Field::make( 'text', 'slider_heading', __( 'Slider Heading' ) ),
                    Field::make( 'text', 'slider_button_text', __( 'Button Text' ) ),
                    Field::make( 'text', 'slider_button_link', __( 'Button Link' ) ),
                ) )
                ->set_layout( 'tabbed-vertical' ) // Optional layout setting
        ));

        Container::make( 'theme_options', __( 'Post a Review Settings', 'wbr' ) )
        ->set_page_parent( $wbr_options_container )
        ->add_fields( array(
            Field::make( 'checkbox', 'wbr_post_review_show', __( 'Show Post a Review Section' ) )
            ->set_option_value( 'yes' ),  // Set to 'yes' by default
            Field::make( 'text', 'wbr_post_review_heading', __( 'Post Review Heading' ) ),
            Field::make( 'textarea', 'wbr_post_review_subheading', __( 'Post Review Subheading' ) ),
            Field::make( 'text', 'wbr_post_review_button_text', __( 'Button Text' ) ),
            Field::make( 'text', 'wbr_post_review_button_link', __( 'Button Link' ) ),
            Field::make( 'complex', 'wbr_post_review_reasons', __( 'Reasons List' ) )
                ->add_fields( array(
                    Field::make( 'text', 'reason_text', __( 'Reason Text' ) )
                ) ),
            Field::make( 'image', 'wbr_post_review_promo_image', __( 'Promo Image' ) )
        ));

        Container::make( 'theme_options', __( 'Book Review Prize Settings', 'wbr' ) )
        ->set_page_parent( $wbr_options_container )
        ->add_fields( array(
            Field::make( 'checkbox', 'wbr_book_review_show', __( 'Show Book Review Prize Section' ) )
                ->set_option_value( 'yes' ),
            Field::make( 'text', 'wbr_book_review_heading', __( 'Book Review Heading' ) ),
            Field::make( 'image', 'wbr_book_review_logo', __( 'Main Logo' ) ),
            Field::make( 'image', 'wbr_book_review_identifier', __( 'Prize Identifier Image' ) ),
            Field::make( 'image', 'wbr_book_review_presented_logo', __( 'Presented By Logo' ) ),
            Field::make( 'text', 'wbr_book_review_presented_text', __( 'Presented By Text' ) )
                ->set_default_value( 'নিবেদনে' ),
            Field::make( 'text', 'wbr_book_review_prize_money', __( 'Prize Money' ) ),
            Field::make( 'text', 'wbr_book_review_deadline', __( 'Deadline' ) ),
            Field::make( 'text', 'wbr_book_review_post_review_button', __( 'Post Review Button Text' ) ),
            Field::make( 'text', 'wbr_book_review_post_review_link', __( 'Post Review Button Link' ) ),
            Field::make( 'text', 'wbr_book_review_details_button', __( 'Details Button Text' ) ),
            Field::make( 'text', 'wbr_book_review_details_link', __( 'Details Button Link' ) ),
            Field::make( 'date_time', 'wbr_book_review_countdown_target', __( 'Countdown Target Date' ) ),
        ));
    }
}