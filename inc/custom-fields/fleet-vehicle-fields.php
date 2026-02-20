<?php
add_action( 'acf/init', 'limoux_register_fleet_vehicle_fields' );

function limoux_register_fleet_vehicle_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_limoux_fleet_vehicle',
            'title' => 'Fleet Vehicle Fields',
            'fields' => array(
                array( 'key' => 'field_lx_vehicle_make', 'label' => 'Vehicle Make', 'name' => 'vehicle_make', 'type' => 'text', 'maxlength' => 30 ),
                array( 'key' => 'field_lx_vehicle_model', 'label' => 'Vehicle Model', 'name' => 'vehicle_model', 'type' => 'text', 'maxlength' => 30 ),
                array( 'key' => 'field_lx_vehicle_year', 'label' => 'Vehicle Year', 'name' => 'vehicle_year', 'type' => 'number', 'min' => 1990, 'max' => (int) gmdate( 'Y' ) + 2 ),
                array( 'key' => 'field_lx_vehicle_color', 'label' => 'Vehicle Color', 'name' => 'vehicle_color', 'type' => 'text', 'maxlength' => 20 ),
                array( 'key' => 'field_lx_vehicle_license_plate', 'label' => 'License Plate (Internal)', 'name' => 'vehicle_license_plate', 'type' => 'text' ),

                array( 'key' => 'field_lx_passenger_capacity_max', 'label' => 'Passenger Capacity Max', 'name' => 'passenger_capacity_max', 'type' => 'number', 'min' => 1, 'max' => 50 ),
                array( 'key' => 'field_lx_passenger_capacity_comfort', 'label' => 'Passenger Capacity Comfort', 'name' => 'passenger_capacity_comfort', 'type' => 'number', 'min' => 1, 'max' => 50 ),
                array( 'key' => 'field_lx_luggage_capacity', 'label' => 'Luggage Capacity', 'name' => 'luggage_capacity', 'type' => 'number', 'min' => 0, 'max' => 20 ),

                array( 'key' => 'field_lx_base_hourly_rate', 'label' => 'Base Hourly Rate', 'name' => 'base_hourly_rate', 'type' => 'number', 'step' => 0.01 ),
                array( 'key' => 'field_lx_minimum_hours', 'label' => 'Minimum Hours', 'name' => 'minimum_hours', 'type' => 'number', 'min' => 1, 'max' => 24 ),
                array( 'key' => 'field_lx_airport_transfer_rate', 'label' => 'Airport Transfer Rate', 'name' => 'airport_transfer_rate', 'type' => 'number', 'step' => 0.01 ),
                array( 'key' => 'field_lx_additional_hour_rate', 'label' => 'Additional Hour Rate', 'name' => 'additional_hour_rate', 'type' => 'number', 'step' => 0.01 ),
                array( 'key' => 'field_lx_weekend_surcharge', 'label' => 'Weekend Surcharge (%)', 'name' => 'weekend_surcharge', 'type' => 'number', 'min' => 0, 'max' => 100 ),
                array( 'key' => 'field_lx_holiday_surcharge', 'label' => 'Holiday Surcharge (%)', 'name' => 'holiday_surcharge', 'type' => 'number', 'min' => 0, 'max' => 100 ),

                array(
                    'key' => 'field_lx_operational_status',
                    'label' => 'Operational Status',
                    'name' => 'operational_status',
                    'type' => 'select',
                    'choices' => array( 'active' => 'Active', 'maintenance' => 'Maintenance', 'retired' => 'Retired' ),
                    'default_value' => 'active',
                ),
                array( 'key' => 'field_lx_requires_special_license', 'label' => 'Requires Special License', 'name' => 'requires_special_license', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_insurance_tier', 'label' => 'Insurance Tier', 'name' => 'insurance_tier', 'type' => 'select', 'choices' => array( 'standard' => 'Standard', 'premium' => 'Premium' ) ),
                array( 'key' => 'field_lx_last_service_date', 'label' => 'Last Service Date', 'name' => 'last_service_date', 'type' => 'date_picker' ),
                array( 'key' => 'field_lx_next_service_due', 'label' => 'Next Service Due', 'name' => 'next_service_due', 'type' => 'date_picker' ),

                array( 'key' => 'field_lx_vehicle_gallery', 'label' => 'Vehicle Gallery', 'name' => 'vehicle_gallery', 'type' => 'gallery' ),
                array( 'key' => 'field_lx_vehicle_360_view_url', 'label' => '360 View URL', 'name' => 'vehicle_360_view_url', 'type' => 'url' ),
                array( 'key' => 'field_lx_video_tour_url', 'label' => 'Video Tour URL', 'name' => 'video_tour_url', 'type' => 'url' ),

                array(
                    'key' => 'field_lx_amenities',
                    'label' => 'Amenities',
                    'name' => 'amenities',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Add Amenity',
                    'sub_fields' => array(
                        array( 'key' => 'field_lx_amenity_name', 'label' => 'Amenity Name', 'name' => 'amenity_name', 'type' => 'text' ),
                        array( 'key' => 'field_lx_amenity_available', 'label' => 'Available', 'name' => 'amenity_available', 'type' => 'true_false', 'ui' => 1 ),
                        array( 'key' => 'field_lx_amenity_additional_cost', 'label' => 'Additional Cost', 'name' => 'amenity_additional_cost', 'type' => 'number', 'step' => 0.01 ),
                    ),
                ),

                array( 'key' => 'field_lx_ai_generated_description', 'label' => 'AI Generated Description', 'name' => 'ai_generated_description', 'type' => 'wysiwyg' ),
                array( 'key' => 'field_lx_ai_suggested_use_cases', 'label' => 'AI Suggested Use Cases', 'name' => 'ai_suggested_use_cases', 'type' => 'textarea' ),
                array( 'key' => 'field_lx_ai_upsell_suggestions', 'label' => 'AI Upsell Suggestions', 'name' => 'ai_upsell_suggestions', 'type' => 'textarea' ),

                array( 'key' => 'field_lx_featured_vehicle', 'label' => 'Featured Vehicle', 'name' => 'featured_vehicle', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_marketing_tagline', 'label' => 'Marketing Tagline', 'name' => 'marketing_tagline', 'type' => 'text', 'maxlength' => 100 ),
                array(
                    'key' => 'field_lx_key_features',
                    'label' => 'Key Features',
                    'name' => 'key_features',
                    'type' => 'repeater',
                    'button_label' => 'Add Feature',
                    'sub_fields' => array(
                        array( 'key' => 'field_lx_key_feature_item', 'label' => 'Feature', 'name' => 'feature', 'type' => 'text' ),
                    ),
                ),

                array( 'key' => 'field_lx_available_for_packages', 'label' => 'Available for Packages', 'name' => 'available_for_packages', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_package_surcharge', 'label' => 'Package Surcharge (%)', 'name' => 'package_surcharge', 'type' => 'number', 'min' => 0, 'max' => 100 ),
            ),
            'location' => array(
                array(
                    array( 'param' => 'post_type', 'operator' => '==', 'value' => 'fleet_vehicle' ),
                ),
            ),
        )
    );
}
