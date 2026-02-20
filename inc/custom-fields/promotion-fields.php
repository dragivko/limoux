<?php
add_action( 'acf/init', 'limoux_register_promotion_fields' );

function limoux_register_promotion_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_limoux_promotion',
            'title' => 'Promotion Fields',
            'fields' => array(
                array( 'key' => 'field_lx_promo_type', 'label' => 'Promotion Type', 'name' => 'promo_type', 'type' => 'select', 'choices' => array( 'discount' => 'Discount', 'complimentary' => 'Complimentary', 'upgrade' => 'Upgrade', 'package-deal' => 'Package Deal', 'seasonal' => 'Seasonal' ) ),
                array( 'key' => 'field_lx_discount_value', 'label' => 'Discount Value', 'name' => 'discount_value', 'type' => 'text' ),
                array( 'key' => 'field_lx_promo_description', 'label' => 'Promotion Description', 'name' => 'promo_description', 'type' => 'wysiwyg' ),
                array( 'key' => 'field_lx_terms_and_conditions', 'label' => 'Terms and Conditions', 'name' => 'terms_and_conditions', 'type' => 'textarea' ),

                array( 'key' => 'field_lx_valid_from', 'label' => 'Valid From', 'name' => 'valid_from', 'type' => 'date_picker', 'required' => 1 ),
                array( 'key' => 'field_lx_valid_to', 'label' => 'Valid To', 'name' => 'valid_to', 'type' => 'date_picker', 'required' => 1 ),
                array( 'key' => 'field_lx_promo_code', 'label' => 'Promo Code', 'name' => 'promo_code', 'type' => 'text' ),

                array( 'key' => 'field_lx_applicable_services', 'label' => 'Applicable Services', 'name' => 'applicable_services', 'type' => 'relationship', 'post_type' => array( 'service_offering' ) ),
                array( 'key' => 'field_lx_applicable_vehicles', 'label' => 'Applicable Vehicles', 'name' => 'applicable_vehicles', 'type' => 'relationship', 'post_type' => array( 'fleet_vehicle' ) ),
                array( 'key' => 'field_lx_applicable_packages', 'label' => 'Applicable Packages', 'name' => 'applicable_packages', 'type' => 'relationship', 'post_type' => array( 'tour_package' ) ),

                array( 'key' => 'field_lx_show_on_homepage', 'label' => 'Show on Homepage', 'name' => 'show_on_homepage', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_show_on_service_pages', 'label' => 'Show on Service Pages', 'name' => 'show_on_service_pages', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_badge_label', 'label' => 'Badge Label', 'name' => 'badge_label', 'type' => 'text', 'maxlength' => 30 ),
                array( 'key' => 'field_lx_urgency_message', 'label' => 'Urgency Message', 'name' => 'urgency_message', 'type' => 'text' ),
            ),
            'location' => array(
                array(
                    array( 'param' => 'post_type', 'operator' => '==', 'value' => 'promotion' ),
                ),
            ),
        )
    );
}
