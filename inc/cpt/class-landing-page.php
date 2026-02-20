<?php
class Limoux_Landing_Page_CPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
        add_action( 'init', array( $this, 'auto_expire_event_pages' ) );
        add_filter( 'manage_landing_page_posts_columns', array( $this, 'columns' ) );
        add_action( 'manage_landing_page_posts_custom_column', array( $this, 'column_values' ), 10, 2 );
    }

    public function register() {
        register_post_type(
            'landing_page',
            array(
                'label'        => __( 'Landing Pages', 'limoux' ),
                'public'       => true,
                'show_in_rest' => true,
                'has_archive'  => false,
                'menu_icon'    => 'dashicons-megaphone',
                'rewrite'      => array( 'slug' => 'book' ),
                'supports'     => array( 'title', 'editor', 'thumbnail' ),
            )
        );
    }

    public function auto_expire_event_pages() {
        $query = new WP_Query(
            array(
                'post_type'      => 'landing_page',
                'post_status'    => 'publish',
                'posts_per_page' => 30,
                'meta_query'     => array(
                    array( 'key' => 'page_mode', 'value' => 'event' ),
                    array( 'key' => 'event_page_active', 'value' => 1 ),
                ),
                'fields'         => 'ids',
            )
        );

        if ( empty( $query->posts ) ) {
            return;
        }

        $today = gmdate( 'Ymd' );

        foreach ( $query->posts as $post_id ) {
            $end = (string) get_post_meta( $post_id, 'event_date_end', true );
            if ( $end && preg_replace( '/[^0-9]/', '', $end ) < $today ) {
                wp_update_post( array( 'ID' => $post_id, 'post_status' => 'draft' ) );
                do_action( 'limoux_event_page_expired', $post_id, array( 'post_id' => $post_id ) );
            }
        }
    }

    public function columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Title', 'limoux' ),
            'mode' => __( 'Mode', 'limoux' ),
            'event_date' => __( 'Event Date', 'limoux' ),
            'active' => __( 'Active', 'limoux' ),
            'cta_label' => __( 'CTA Label', 'limoux' ),
            'date' => __( 'Date', 'limoux' ),
        );
    }

    public function column_values( $column, $post_id ) {
        if ( 'mode' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'page_mode', true ) ?: '-' );
            return;
        }

        if ( 'event_date' === $column ) {
            $mode = (string) get_post_meta( $post_id, 'page_mode', true );
            if ( 'event' !== $mode ) {
                echo '-';
                return;
            }

            $start = (string) get_post_meta( $post_id, 'event_date_start', true );
            $end = (string) get_post_meta( $post_id, 'event_date_end', true );
            echo esc_html( trim( $start . ( $end ? ' - ' . $end : '' ) ) ?: '-' );
            return;
        }

        if ( 'active' === $column ) {
            $mode = (string) get_post_meta( $post_id, 'page_mode', true );
            if ( 'event' !== $mode ) {
                echo esc_html__( 'Yes', 'limoux' );
                return;
            }

            echo (int) get_post_meta( $post_id, 'event_page_active', true ) ? esc_html__( 'Yes', 'limoux' ) : esc_html__( 'No', 'limoux' );
            return;
        }

        if ( 'cta_label' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'cta_primary_label', true ) ?: '-' );
        }
    }
}
