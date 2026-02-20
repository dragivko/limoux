<?php
class Limoux_Fleet_Vehicle_CPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
        add_action( 'init', array( $this, 'register_taxonomies' ) );
        add_filter( 'manage_fleet_vehicle_posts_columns', array( $this, 'columns' ) );
        add_action( 'manage_fleet_vehicle_posts_custom_column', array( $this, 'column_values' ), 10, 2 );
    }

    public function register() {
        register_post_type(
            'fleet_vehicle',
            array(
                'label'        => __( 'Fleet Vehicles', 'limoux' ),
                'public'       => true,
                'show_in_rest' => true,
                'has_archive'  => true,
                'menu_icon'    => 'dashicons-car',
                'rewrite'      => array( 'slug' => 'fleet' ),
                'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            )
        );
    }

    public function register_taxonomies() {
        register_taxonomy( 'vehicle_type', 'fleet_vehicle', array( 'label' => __( 'Vehicle Type', 'limoux' ), 'show_in_rest' => true ) );
        register_taxonomy( 'vehicle_class', 'fleet_vehicle', array( 'label' => __( 'Vehicle Class', 'limoux' ), 'show_in_rest' => true ) );
        register_taxonomy( 'occasion', 'fleet_vehicle', array( 'label' => __( 'Occasion', 'limoux' ), 'show_in_rest' => true ) );
    }

    public function columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'thumbnail' => __( 'Thumbnail', 'limoux' ),
            'title' => __( 'Title', 'limoux' ),
            'make_model_year' => __( 'Make/Model/Year', 'limoux' ),
            'capacity' => __( 'Capacity', 'limoux' ),
            'status' => __( 'Status', 'limoux' ),
            'base_rate' => __( 'Base Rate', 'limoux' ),
            'featured' => __( 'Featured', 'limoux' ),
            'date' => __( 'Date', 'limoux' ),
        );
    }

    public function column_values( $column, $post_id ) {
        if ( 'thumbnail' === $column ) {
            echo get_the_post_thumbnail( $post_id, array( 60, 60 ) );
            return;
        }

        if ( 'make_model_year' === $column ) {
            $make = (string) get_post_meta( $post_id, 'vehicle_make', true );
            $model = (string) get_post_meta( $post_id, 'vehicle_model', true );
            $year = (string) get_post_meta( $post_id, 'vehicle_year', true );
            echo esc_html( trim( $make . ' ' . $model . ' ' . $year ) );
            return;
        }

        if ( 'capacity' === $column ) {
            $max = (string) get_post_meta( $post_id, 'passenger_capacity_max', true );
            $comfort = (string) get_post_meta( $post_id, 'passenger_capacity_comfort', true );
            echo esc_html( sprintf( '%s / %s', $max ?: '-', $comfort ?: '-' ) );
            return;
        }

        if ( 'status' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'operational_status', true ) ?: '-' );
            return;
        }

        if ( 'base_rate' === $column ) {
            $rate = get_post_meta( $post_id, 'base_hourly_rate', true );
            echo esc_html( '' !== (string) $rate ? '$' . number_format_i18n( (float) $rate, 2 ) : '-' );
            return;
        }

        if ( 'featured' === $column ) {
            echo (int) get_post_meta( $post_id, 'featured_vehicle', true ) ? esc_html__( 'Yes', 'limoux' ) : esc_html__( 'No', 'limoux' );
        }
    }
}
