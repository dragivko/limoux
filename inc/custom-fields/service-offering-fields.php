<?php
add_action( 'acf/init', 'limoux_register_service_offering_fields' );

function limoux_register_service_offering_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_limoux_service_offering',
            'title' => 'Service Offering Fields',
            'fields' => array(
                array( 'key' => 'field_lx_so_service_type', 'label' => 'Service Type', 'name' => 'service_type', 'type' => 'select', 'choices' => array( 'airport' => 'Airport', 'corporate' => 'Corporate', 'wedding' => 'Wedding', 'prom' => 'Prom', 'tour' => 'Tour', 'event' => 'Event', 'other' => 'Other' ) ),
                array( 'key' => 'field_lx_so_base_price', 'label' => 'Base Price', 'name' => 'base_price', 'type' => 'number', 'step' => 0.01 ),
                array( 'key' => 'field_lx_so_pricing_model', 'label' => 'Pricing Model', 'name' => 'pricing_model', 'type' => 'select', 'choices' => array( 'hourly' => 'Hourly', 'flat-rate' => 'Flat Rate', 'per-person' => 'Per Person' ) ),
                array( 'key' => 'field_lx_so_minimum_duration', 'label' => 'Minimum Duration (hours)', 'name' => 'minimum_duration', 'type' => 'number' ),

                array( 'key' => 'field_lx_so_recommended_vehicles', 'label' => 'Recommended Vehicles', 'name' => 'recommended_vehicles', 'type' => 'relationship', 'post_type' => array( 'fleet_vehicle' ) ),
                array( 'key' => 'field_lx_so_vehicle_note', 'label' => 'Vehicle Note', 'name' => 'vehicle_note', 'type' => 'textarea' ),
                array( 'key' => 'field_lx_so_service_areas', 'label' => 'Service Areas', 'name' => 'service_areas', 'type' => 'relationship', 'post_type' => array( 'service_area' ) ),

                array( 'key' => 'field_lx_so_inclusions', 'label' => 'Inclusions', 'name' => 'inclusions', 'type' => 'checkbox', 'choices' => array( 'chauffeur' => 'Professional Chauffeur', 'water' => 'Bottled Water', 'wifi' => 'WiFi', 'meet-greet' => 'Meet and Greet', 'waiting' => 'Waiting Time' ) ),
                array( 'key' => 'field_lx_so_exclusions', 'label' => 'Exclusions', 'name' => 'exclusions', 'type' => 'checkbox', 'choices' => array( 'tolls' => 'Tolls', 'parking' => 'Parking', 'tips' => 'Gratuity', 'extras' => 'Extra Stops' ) ),
                array( 'key' => 'field_lx_so_special_requirements', 'label' => 'Special Requirements', 'name' => 'special_requirements', 'type' => 'textarea' ),

                array( 'key' => 'field_lx_so_hero_image', 'label' => 'Hero Image', 'name' => 'hero_image', 'type' => 'image' ),
                array( 'key' => 'field_lx_so_gallery', 'label' => 'Gallery', 'name' => 'gallery', 'type' => 'gallery' ),
                array( 'key' => 'field_lx_so_highlight_features', 'label' => 'Highlight Features', 'name' => 'highlight_features', 'type' => 'repeater', 'button_label' => 'Add Feature', 'sub_fields' => array( array( 'key' => 'field_lx_so_highlight_feature_item', 'label' => 'Feature', 'name' => 'feature', 'type' => 'text' ) ) ),
                array( 'key' => 'field_lx_so_ideal_for', 'label' => 'Ideal For', 'name' => 'ideal_for', 'type' => 'repeater', 'button_label' => 'Add Use Case', 'sub_fields' => array( array( 'key' => 'field_lx_so_ideal_for_item', 'label' => 'Use Case', 'name' => 'use_case', 'type' => 'text' ) ) ),

                array( 'key' => 'field_lx_so_ai_generated_description', 'label' => 'AI Generated Description', 'name' => 'ai_generated_description', 'type' => 'wysiwyg' ),
                array( 'key' => 'field_lx_so_ai_key_benefits', 'label' => 'AI Key Benefits', 'name' => 'ai_key_benefits', 'type' => 'textarea' ),
                array( 'key' => 'field_lx_so_ai_faq_content', 'label' => 'AI FAQ Content', 'name' => 'ai_faq_content', 'type' => 'wysiwyg' ),
            ),
            'location' => array(
                array(
                    array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service_offering' ),
                ),
            ),
        )
    );
}
