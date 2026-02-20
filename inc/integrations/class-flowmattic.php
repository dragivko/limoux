<?php
class Limoux_Flowmattic {
    public function __construct() {
        add_action( 'save_post_partner', array( $this, 'handle_partner_save' ), 10, 3 );
        add_action( 'save_post_tour_package', array( $this, 'handle_tour_package_save' ), 10, 3 );
        add_action( 'save_post_fleet_vehicle', array( $this, 'handle_vehicle_save' ), 10, 3 );
        add_action( 'save_post_promotion', array( $this, 'handle_promotion_save' ), 10, 3 );
    }

    public function handle_partner_save( $post_id, $post, $update ) {
        if ( wp_is_post_revision( $post_id ) ) { return; }

        $payload = array(
            'title' => get_the_title( $post_id ),
            'status' => (string) get_post_meta( $post_id, 'partnership_status', true ),
            'partnership_tier' => (string) get_post_meta( $post_id, 'partnership_tier', true ),
            'post_url' => get_permalink( $post_id ),
        );

        do_action( $update ? 'limoux_partner_updated' : 'limoux_partner_created', $post_id, $payload );
    }

    public function handle_tour_package_save( $post_id, $post, $update ) {
        if ( wp_is_post_revision( $post_id ) ) { return; }
        do_action( $update ? 'limoux_tour_package_updated' : 'limoux_tour_package_published', $post_id, array( 'title' => get_the_title( $post_id ) ) );
    }

    public function handle_vehicle_save( $post_id, $post, $update ) {
        if ( wp_is_post_revision( $post_id ) ) { return; }
        $status = (string) get_post_meta( $post_id, 'operational_status', true );
        do_action( 'limoux_vehicle_status_changed', $post_id, '', $status );
    }

    public function handle_promotion_save( $post_id, $post, $update ) {
        if ( wp_is_post_revision( $post_id ) ) { return; }

        $today = gmdate( 'Ymd' );
        $from = preg_replace( '/[^0-9]/', '', (string) get_post_meta( $post_id, 'valid_from', true ) );
        $to = preg_replace( '/[^0-9]/', '', (string) get_post_meta( $post_id, 'valid_to', true ) );
        $is_active = ( '' === $from || $from <= $today ) && ( '' === $to || $to >= $today );

        do_action( $is_active ? 'limoux_promotion_activated' : 'limoux_promotion_expired', $post_id, array( 'active' => $is_active ) );
    }
}
