<?php
class Limoux_Testimonial_CPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
        add_filter( 'manage_testimonial_posts_columns', array( $this, 'columns' ) );
        add_action( 'manage_testimonial_posts_custom_column', array( $this, 'column_values' ), 10, 2 );
    }

    public function register() {
        register_post_type(
            'testimonial',
            array(
                'label'        => __( 'Testimonials', 'limoux' ),
                'public'       => true,
                'show_in_rest' => true,
                'has_archive'  => false,
                'menu_icon'    => 'dashicons-format-quote',
                'supports'     => array( 'title', 'editor' ),
            )
        );
    }

    public function columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'reviewer_name' => __( 'Reviewer Name', 'limoux' ),
            'rating' => __( 'Rating', 'limoux' ),
            'source' => __( 'Source', 'limoux' ),
            'service_used' => __( 'Service Used', 'limoux' ),
            'review_date' => __( 'Date', 'limoux' ),
            'featured' => __( 'Featured', 'limoux' ),
        );
    }

    public function column_values( $column, $post_id ) {
        if ( 'reviewer_name' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'reviewer_name', true ) ?: get_the_title( $post_id ) );
            return;
        }

        if ( 'rating' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'star_rating', true ) ?: '-' );
            return;
        }

        if ( 'source' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'review_source', true ) ?: '-' );
            return;
        }

        if ( 'service_used' === $column ) {
            $service = get_post_meta( $post_id, 'service_used', true );
            if ( is_array( $service ) ) {
                $service = reset( $service );
            }
            echo $service ? esc_html( get_the_title( (int) $service ) ) : '-';
            return;
        }

        if ( 'review_date' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'review_date', true ) ?: '-' );
            return;
        }

        if ( 'featured' === $column ) {
            echo (int) get_post_meta( $post_id, 'featured_testimonial', true ) ? esc_html__( 'Yes', 'limoux' ) : esc_html__( 'No', 'limoux' );
        }
    }
}
