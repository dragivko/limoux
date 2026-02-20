<?php
class Limoux_REST_API {
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    public function register_routes() {
        register_rest_route( 'limoux/v1', '/partners', array( 'methods' => 'GET', 'callback' => array( $this, 'list_partners' ), 'permission_callback' => '__return_true' ) );
        register_rest_route( 'limoux/v1', '/partners/(?P<id>\d+)', array( 'methods' => 'GET', 'callback' => array( $this, 'get_partner' ), 'permission_callback' => '__return_true' ) );
        register_rest_route( 'limoux/v1', '/partners/(?P<id>\d+)', array( 'methods' => 'POST', 'callback' => array( $this, 'update_partner' ), 'permission_callback' => array( $this, 'can_manage' ) ) );
        register_rest_route( 'limoux/v1', '/fleet', array( 'methods' => 'GET', 'callback' => array( $this, 'list_fleet' ), 'permission_callback' => '__return_true' ) );
        register_rest_route( 'limoux/v1', '/routes', array( 'methods' => 'GET', 'callback' => array( $this, 'list_routes' ), 'permission_callback' => '__return_true' ) );
        register_rest_route( 'limoux/v1', '/promotions/active', array( 'methods' => 'GET', 'callback' => array( $this, 'active_promotions' ), 'permission_callback' => '__return_true' ) );
        register_rest_route( 'limoux/v1', '/testimonials', array( 'methods' => 'POST', 'callback' => array( $this, 'create_testimonial' ), 'permission_callback' => array( $this, 'can_manage' ) ) );
        register_rest_route( 'limoux/v1', '/landing-pages/events', array( 'methods' => 'GET', 'callback' => array( $this, 'event_pages' ), 'permission_callback' => '__return_true' ) );
    }

    public function can_manage() { return current_user_can( 'edit_posts' ); }

    public function list_partners() { return $this->list_posts( 'partner' ); }

    public function get_partner( WP_REST_Request $request ) {
        $post = get_post( (int) $request['id'] );
        if ( ! $post || 'partner' !== $post->post_type ) {
            return new WP_Error( 'not_found', __( 'Partner not found.', 'limoux' ), array( 'status' => 404 ) );
        }
        return $this->format_post( $post );
    }

    public function update_partner( WP_REST_Request $request ) {
        $id = (int) $request['id'];
        if ( 'partner' !== get_post_type( $id ) ) {
            return new WP_Error( 'invalid', __( 'Invalid partner.', 'limoux' ), array( 'status' => 400 ) );
        }
        $tier = sanitize_text_field( (string) $request->get_param( 'partnership_tier' ) );
        update_post_meta( $id, 'partnership_tier', $tier );
        do_action( 'limoux_partner_updated', $id, array( 'partnership_tier' => $tier ) );
        return array( 'success' => true );
    }

    public function list_fleet() { return $this->list_posts( 'fleet_vehicle' ); }

    public function list_routes() { return $this->list_posts( 'route' ); }

    public function active_promotions() {
        $posts = get_posts( array( 'post_type' => 'promotion', 'post_status' => 'publish', 'posts_per_page' => -1 ) );
        $today = gmdate( 'Ymd' );

        return array_values(array_filter(array_map(array( $this, 'format_post' ), $posts), static function( $entry ) use ( $today ) {
            $from = isset( $entry['meta']['valid_from'] ) ? preg_replace( '/[^0-9]/', '', (string) $entry['meta']['valid_from'][0] ) : '';
            $to = isset( $entry['meta']['valid_to'] ) ? preg_replace( '/[^0-9]/', '', (string) $entry['meta']['valid_to'][0] ) : '';
            return ( '' === $from || $from <= $today ) && ( '' === $to || $to >= $today );
        }));
    }

    public function create_testimonial( WP_REST_Request $request ) {
        $id = wp_insert_post( array(
            'post_type' => 'testimonial',
            'post_status' => 'publish',
            'post_title' => sanitize_text_field( (string) $request->get_param( 'title' ) ),
            'post_content' => wp_kses_post( (string) $request->get_param( 'content' ) ),
        ) );

        if ( is_wp_error( $id ) ) {
            return $id;
        }

        update_post_meta( $id, 'star_rating', absint( $request->get_param( 'star_rating' ) ) );
        do_action( 'limoux_testimonial_published', $id, array( 'post_id' => $id ) );
        return array( 'id' => $id );
    }

    public function event_pages() {
        $posts = get_posts(array(
            'post_type' => 'landing_page',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(array('key' => 'page_mode', 'value' => 'event'), array('key' => 'event_page_active', 'value' => 1)),
        ));
        return array_map( array( $this, 'format_post' ), $posts );
    }

    private function list_posts( string $post_type ) {
        $posts = get_posts( array( 'post_type' => $post_type, 'post_status' => 'publish', 'posts_per_page' => -1 ) );
        return array_map( array( $this, 'format_post' ), $posts );
    }

    private function format_post( WP_Post $post ) {
        return array(
            'id' => (int) $post->ID,
            'title' => $post->post_title,
            'slug' => $post->post_name,
            'type' => $post->post_type,
            'url' => get_permalink( $post ),
            'meta' => get_post_meta( $post->ID ),
        );
    }
}
