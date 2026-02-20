<?php
class Limoux_Service_Offering_CPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
        add_filter( 'manage_service_offering_posts_columns', array( $this, 'columns' ) );
        add_action( 'manage_service_offering_posts_custom_column', array( $this, 'column_values' ), 10, 2 );
    }

    public function register() {
        register_post_type(
            'service_offering',
            array(
                'label'        => __( 'Service Offerings', 'limoux' ),
                'public'       => true,
                'show_in_rest' => true,
                'has_archive'  => true,
                'menu_icon'    => 'dashicons-star-filled',
                'rewrite'      => array( 'slug' => 'services' ),
                'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            )
        );

        register_taxonomy( 'service_type', 'service_offering', array( 'label' => __( 'Service Type', 'limoux' ), 'show_in_rest' => true ) );
    }

    public function columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Title', 'limoux' ),
            'service_type' => __( 'Service Type', 'limoux' ),
            'base_price' => __( 'Base Price', 'limoux' ),
            'featured' => __( 'Featured', 'limoux' ),
            'date' => __( 'Date', 'limoux' ),
        );
    }

    public function column_values( $column, $post_id ) {
        if ( 'service_type' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'service_type', true ) ?: '-' );
            return;
        }

        if ( 'base_price' === $column ) {
            $price = get_post_meta( $post_id, 'base_price', true );
            echo esc_html( '' !== (string) $price ? '$' . number_format_i18n( (float) $price, 2 ) : '-' );
            return;
        }

        if ( 'featured' === $column ) {
            echo (int) get_post_meta( $post_id, 'featured_service', true ) ? esc_html__( 'Yes', 'limoux' ) : esc_html__( 'No', 'limoux' );
        }
    }
}
