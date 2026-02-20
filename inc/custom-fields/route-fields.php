<?php
add_action( 'acf/init', 'limoux_register_route_fields' );

function limoux_register_route_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_limoux_route',
            'title' => 'Route Fields',
            'fields' => array(
                array( 'key' => 'field_lx_route_origin_name', 'label' => 'Origin Name', 'name' => 'origin_name', 'type' => 'text', 'required' => 1 ),
                array( 'key' => 'field_lx_route_origin_address', 'label' => 'Origin Address', 'name' => 'origin_address', 'type' => 'text' ),
                array( 'key' => 'field_lx_route_origin_coordinates', 'label' => 'Origin Coordinates', 'name' => 'origin_coordinates', 'type' => 'google_map' ),
                array( 'key' => 'field_lx_route_destination_name', 'label' => 'Destination Name', 'name' => 'destination_name', 'type' => 'text', 'required' => 1 ),
                array( 'key' => 'field_lx_route_destination_address', 'label' => 'Destination Address', 'name' => 'destination_address', 'type' => 'text' ),
                array( 'key' => 'field_lx_route_destination_coordinates', 'label' => 'Destination Coordinates', 'name' => 'destination_coordinates', 'type' => 'google_map' ),
                array( 'key' => 'field_lx_route_distance_miles', 'label' => 'Distance (Miles)', 'name' => 'distance_miles', 'type' => 'number' ),
                array( 'key' => 'field_lx_route_estimated_duration_minutes', 'label' => 'Estimated Duration (Minutes)', 'name' => 'estimated_duration_minutes', 'type' => 'number' ),
                array( 'key' => 'field_lx_route_route_type', 'label' => 'Route Type', 'name' => 'route_type', 'type' => 'select', 'choices' => array( 'airport-transfer' => 'Airport Transfer', 'corporate' => 'Corporate', 'intercity' => 'Intercity', 'port' => 'Port', 'event-venue' => 'Event Venue', 'custom' => 'Custom' ) ),

                array( 'key' => 'field_lx_route_base_price', 'label' => 'Base Price', 'name' => 'base_price', 'type' => 'number', 'step' => 0.01 ),
                array( 'key' => 'field_lx_route_price_per_additional_passenger', 'label' => 'Price Per Additional Passenger', 'name' => 'price_per_additional_passenger', 'type' => 'number', 'step' => 0.01 ),
                array( 'key' => 'field_lx_route_pricing_notes', 'label' => 'Pricing Notes', 'name' => 'pricing_notes', 'type' => 'textarea' ),

                array( 'key' => 'field_lx_route_available_vehicles', 'label' => 'Available Vehicles', 'name' => 'available_vehicles', 'type' => 'relationship', 'post_type' => array( 'fleet_vehicle' ) ),

                array( 'key' => 'field_lx_route_route_highlights', 'label' => 'Route Highlights', 'name' => 'route_highlights', 'type' => 'textarea' ),
                array( 'key' => 'field_lx_route_hero_image', 'label' => 'Hero Image', 'name' => 'hero_image', 'type' => 'image' ),
                array( 'key' => 'field_lx_route_ideal_for', 'label' => 'Ideal For', 'name' => 'ideal_for', 'type' => 'repeater', 'button_label' => 'Add Tag', 'sub_fields' => array( array( 'key' => 'field_lx_route_ideal_for_item', 'label' => 'Tag', 'name' => 'tag', 'type' => 'text' ) ) ),

                array( 'key' => 'field_lx_route_seo_focus_keyphrase', 'label' => 'SEO Focus Keyphrase', 'name' => 'seo_focus_keyphrase', 'type' => 'text' ),
                array( 'key' => 'field_lx_route_seo_description', 'label' => 'SEO Description', 'name' => 'seo_description', 'type' => 'textarea' ),
                array( 'key' => 'field_lx_route_ai_generated_description', 'label' => 'AI Generated Description', 'name' => 'ai_generated_description', 'type' => 'wysiwyg' ),
            ),
            'location' => array(
                array(
                    array( 'param' => 'post_type', 'operator' => '==', 'value' => 'route' ),
                ),
            ),
        )
    );
}
