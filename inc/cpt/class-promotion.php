<?php
class Limoux_Promotion_CPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
        add_filter( 'manage_promotion_posts_columns', array( $this, 'columns' ) );
        add_action( 'manage_promotion_posts_custom_column', array( $this, 'column_values' ), 10, 2 );
    }

    public function register() {
        register_post_type(
            'promotion',
            array(
                'label'        => __( 'Promotions', 'limoux' ),
                'public'       => true,
                'show_in_rest' => true,
                'has_archive'  => false,
                'menu_icon'    => 'dashicons-tag',
                'supports'     => array( 'title', 'editor', 'thumbnail' ),
            )
        );
    }

    public function columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Title', 'limoux' ),
            'type' => __( 'Type', 'limoux' ),
            'valid_from' => __( 'Valid From', 'limoux' ),
            'valid_to' => __( 'Valid To', 'limoux' ),
            'active' => __( 'Active', 'limoux' ),
            'services' => __( 'Services', 'limoux' ),
            'date' => __( 'Date', 'limoux' ),
        );
    }

    public function column_values( $column, $post_id ) {
        if ( 'type' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'promo_type', true ) ?: '-' );
            return;
        }

        if ( 'valid_from' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'valid_from', true ) ?: '-' );
            return;
        }

        if ( 'valid_to' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'valid_to', true ) ?: '-' );
            return;
        }

        if ( 'active' === $column ) {
            $today = gmdate( 'Ymd' );
            $from = preg_replace( '/[^0-9]/', '', (string) get_post_meta( $post_id, 'valid_from', true ) );
            $to = preg_replace( '/[^0-9]/', '', (string) get_post_meta( $post_id, 'valid_to', true ) );
            $active = ( '' === $from || $from <= $today ) && ( '' === $to || $to >= $today );
            echo $active ? esc_html__( 'Yes', 'limoux' ) : esc_html__( 'No', 'limoux' );
            return;
        }

        if ( 'services' === $column ) {
            $services = get_post_meta( $post_id, 'applicable_services', true );
            if ( ! is_array( $services ) || empty( $services ) ) {
                echo '-';
                return;
            }

            $titles = array_map( static function( $service_id ) {
                return get_the_title( (int) $service_id );
            }, $services );

            echo esc_html( implode( ', ', array_filter( $titles ) ) );
        }
    }
}
