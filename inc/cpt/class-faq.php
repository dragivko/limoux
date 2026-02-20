<?php
class Limoux_FAQ_CPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
        add_filter( 'manage_faq_posts_columns', array( $this, 'columns' ) );
        add_action( 'manage_faq_posts_custom_column', array( $this, 'column_values' ), 10, 2 );
    }

    public function register() {
        register_post_type(
            'faq',
            array(
                'label'        => __( 'FAQs', 'limoux' ),
                'public'       => true,
                'show_in_rest' => true,
                'has_archive'  => false,
                'menu_icon'    => 'dashicons-editor-help',
                'supports'     => array( 'title', 'editor' ),
            )
        );

        register_taxonomy( 'faq_category', 'faq', array( 'label' => __( 'FAQ Category', 'limoux' ), 'show_in_rest' => true ) );
    }

    public function columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'question' => __( 'Question', 'limoux' ),
            'category' => __( 'Category', 'limoux' ),
            'related_service' => __( 'Related Service', 'limoux' ),
            'order' => __( 'Order', 'limoux' ),
            'featured' => __( 'Featured', 'limoux' ),
            'date' => __( 'Date', 'limoux' ),
        );
    }

    public function column_values( $column, $post_id ) {
        if ( 'question' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'question', true ) ?: get_the_title( $post_id ) );
            return;
        }

        if ( 'category' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'faq_category_meta', true ) ?: '-' );
            return;
        }

        if ( 'related_service' === $column ) {
            $service = get_post_meta( $post_id, 'related_service', true );
            if ( is_array( $service ) ) {
                $service = reset( $service );
            }
            echo $service ? esc_html( get_the_title( (int) $service ) ) : '-';
            return;
        }

        if ( 'order' === $column ) {
            echo esc_html( (string) get_post_meta( $post_id, 'display_order', true ) ?: '0' );
            return;
        }

        if ( 'featured' === $column ) {
            echo (int) get_post_meta( $post_id, 'featured_faq', true ) ? esc_html__( 'Yes', 'limoux' ) : esc_html__( 'No', 'limoux' );
        }
    }
}
