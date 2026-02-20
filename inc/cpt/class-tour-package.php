<?php
class Limoux_Tour_Package_CPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
        add_action( 'init', array( $this, 'register_taxonomies' ) );
        add_filter( 'manage_tour_package_posts_columns', array( $this, 'columns' ) );
        add_action( 'manage_tour_package_posts_custom_column', array( $this, 'column_values' ), 10, 2 );
    }

    public function register() {
        register_post_type(
            'tour_package',
            array(
                'label'        => __( 'Tour Packages', 'limoux' ),
                'public'       => true,
                'show_in_rest' => true,
                'has_archive'  => true,
                'menu_icon'    => 'dashicons-location',
                'rewrite'      => array( 'slug' => 'packages' ),
                'supports'     => array( 'title', 'editor', 'thumbnail' ),
            )
        );
    }

    public function register_taxonomies() {
        register_taxonomy( 'package_type', 'tour_package', array( 'label' => __( 'Package Type', 'limoux' ), 'show_in_rest' => true ) );
        register_taxonomy( 'duration', 'tour_package', array( 'label' => __( 'Duration', 'limoux' ), 'show_in_rest' => true ) );
        register_taxonomy( 'difficulty', 'tour_package', array( 'label' => __( 'Difficulty', 'limoux' ), 'show_in_rest' => true ) );
        register_taxonomy( 'best_season', 'tour_package', array( 'label' => __( 'Best Season', 'limoux' ), 'show_in_rest' => true ) );
    }

    public function columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Title', 'limoux' ),
            'duration' => __( 'Duration', 'limoux' ),
            'base_price' => __( 'Base Price', 'limoux' ),
            'stops' => __( '# of Stops', 'limoux' ),
            'status' => __( 'Status', 'limoux' ),
            'date' => __( 'Date', 'limoux' ),
        );
    }

    public function column_values( $column, $post_id ) {
        if ( 'duration' === $column ) {
            $value = (string) get_post_meta( $post_id, 'duration', true );
            $unit = (string) get_post_meta( $post_id, 'duration_unit', true );
            echo esc_html( trim( $value . ' ' . $unit ) ?: '-' );
            return;
        }

        if ( 'base_price' === $column ) {
            $price = get_post_meta( $post_id, 'base_price', true );
            echo esc_html( '' !== (string) $price ? '$' . number_format_i18n( (float) $price, 2 ) : '-' );
            return;
        }

        if ( 'stops' === $column ) {
            $stops = get_post_meta( $post_id, 'itinerary_stops', true );
            echo esc_html( is_array( $stops ) ? (string) count( $stops ) : ( is_numeric( $stops ) ? (string) $stops : '0' ) );
            return;
        }

        if ( 'status' === $column ) {
            echo esc_html( get_post_status( $post_id ) );
        }
    }
}
