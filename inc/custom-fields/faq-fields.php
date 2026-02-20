<?php
add_action( 'acf/init', 'limoux_register_faq_fields' );

function limoux_register_faq_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_limoux_faq',
            'title' => 'FAQ Fields',
            'fields' => array(
                array( 'key' => 'field_lx_faq_question', 'label' => 'Question', 'name' => 'question', 'type' => 'text', 'required' => 1 ),
                array( 'key' => 'field_lx_faq_answer', 'label' => 'Answer', 'name' => 'answer', 'type' => 'wysiwyg', 'required' => 1 ),
                array( 'key' => 'field_lx_faq_category_meta', 'label' => 'FAQ Category', 'name' => 'faq_category_meta', 'type' => 'select', 'choices' => array( 'general' => 'General', 'booking' => 'Booking', 'vehicles' => 'Vehicles', 'pricing' => 'Pricing', 'events' => 'Events', 'corporate' => 'Corporate', 'cancellation' => 'Cancellation' ) ),
                array( 'key' => 'field_lx_faq_related_service', 'label' => 'Related Service', 'name' => 'related_service', 'type' => 'relationship', 'post_type' => array( 'service_offering' ), 'max' => 1 ),
                array( 'key' => 'field_lx_faq_related_vehicle', 'label' => 'Related Vehicle', 'name' => 'related_vehicle', 'type' => 'relationship', 'post_type' => array( 'fleet_vehicle' ), 'max' => 1 ),
                array( 'key' => 'field_lx_faq_display_order', 'label' => 'Display Order', 'name' => 'display_order', 'type' => 'number' ),
                array( 'key' => 'field_lx_faq_featured_faq', 'label' => 'Featured FAQ', 'name' => 'featured_faq', 'type' => 'true_false', 'ui' => 1 ),
            ),
            'location' => array(
                array(
                    array( 'param' => 'post_type', 'operator' => '==', 'value' => 'faq' ),
                ),
            ),
        )
    );
}
