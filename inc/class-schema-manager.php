<?php
/**
 * Schema output manager.
 *
 * @package limoux
 */

class Limoux_Schema_Manager {

    public function __construct() {
        add_action( 'wp_head', array( $this, 'output_schema' ), 20 );
    }

    public function output_schema() {
        $schemas = array();
        $schemas[] = $this->get_local_business_schema();

        if ( is_singular() ) {
            $schema = $this->get_singular_schema( get_post() );
            if ( ! empty( $schema ) ) {
                $schemas[] = $schema;
            }
        }

        if ( $this->page_has_faqs() ) {
            $faq_schema = $this->get_faq_schema();
            if ( ! empty( $faq_schema ) ) {
                $schemas[] = $faq_schema;
            }
        }

        foreach ( $schemas as $schema ) {
            echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
        }
    }

    private function get_local_business_schema() {
        $rating_data = $this->get_aggregate_rating();

        return array(
            '@context'        => 'https://schema.org',
            '@type'           => 'LocalBusiness',
            'name'            => get_bloginfo( 'name' ),
            'description'     => get_bloginfo( 'description' ),
            'url'             => home_url( '/' ),
            'telephone'       => (string) get_option( 'limoux_business_phone', '' ),
            'aggregateRating' => array(
                '@type'       => 'AggregateRating',
                'ratingValue' => $rating_data['rating'],
                'reviewCount' => $rating_data['count'],
            ),
        );
    }

    private function get_singular_schema( $post ) {
        if ( ! $post instanceof WP_Post ) {
            return array();
        }

        $type = $post->post_type;

        if ( 'fleet_vehicle' === $type ) {
            return array(
                '@context' => 'https://schema.org',
                '@type'    => 'Vehicle',
                'name'     => get_the_title( $post ),
                'description' => wp_strip_all_tags( $post->post_content ),
            );
        }

        if ( 'tour_package' === $type ) {
            return array(
                '@context' => 'https://schema.org',
                '@type'    => 'Product',
                'name'     => get_the_title( $post ),
                'offers'   => array(
                    '@type'         => 'Offer',
                    'price'         => get_post_meta( $post->ID, 'base_price', true ),
                    'priceCurrency' => 'USD',
                ),
            );
        }

        if ( 'testimonial' === $type ) {
            return array(
                '@context'   => 'https://schema.org',
                '@type'      => 'Review',
                'reviewBody' => wp_strip_all_tags( $post->post_content ),
                'reviewRating' => array(
                    '@type' => 'Rating',
                    'ratingValue' => (int) get_post_meta( $post->ID, 'star_rating', true ),
                ),
            );
        }

        if ( 'promotion' === $type ) {
            return array(
                '@context' => 'https://schema.org',
                '@type'    => 'Offer',
                'name'     => get_the_title( $post ),
                'validFrom' => get_post_meta( $post->ID, 'valid_from', true ),
                'validThrough' => get_post_meta( $post->ID, 'valid_to', true ),
            );
        }

        if ( in_array( $type, array( 'route', 'service_offering', 'landing_page' ), true ) ) {
            return array(
                '@context' => 'https://schema.org',
                '@type'    => 'Service',
                'name'     => get_the_title( $post ),
                'description' => wp_strip_all_tags( $post->post_excerpt ?: $post->post_content ),
            );
        }

        if ( 'partner' === $type ) {
            return array(
                '@context' => 'https://schema.org',
                '@type'    => 'LocalBusiness',
                'name'     => get_the_title( $post ),
                'url'      => get_permalink( $post ),
            );
        }

        return array();
    }

    private function page_has_faqs() {
        if ( is_singular( 'faq' ) ) {
            return true;
        }

        if ( is_singular( array( 'service_offering', 'landing_page' ) ) ) {
            return true;
        }

        return false;
    }

    private function get_faq_schema() {
        $posts = get_posts(
            array(
                'post_type'      => 'faq',
                'post_status'    => 'publish',
                'posts_per_page' => 50,
            )
        );

        if ( empty( $posts ) ) {
            return array();
        }

        $entities = array();

        foreach ( $posts as $post ) {
            $entities[] = array(
                '@type' => 'Question',
                'name'  => get_the_title( $post ),
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => wp_strip_all_tags( $post->post_content ),
                ),
            );
        }

        return array(
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $entities,
        );
    }

    private function get_aggregate_rating() {
        $ids = get_posts(
            array(
                'post_type'      => 'testimonial',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'fields'         => 'ids',
            )
        );

        if ( empty( $ids ) ) {
            return array(
                'rating' => '5.0',
                'count'  => 0,
            );
        }

        $total = 0;

        foreach ( $ids as $id ) {
            $total += (int) get_post_meta( $id, 'star_rating', true );
        }

        return array(
            'rating' => number_format( $total / count( $ids ), 1 ),
            'count'  => count( $ids ),
        );
    }
}
