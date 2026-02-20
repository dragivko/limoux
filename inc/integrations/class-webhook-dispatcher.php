<?php
class Limoux_Webhook_Dispatcher {
    public function __construct() {
        add_action( 'limoux_partner_created', array( $this, 'send_event' ), 10, 2 );
        add_action( 'limoux_partner_updated', array( $this, 'send_event' ), 10, 2 );
        add_action( 'limoux_partner_status_changed', array( $this, 'send_event' ), 10, 2 );
        add_action( 'limoux_testimonial_published', array( $this, 'send_event' ), 10, 2 );
        add_action( 'limoux_promotion_activated', array( $this, 'send_event' ), 10, 2 );
        add_action( 'limoux_promotion_expired', array( $this, 'send_event' ), 10, 2 );
        add_action( 'limoux_event_page_expired', array( $this, 'send_event' ), 10, 2 );
    }

    public function send_event( $post_id, $data = array() ) {
        $url = trim( (string) get_option( 'limoux_webhook_url', '' ) );
        $secret = (string) get_option( 'limoux_webhook_secret', '' );
        if ( '' === $url || '' === $secret ) {
            return;
        }

        $event = current_action();
        $payload = array(
            'event' => str_replace( 'limoux_', '', $event ),
            'timestamp' => gmdate( 'c' ),
            'site_url' => home_url( '/' ),
            'post_id' => (int) $post_id,
            'post_type' => get_post_type( $post_id ),
            'data' => is_array( $data ) ? $data : array(),
        );

        $json = wp_json_encode( $payload );
        $signature = 'sha256=' . hash_hmac( 'sha256', $json, $secret );

        wp_remote_post(
            $url,
            array(
                'headers' => array( 'Content-Type' => 'application/json', 'X-Limoux-Signature' => $signature ),
                'body' => $json,
                'timeout' => 15,
            )
        );
    }
}
