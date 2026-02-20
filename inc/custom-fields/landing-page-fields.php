<?php
add_action( 'acf/init', 'limoux_register_landing_page_fields' );

function limoux_register_landing_page_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_limoux_landing_page',
            'title' => 'Landing Page Fields',
            'fields' => array(
                array( 'key' => 'field_lx_lp_page_mode', 'label' => 'Page Mode', 'name' => 'page_mode', 'type' => 'select', 'choices' => array( 'route' => 'Route', 'event' => 'Event' ), 'default_value' => 'route' ),

                array( 'key' => 'field_lx_lp_hero_headline', 'label' => 'Hero Headline', 'name' => 'hero_headline', 'type' => 'text', 'maxlength' => 100 ),
                array( 'key' => 'field_lx_lp_hero_subheadline', 'label' => 'Hero Subheadline', 'name' => 'hero_subheadline', 'type' => 'text', 'maxlength' => 160 ),
                array( 'key' => 'field_lx_lp_hero_image', 'label' => 'Hero Image', 'name' => 'hero_image', 'type' => 'image' ),
                array( 'key' => 'field_lx_lp_cta_primary_label', 'label' => 'Primary CTA Label', 'name' => 'cta_primary_label', 'type' => 'text' ),
                array( 'key' => 'field_lx_lp_cta_primary_url', 'label' => 'Primary CTA URL', 'name' => 'cta_primary_url', 'type' => 'url' ),
                array( 'key' => 'field_lx_lp_cta_secondary_label', 'label' => 'Secondary CTA Label', 'name' => 'cta_secondary_label', 'type' => 'text' ),
                array( 'key' => 'field_lx_lp_cta_secondary_url', 'label' => 'Secondary CTA URL', 'name' => 'cta_secondary_url', 'type' => 'url' ),
                array( 'key' => 'field_lx_lp_intro_content', 'label' => 'Intro Content', 'name' => 'intro_content', 'type' => 'wysiwyg' ),
                array( 'key' => 'field_lx_lp_featured_vehicles', 'label' => 'Featured Vehicles', 'name' => 'featured_vehicles', 'type' => 'relationship', 'post_type' => array( 'fleet_vehicle' ) ),
                array( 'key' => 'field_lx_lp_related_service', 'label' => 'Related Service', 'name' => 'related_service', 'type' => 'relationship', 'post_type' => array( 'service_offering' ), 'max' => 1 ),

                array( 'key' => 'field_lx_lp_linked_route', 'label' => 'Linked Route', 'name' => 'linked_route', 'type' => 'relationship', 'post_type' => array( 'route' ), 'max' => 1, 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'route' ) ) ) ),
                array( 'key' => 'field_lx_lp_origin_display_name', 'label' => 'Origin Display Name', 'name' => 'origin_display_name', 'type' => 'text', 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'route' ) ) ) ),
                array( 'key' => 'field_lx_lp_destination_display_name', 'label' => 'Destination Display Name', 'name' => 'destination_display_name', 'type' => 'text', 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'route' ) ) ) ),
                array( 'key' => 'field_lx_lp_route_highlights', 'label' => 'Route Highlights', 'name' => 'route_highlights', 'type' => 'repeater', 'button_label' => 'Add Highlight', 'sub_fields' => array( array( 'key' => 'field_lx_lp_route_highlight_item', 'label' => 'Highlight', 'name' => 'highlight', 'type' => 'text' ) ), 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'route' ) ) ) ),
                array( 'key' => 'field_lx_lp_pricing_display', 'label' => 'Pricing Display', 'name' => 'pricing_display', 'type' => 'text', 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'route' ) ) ) ),

                array( 'key' => 'field_lx_lp_event_name', 'label' => 'Event Name', 'name' => 'event_name', 'type' => 'text', 'required' => 1, 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'event' ) ) ) ),
                array( 'key' => 'field_lx_lp_event_date_start', 'label' => 'Event Start Date', 'name' => 'event_date_start', 'type' => 'date_picker', 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'event' ) ) ) ),
                array( 'key' => 'field_lx_lp_event_date_end', 'label' => 'Event End Date', 'name' => 'event_date_end', 'type' => 'date_picker', 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'event' ) ) ) ),
                array( 'key' => 'field_lx_lp_event_venue_name', 'label' => 'Event Venue Name', 'name' => 'event_venue_name', 'type' => 'text', 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'event' ) ) ) ),
                array( 'key' => 'field_lx_lp_event_venue_address', 'label' => 'Event Venue Address', 'name' => 'event_venue_address', 'type' => 'text', 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'event' ) ) ) ),
                array( 'key' => 'field_lx_lp_event_venue_coordinates', 'label' => 'Event Venue Coordinates', 'name' => 'event_venue_coordinates', 'type' => 'google_map', 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'event' ) ) ) ),
                array( 'key' => 'field_lx_lp_event_description', 'label' => 'Event Description', 'name' => 'event_description', 'type' => 'textarea', 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'event' ) ) ) ),
                array( 'key' => 'field_lx_lp_event_type', 'label' => 'Event Type', 'name' => 'event_type', 'type' => 'select', 'choices' => array( 'music-festival' => 'Music Festival', 'art-fair' => 'Art Fair', 'sports' => 'Sports', 'corporate' => 'Corporate', 'concert' => 'Concert', 'other' => 'Other' ), 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'event' ) ) ) ),
                array(
                    'key' => 'field_lx_lp_pickup_zones',
                    'label' => 'Pickup Zones',
                    'name' => 'pickup_zones',
                    'type' => 'repeater',
                    'button_label' => 'Add Zone',
                    'sub_fields' => array(
                        array( 'key' => 'field_lx_lp_pickup_zone_name', 'label' => 'Zone Name', 'name' => 'zone_name', 'type' => 'text' ),
                        array( 'key' => 'field_lx_lp_pickup_zone_address', 'label' => 'Zone Address', 'name' => 'zone_address', 'type' => 'text' ),
                    ),
                    'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'event' ) ) ),
                ),
                array( 'key' => 'field_lx_lp_urgency_message', 'label' => 'Urgency Message', 'name' => 'urgency_message', 'type' => 'text', 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'event' ) ) ) ),
                array( 'key' => 'field_lx_lp_event_page_active', 'label' => 'Event Page Active', 'name' => 'event_page_active', 'type' => 'true_false', 'ui' => 1, 'conditional_logic' => array( array( array( 'field' => 'field_lx_lp_page_mode', 'operator' => '==', 'value' => 'event' ) ) ) ),

                array( 'key' => 'field_lx_lp_show_testimonials', 'label' => 'Show Testimonials', 'name' => 'show_testimonials', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_lp_testimonial_ids', 'label' => 'Testimonial IDs', 'name' => 'testimonial_ids', 'type' => 'relationship', 'post_type' => array( 'testimonial' ) ),
                array( 'key' => 'field_lx_lp_show_stats_bar', 'label' => 'Show Stats Bar', 'name' => 'show_stats_bar', 'type' => 'true_false', 'ui' => 1 ),

                array( 'key' => 'field_lx_lp_seo_title', 'label' => 'SEO Title', 'name' => 'seo_title', 'type' => 'text' ),
                array( 'key' => 'field_lx_lp_seo_description', 'label' => 'SEO Description', 'name' => 'seo_description', 'type' => 'textarea' ),
                array( 'key' => 'field_lx_lp_focus_keyphrase', 'label' => 'Focus Keyphrase', 'name' => 'focus_keyphrase', 'type' => 'text' ),
                array( 'key' => 'field_lx_lp_schema_override', 'label' => 'Schema Override (JSON-LD)', 'name' => 'schema_override', 'type' => 'textarea' ),

                array( 'key' => 'field_lx_lp_ai_page_copy', 'label' => 'AI Page Copy', 'name' => 'ai_page_copy', 'type' => 'wysiwyg' ),
                array( 'key' => 'field_lx_lp_ai_seo_description', 'label' => 'AI SEO Description', 'name' => 'ai_seo_description', 'type' => 'textarea' ),
            ),
            'location' => array(
                array(
                    array( 'param' => 'post_type', 'operator' => '==', 'value' => 'landing_page' ),
                ),
            ),
        )
    );
}
