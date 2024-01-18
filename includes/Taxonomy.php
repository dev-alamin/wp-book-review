<?php 
namespace Book\Review;

class Taxonomy {

    public function __construct() {
        add_action( 'init', [ $this, 'author_tax' ] );
        add_action( 'init', [ $this, 'publisher_tax' ] );
    }
    
    public function author_tax() {
        $labels = [
            "name" => esc_html__( "Authors", "custom-post-type-ui" ),
            "singular_name" => esc_html__( "Author", "custom-post-type-ui" ),
        ];

        $args = [
            "label" => esc_html__( "Authors", "custom-post-type-ui" ),
            "labels" => $labels,
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => true,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => '/books/author', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "authors",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ];
        register_taxonomy( "authors", [ "product" ], $args );
    }


    public function publisher_tax() {
        $labels = [
            "name" => esc_html__( "Publishers", "custom-post-type-ui" ),
            "singular_name" => esc_html__( "Publisher", "custom-post-type-ui" ),
        ];

        $args = [
            "label" => esc_html__( "Publishers", "custom-post-type-ui" ),
            "labels" => $labels,
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => true,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => '/books/publisher', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "publisher",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ];
        register_taxonomy( "publisher", [ "product" ], $args );
    }
}