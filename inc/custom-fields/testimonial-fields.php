<?php
add_action( 'acf/init', 'limoux_register_testimonial_fields' );

function limoux_register_testimonial_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_limoux_testimonial',
            'title' => 'Testimonial Fields',
            'fields' => array(
                array( 'key' => 'field_lx_testimonial_reviewer_name', 'label' => 'Reviewer Name', 'name' => 'reviewer_name', 'type' => 'text' ),
                array( 'key' => 'field_lx_testimonial_reviewer_title', 'label' => 'Reviewer Title', 'name' => 'reviewer_title', 'type' => 'text' ),
                array( 'key' => 'field_lx_testimonial_reviewer_photo', 'label' => 'Reviewer Photo', 'name' => 'reviewer_photo', 'type' => 'image' ),
                array( 'key' => 'field_lx_testimonial_star_rating', 'label' => 'Star Rating', 'name' => 'star_rating', 'type' => 'number', 'min' => 1, 'max' => 5 ),
                array( 'key' => 'field_lx_testimonial_service_used', 'label' => 'Service Used', 'name' => 'service_used', 'type' => 'relationship', 'post_type' => array( 'service_offering' ), 'max' => 1 ),
                array( 'key' => 'field_lx_testimonial_review_date', 'label' => 'Review Date', 'name' => 'review_date', 'type' => 'date_picker' ),
                array( 'key' => 'field_lx_testimonial_video_testimonial_url', 'label' => 'Video Testimonial URL', 'name' => 'video_testimonial_url', 'type' => 'url' ),
                array( 'key' => 'field_lx_testimonial_featured_testimonial', 'label' => 'Featured Testimonial', 'name' => 'featured_testimonial', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_testimonial_verified_customer', 'label' => 'Verified Customer', 'name' => 'verified_customer', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_testimonial_review_source', 'label' => 'Review Source', 'name' => 'review_source', 'type' => 'select', 'choices' => array( 'direct' => 'Direct', 'google' => 'Google', 'tripadvisor' => 'TripAdvisor', 'yelp' => 'Yelp', 'other' => 'Other' ) ),
            ),
            'location' => array(
                array(
                    array( 'param' => 'post_type', 'operator' => '==', 'value' => 'testimonial' ),
                ),
            ),
        )
    );
}
