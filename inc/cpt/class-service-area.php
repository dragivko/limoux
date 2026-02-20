<?php
class Limoux_Service_Area_CPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
        add_filter( 'manage_service_area_posts_columns', array( $this, 'columns' ) );
        add_action( 'manage_service_area_posts_custom_column', array( $this, 'column_values' ), 10, 2 );
    }

    public function register() {
        register_post_type(
            'service_area',
            array(
                'label'        => __( 'Service Areas', 'limoux' ),
                'public'       => true,
                'show_in_rest' => true,
                'has_archive'  => true,
                'menu_icon'    => 'dashicons-location-alt',
                'rewrite'      => array( 'slug' => 'service-areas' ),
                'supports'     => array( 'title', 'editor', 'thumbnail' ),
            )
        );
    }

    public function columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Area Name', 'limoux' ),
            'type' => __( 'Type', 'limoux' ),
            'coverage_radius' => __( 'Coverage Radius', 'limoux' ),
            'date' => __( 'Date', 'limoux' ),
        );
    }

    public function column_values( $column, $post_id ) {
        if ( 'type' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'area_type', true ) ?: '-' );
            return;
        }

        if ( 'coverage_radius' === $column ) {
            $radius = get_post_meta( $post_id, 'coverage_radius', true );
            echo esc_html( '' !== (string) $radius ? $radius . ' mi' : '-' );
        }
    }
}
