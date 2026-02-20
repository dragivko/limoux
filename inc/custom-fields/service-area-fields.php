<?php
add_action( 'acf/init', 'limoux_register_service_area_fields' );

function limoux_register_service_area_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_limoux_service_area',
            'title' => 'Service Area Fields',
            'fields' => array(
                array( 'key' => 'field_lx_sa_area_type', 'label' => 'Area Type', 'name' => 'area_type', 'type' => 'select', 'choices' => array( 'city' => 'City', 'region' => 'Region', 'airport' => 'Airport', 'venue' => 'Venue' ) ),
                array( 'key' => 'field_lx_sa_coverage_radius', 'label' => 'Coverage Radius (miles)', 'name' => 'coverage_radius', 'type' => 'number' ),
                array( 'key' => 'field_lx_sa_center_coordinates', 'label' => 'Center Coordinates', 'name' => 'center_coordinates', 'type' => 'google_map' ),
                array( 'key' => 'field_lx_sa_zip_codes_served', 'label' => 'Zip Codes Served', 'name' => 'zip_codes_served', 'type' => 'textarea' ),
                array(
                    'key' => 'field_lx_sa_popular_routes',
                    'label' => 'Popular Routes',
                    'name' => 'popular_routes',
                    'type' => 'repeater',
                    'button_label' => 'Add Route',
                    'sub_fields' => array(
                        array( 'key' => 'field_lx_sa_popular_route_from', 'label' => 'From', 'name' => 'from', 'type' => 'text' ),
                        array( 'key' => 'field_lx_sa_popular_route_to', 'label' => 'To', 'name' => 'to', 'type' => 'text' ),
                        array( 'key' => 'field_lx_sa_popular_route_base_price', 'label' => 'Base Price', 'name' => 'base_price', 'type' => 'number', 'step' => 0.01 ),
                    ),
                ),
                array( 'key' => 'field_lx_sa_area_notes', 'label' => 'Area Notes (Internal)', 'name' => 'area_notes', 'type' => 'textarea' ),
            ),
            'location' => array(
                array(
                    array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service_area' ),
                ),
            ),
        )
    );
}
