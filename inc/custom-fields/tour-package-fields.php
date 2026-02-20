<?php
add_action( 'acf/init', 'limoux_register_tour_package_fields' );

function limoux_register_tour_package_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_limoux_tour_package',
            'title' => 'Tour Package Fields',
            'fields' => array(
                array( 'key' => 'field_lx_tp_duration', 'label' => 'Duration', 'name' => 'duration', 'type' => 'number' ),
                array( 'key' => 'field_lx_tp_duration_unit', 'label' => 'Duration Unit', 'name' => 'duration_unit', 'type' => 'select', 'choices' => array( 'hours' => 'Hours', 'days' => 'Days' ) ),
                array( 'key' => 'field_lx_tp_base_price', 'label' => 'Base Price', 'name' => 'base_price', 'type' => 'number', 'step' => 0.01 ),
                array( 'key' => 'field_lx_tp_pricing_model', 'label' => 'Pricing Model', 'name' => 'pricing_model', 'type' => 'select', 'choices' => array( 'per-person' => 'Per Person', 'per-group' => 'Per Group', 'flat-rate' => 'Flat Rate' ) ),

                array(
                    'key' => 'field_lx_tp_itinerary_stops',
                    'label' => 'Itinerary Stops',
                    'name' => 'itinerary_stops',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Stop',
                    'sub_fields' => array(
                        array( 'key' => 'field_lx_tp_stop_name', 'label' => 'Stop Name', 'name' => 'stop_name', 'type' => 'text', 'required' => 1 ),
                        array( 'key' => 'field_lx_tp_stop_description', 'label' => 'Stop Description', 'name' => 'stop_description', 'type' => 'wysiwyg' ),
                        array( 'key' => 'field_lx_tp_arrival_time', 'label' => 'Arrival Time', 'name' => 'arrival_time', 'type' => 'time_picker' ),
                        array( 'key' => 'field_lx_tp_departure_time', 'label' => 'Departure Time', 'name' => 'departure_time', 'type' => 'time_picker' ),
                        array( 'key' => 'field_lx_tp_stop_type', 'label' => 'Stop Type', 'name' => 'stop_type', 'type' => 'select', 'choices' => array( 'pickup' => 'Pickup', 'destination' => 'Destination', 'waypoint' => 'Waypoint', 'photo-op' => 'Photo Op' ) ),
                        array( 'key' => 'field_lx_tp_partner_location', 'label' => 'Partner Location', 'name' => 'partner_location', 'type' => 'relationship', 'post_type' => array( 'partner' ), 'max' => 1 ),
                        array( 'key' => 'field_lx_tp_stop_coordinates', 'label' => 'Stop Coordinates', 'name' => 'stop_coordinates', 'type' => 'google_map' ),
                        array( 'key' => 'field_lx_tp_stop_address', 'label' => 'Stop Address', 'name' => 'stop_address', 'type' => 'text' ),
                        array( 'key' => 'field_lx_tp_stop_notes', 'label' => 'Stop Notes (Internal)', 'name' => 'stop_notes', 'type' => 'textarea' ),
                    ),
                ),

                array( 'key' => 'field_lx_tp_inclusions', 'label' => 'Inclusions', 'name' => 'inclusions', 'type' => 'checkbox', 'choices' => array( 'chauffeur' => 'Professional Chauffeur', 'water' => 'Bottled Water', 'wifi' => 'WiFi', 'waiting' => 'Waiting Time', 'parking' => 'Parking' ) ),
                array( 'key' => 'field_lx_tp_exclusions', 'label' => 'Exclusions', 'name' => 'exclusions', 'type' => 'checkbox', 'choices' => array( 'tips' => 'Gratuity', 'tolls' => 'Tolls', 'tickets' => 'Entry Tickets', 'food' => 'Food and Beverages' ) ),

                array( 'key' => 'field_lx_tp_recommended_vehicle', 'label' => 'Recommended Vehicle', 'name' => 'recommended_vehicle', 'type' => 'relationship', 'post_type' => array( 'fleet_vehicle' ), 'max' => 1 ),
                array( 'key' => 'field_lx_tp_alternative_vehicles', 'label' => 'Alternative Vehicles', 'name' => 'alternative_vehicles', 'type' => 'relationship', 'post_type' => array( 'fleet_vehicle' ) ),
                array( 'key' => 'field_lx_tp_vehicle_upgrade_price', 'label' => 'Vehicle Upgrade Price', 'name' => 'vehicle_upgrade_price', 'type' => 'number', 'step' => 0.01 ),

                array( 'key' => 'field_lx_tp_minimum_participants', 'label' => 'Minimum Participants', 'name' => 'minimum_participants', 'type' => 'number', 'min' => 1, 'max' => 100 ),
                array( 'key' => 'field_lx_tp_maximum_participants', 'label' => 'Maximum Participants', 'name' => 'maximum_participants', 'type' => 'number', 'min' => 1, 'max' => 100 ),
                array( 'key' => 'field_lx_tp_private_tour_available', 'label' => 'Private Tour Available', 'name' => 'private_tour_available', 'type' => 'true_false', 'ui' => 1 ),

                array( 'key' => 'field_lx_tp_advance_booking_days', 'label' => 'Advance Booking Days', 'name' => 'advance_booking_days', 'type' => 'number' ),
                array( 'key' => 'field_lx_tp_cancellation_policy', 'label' => 'Cancellation Policy', 'name' => 'cancellation_policy', 'type' => 'select', 'choices' => array( 'flexible' => 'Flexible', 'moderate' => 'Moderate', 'strict' => 'Strict' ) ),
                array( 'key' => 'field_lx_tp_deposit_required', 'label' => 'Deposit Required (%)', 'name' => 'deposit_required', 'type' => 'number', 'min' => 0, 'max' => 100 ),
                array( 'key' => 'field_lx_tp_deposit_amount', 'label' => 'Deposit Amount', 'name' => 'deposit_amount', 'type' => 'number', 'step' => 0.01 ),

                array( 'key' => 'field_lx_tp_available_dates', 'label' => 'Available Dates', 'name' => 'available_dates', 'type' => 'repeater', 'button_label' => 'Add Date', 'sub_fields' => array( array( 'key' => 'field_lx_tp_available_date_item', 'label' => 'Date', 'name' => 'date', 'type' => 'date_picker' ) ) ),
                array( 'key' => 'field_lx_tp_unavailable_dates', 'label' => 'Unavailable Dates', 'name' => 'unavailable_dates', 'type' => 'repeater', 'button_label' => 'Add Date', 'sub_fields' => array( array( 'key' => 'field_lx_tp_unavailable_date_item', 'label' => 'Date', 'name' => 'date', 'type' => 'date_picker' ) ) ),
                array(
                    'key' => 'field_lx_tp_seasonal_availability',
                    'label' => 'Seasonal Availability',
                    'name' => 'seasonal_availability',
                    'type' => 'repeater',
                    'button_label' => 'Add Season',
                    'sub_fields' => array(
                        array( 'key' => 'field_lx_tp_season_name', 'label' => 'Season', 'name' => 'season', 'type' => 'text' ),
                        array( 'key' => 'field_lx_tp_season_start', 'label' => 'Start Date', 'name' => 'start_date', 'type' => 'date_picker' ),
                        array( 'key' => 'field_lx_tp_season_end', 'label' => 'End Date', 'name' => 'end_date', 'type' => 'date_picker' ),
                    ),
                ),

                array( 'key' => 'field_lx_tp_customizable_stops', 'label' => 'Customizable Stops', 'name' => 'customizable_stops', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_tp_custom_pickup_available', 'label' => 'Custom Pickup Available', 'name' => 'custom_pickup_available', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_tp_flexible_timing', 'label' => 'Flexible Timing', 'name' => 'flexible_timing', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_tp_custom_stop_fee', 'label' => 'Custom Stop Fee', 'name' => 'custom_stop_fee', 'type' => 'number', 'step' => 0.01 ),

                array(
                    'key' => 'field_lx_tp_addon_services',
                    'label' => 'Add-On Services',
                    'name' => 'addon_services',
                    'type' => 'repeater',
                    'button_label' => 'Add Service',
                    'sub_fields' => array(
                        array( 'key' => 'field_lx_tp_addon_name', 'label' => 'Addon Name', 'name' => 'addon_name', 'type' => 'text' ),
                        array( 'key' => 'field_lx_tp_addon_description', 'label' => 'Addon Description', 'name' => 'addon_description', 'type' => 'textarea' ),
                        array( 'key' => 'field_lx_tp_addon_price', 'label' => 'Addon Price', 'name' => 'addon_price', 'type' => 'number', 'step' => 0.01 ),
                        array( 'key' => 'field_lx_tp_addon_type', 'label' => 'Addon Type', 'name' => 'addon_type', 'type' => 'text' ),
                    ),
                ),

                array( 'key' => 'field_lx_tp_hero_image', 'label' => 'Hero Image', 'name' => 'hero_image', 'type' => 'image' ),
                array( 'key' => 'field_lx_tp_gallery', 'label' => 'Gallery', 'name' => 'gallery', 'type' => 'gallery' ),
                array( 'key' => 'field_lx_tp_video_url', 'label' => 'Video URL', 'name' => 'video_url', 'type' => 'url' ),
                array( 'key' => 'field_lx_tp_highlight_features', 'label' => 'Highlight Features', 'name' => 'highlight_features', 'type' => 'repeater', 'button_label' => 'Add Feature', 'sub_fields' => array( array( 'key' => 'field_lx_tp_highlight_feature_item', 'label' => 'Feature', 'name' => 'feature', 'type' => 'text' ) ) ),
                array( 'key' => 'field_lx_tp_best_for_tags', 'label' => 'Best For Tags', 'name' => 'best_for_tags', 'type' => 'repeater', 'button_label' => 'Add Tag', 'sub_fields' => array( array( 'key' => 'field_lx_tp_best_for_tag_item', 'label' => 'Tag', 'name' => 'tag', 'type' => 'text' ) ) ),

                array( 'key' => 'field_lx_tp_ai_package_description', 'label' => 'AI Package Description', 'name' => 'ai_package_description', 'type' => 'wysiwyg' ),
                array( 'key' => 'field_lx_tp_ai_itinerary_narrative', 'label' => 'AI Itinerary Narrative', 'name' => 'ai_itinerary_narrative', 'type' => 'wysiwyg' ),
                array( 'key' => 'field_lx_tp_ai_suggested_upsells', 'label' => 'AI Suggested Upsells', 'name' => 'ai_suggested_upsells', 'type' => 'textarea' ),
            ),
            'location' => array(
                array(
                    array( 'param' => 'post_type', 'operator' => '==', 'value' => 'tour_package' ),
                ),
            ),
        )
    );
}
