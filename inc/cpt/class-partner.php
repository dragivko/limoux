<?php
class Limoux_Partner_CPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
        add_action( 'init', array( $this, 'register_taxonomies' ) );
        add_filter( 'manage_partner_posts_columns', array( $this, 'columns' ) );
        add_action( 'manage_partner_posts_custom_column', array( $this, 'column_values' ), 10, 2 );
    }

    public function register() {
        register_post_type(
            'partner',
            array(
                'label'        => __( 'Partners', 'limoux' ),
                'public'       => true,
                'show_in_rest' => true,
                'has_archive'  => false,
                'menu_icon'    => 'dashicons-businessperson',
                'rewrite'      => array( 'slug' => 'partners' ),
                'supports'     => array( 'title', 'editor', 'thumbnail' ),
            )
        );
    }

    public function register_taxonomies() {
        register_taxonomy( 'partner_type', 'partner', array( 'label' => __( 'Partner Type', 'limoux' ), 'show_in_rest' => true ) );
        register_taxonomy( 'partner_service_area', 'partner', array( 'label' => __( 'Service Area', 'limoux' ), 'show_in_rest' => true ) );
    }

    public function columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Partner Name', 'limoux' ),
            'type' => __( 'Type', 'limoux' ),
            'status' => __( 'Status', 'limoux' ),
            'tier' => __( 'Tier', 'limoux' ),
            'featured' => __( 'Featured', 'limoux' ),
            'date' => __( 'Date', 'limoux' ),
        );
    }

    public function column_values( $column, $post_id ) {
        if ( 'type' === $column ) {
            $terms = wp_get_post_terms( $post_id, 'partner_type', array( 'fields' => 'names' ) );
            echo esc_html( ! empty( $terms ) ? implode( ', ', $terms ) : '-' );
            return;
        }

        if ( 'status' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'partnership_status', true ) ?: '-' );
            return;
        }

        if ( 'tier' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'partnership_tier', true ) ?: '-' );
            return;
        }

        if ( 'featured' === $column ) {
            echo (int) get_post_meta( $post_id, 'featured_partner', true ) ? esc_html__( 'Yes', 'limoux' ) : esc_html__( 'No', 'limoux' );
        }
    }
}
