<?php
class Limoux_Route_CPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
        add_action( 'init', array( $this, 'register_taxonomies' ) );
        add_filter( 'manage_route_posts_columns', array( $this, 'columns' ) );
        add_action( 'manage_route_posts_custom_column', array( $this, 'column_values' ), 10, 2 );
    }

    public function register() {
        register_post_type(
            'route',
            array(
                'label'        => __( 'Routes', 'limoux' ),
                'public'       => true,
                'show_in_rest' => true,
                'has_archive'  => true,
                'menu_icon'    => 'dashicons-arrow-right-alt',
                'rewrite'      => array( 'slug' => 'routes' ),
                'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            )
        );
    }

    public function register_taxonomies() {
        register_taxonomy( 'route_type', 'route', array( 'label' => __( 'Route Type', 'limoux' ), 'show_in_rest' => true ) );
        register_taxonomy( 'route_service_area', 'route', array( 'label' => __( 'Service Area', 'limoux' ), 'show_in_rest' => true ) );
    }

    public function columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Title', 'limoux' ),
            'origin' => __( 'Origin', 'limoux' ),
            'destination' => __( 'Destination', 'limoux' ),
            'distance' => __( 'Distance', 'limoux' ),
            'base_price' => __( 'Base Price', 'limoux' ),
            'route_type' => __( 'Route Type', 'limoux' ),
            'date' => __( 'Date', 'limoux' ),
        );
    }

    public function column_values( $column, $post_id ) {
        if ( 'origin' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'origin_name', true ) ?: '-' );
            return;
        }

        if ( 'destination' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'destination_name', true ) ?: '-' );
            return;
        }

        if ( 'distance' === $column ) {
            $distance = get_post_meta( $post_id, 'distance_miles', true );
            echo esc_html( '' !== (string) $distance ? $distance . ' mi' : '-' );
            return;
        }

        if ( 'base_price' === $column ) {
            $price = get_post_meta( $post_id, 'base_price', true );
            echo esc_html( '' !== (string) $price ? '$' . number_format_i18n( (float) $price, 2 ) : '-' );
            return;
        }

        if ( 'route_type' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'route_type', true ) ?: '-' );
        }
    }
}
