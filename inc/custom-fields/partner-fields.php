<?php
add_action( 'acf/init', 'limoux_register_partner_fields' );

function limoux_register_partner_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_limoux_partner',
            'title' => 'Partner Fields',
            'fields' => array(
                array( 'key' => 'field_lx_partner_business_legal_name', 'label' => 'Business Legal Name', 'name' => 'business_legal_name', 'type' => 'text', 'required' => 1 ),
                array( 'key' => 'field_lx_partner_business_dba', 'label' => 'Business DBA', 'name' => 'business_dba', 'type' => 'text' ),
                array( 'key' => 'field_lx_partner_website', 'label' => 'Website', 'name' => 'website', 'type' => 'url' ),
                array( 'key' => 'field_lx_partner_business_phone', 'label' => 'Business Phone', 'name' => 'business_phone', 'type' => 'text' ),
                array( 'key' => 'field_lx_partner_business_email', 'label' => 'Business Email', 'name' => 'business_email', 'type' => 'email' ),

                array(
                    'key' => 'field_lx_partner_address_group',
                    'label' => 'Address',
                    'name' => 'address_group',
                    'type' => 'group',
                    'sub_fields' => array(
                        array( 'key' => 'field_lx_partner_street_address', 'label' => 'Street Address', 'name' => 'street_address', 'type' => 'text' ),
                        array( 'key' => 'field_lx_partner_city', 'label' => 'City', 'name' => 'city', 'type' => 'text' ),
                        array( 'key' => 'field_lx_partner_state', 'label' => 'State', 'name' => 'state', 'type' => 'select', 'choices' => array( 'AL' => 'AL','AK' => 'AK','AZ' => 'AZ','AR' => 'AR','CA' => 'CA','CO' => 'CO','CT' => 'CT','DE' => 'DE','FL' => 'FL','GA' => 'GA','HI' => 'HI','ID' => 'ID','IL' => 'IL','IN' => 'IN','IA' => 'IA','KS' => 'KS','KY' => 'KY','LA' => 'LA','ME' => 'ME','MD' => 'MD','MA' => 'MA','MI' => 'MI','MN' => 'MN','MS' => 'MS','MO' => 'MO','MT' => 'MT','NE' => 'NE','NV' => 'NV','NH' => 'NH','NJ' => 'NJ','NM' => 'NM','NY' => 'NY','NC' => 'NC','ND' => 'ND','OH' => 'OH','OK' => 'OK','OR' => 'OR','PA' => 'PA','RI' => 'RI','SC' => 'SC','SD' => 'SD','TN' => 'TN','TX' => 'TX','UT' => 'UT','VT' => 'VT','VA' => 'VA','WA' => 'WA','WV' => 'WV','WI' => 'WI','WY' => 'WY' ) ),
                        array( 'key' => 'field_lx_partner_zip_code', 'label' => 'ZIP Code', 'name' => 'zip_code', 'type' => 'text' ),
                        array( 'key' => 'field_lx_partner_coordinates', 'label' => 'Coordinates', 'name' => 'coordinates', 'type' => 'google_map' ),
                    ),
                ),

                array(
                    'key' => 'field_lx_partner_business_hours',
                    'label' => 'Business Hours',
                    'name' => 'business_hours',
                    'type' => 'repeater',
                    'button_label' => 'Add Day',
                    'sub_fields' => array(
                        array( 'key' => 'field_lx_partner_day_of_week', 'label' => 'Day', 'name' => 'day_of_week', 'type' => 'select', 'choices' => array( 'monday' => 'Monday','tuesday' => 'Tuesday','wednesday' => 'Wednesday','thursday' => 'Thursday','friday' => 'Friday','saturday' => 'Saturday','sunday' => 'Sunday' ) ),
                        array( 'key' => 'field_lx_partner_open_time', 'label' => 'Open Time', 'name' => 'open_time', 'type' => 'time_picker' ),
                        array( 'key' => 'field_lx_partner_close_time', 'label' => 'Close Time', 'name' => 'close_time', 'type' => 'time_picker' ),
                        array( 'key' => 'field_lx_partner_closed_all_day', 'label' => 'Closed All Day', 'name' => 'closed_all_day', 'type' => 'true_false', 'ui' => 1 ),
                        array( 'key' => 'field_lx_partner_hours_notes', 'label' => 'Notes', 'name' => 'notes', 'type' => 'text' ),
                    ),
                ),

                array( 'key' => 'field_lx_partner_instagram_handle', 'label' => 'Instagram Handle', 'name' => 'instagram_handle', 'type' => 'text' ),
                array( 'key' => 'field_lx_partner_facebook_page_url', 'label' => 'Facebook URL', 'name' => 'facebook_page_url', 'type' => 'url' ),
                array( 'key' => 'field_lx_partner_tiktok_handle', 'label' => 'TikTok Handle', 'name' => 'tiktok_handle', 'type' => 'text' ),
                array( 'key' => 'field_lx_partner_tripadvisor_url', 'label' => 'TripAdvisor URL', 'name' => 'tripadvisor_url', 'type' => 'url' ),
                array( 'key' => 'field_lx_partner_yelp_url', 'label' => 'Yelp URL', 'name' => 'yelp_url', 'type' => 'url' ),

                array( 'key' => 'field_lx_partner_partnership_status', 'label' => 'Partnership Status', 'name' => 'partnership_status', 'type' => 'select', 'choices' => array( 'active' => 'Active', 'paused' => 'Paused', 'terminated' => 'Terminated' ), 'default_value' => 'active' ),
                array( 'key' => 'field_lx_partner_start_date', 'label' => 'Start Date', 'name' => 'start_date', 'type' => 'date_picker' ),
                array( 'key' => 'field_lx_partner_end_date', 'label' => 'End Date', 'name' => 'end_date', 'type' => 'date_picker' ),
                array( 'key' => 'field_lx_partner_partnership_tier', 'label' => 'Partnership Tier', 'name' => 'partnership_tier', 'type' => 'select', 'choices' => array( 'bronze' => 'Bronze', 'silver' => 'Silver', 'gold' => 'Gold', 'platinum' => 'Platinum' ) ),

                array(
                    'key' => 'field_lx_partner_what_they_offer',
                    'label' => 'What They Offer',
                    'name' => 'what_they_offer',
                    'type' => 'group',
                    'sub_fields' => array(
                        array( 'key' => 'field_lx_partner_standard_offer_description', 'label' => 'Standard Offer Description', 'name' => 'standard_offer_description', 'type' => 'textarea' ),
                        array( 'key' => 'field_lx_partner_standard_offer_capacity', 'label' => 'Standard Offer Capacity', 'name' => 'standard_offer_capacity', 'type' => 'number' ),
                        array( 'key' => 'field_lx_partner_standard_offer_duration', 'label' => 'Standard Offer Duration', 'name' => 'standard_offer_duration', 'type' => 'text' ),
                        array( 'key' => 'field_lx_partner_vip_offer_description', 'label' => 'VIP Offer Description', 'name' => 'vip_offer_description', 'type' => 'textarea' ),
                        array( 'key' => 'field_lx_partner_vip_offer_capacity', 'label' => 'VIP Offer Capacity', 'name' => 'vip_offer_capacity', 'type' => 'number' ),
                        array( 'key' => 'field_lx_partner_vip_offer_duration', 'label' => 'VIP Offer Duration', 'name' => 'vip_offer_duration', 'type' => 'text' ),
                    ),
                ),

                array( 'key' => 'field_lx_partner_cancellation_policy', 'label' => 'Cancellation Policy', 'name' => 'cancellation_policy', 'type' => 'select', 'choices' => array( 'flexible' => 'Flexible', 'moderate' => 'Moderate', 'strict' => 'Strict' ) ),
                array( 'key' => 'field_lx_partner_special_requirements', 'label' => 'Special Requirements', 'name' => 'special_requirements', 'type' => 'textarea' ),
                array( 'key' => 'field_lx_partner_accessibility_features', 'label' => 'Accessibility Features', 'name' => 'accessibility_features', 'type' => 'checkbox', 'choices' => array( 'wheelchair' => 'Wheelchair Accessible', 'elevator' => 'Elevator Access', 'assistive' => 'Assistive Services' ) ),

                array(
                    'key' => 'field_lx_partner_package_inclusions',
                    'label' => 'Package Inclusions',
                    'name' => 'package_inclusions',
                    'type' => 'repeater',
                    'button_label' => 'Add Inclusion',
                    'sub_fields' => array(
                        array( 'key' => 'field_lx_partner_inclusion_type', 'label' => 'Inclusion Type', 'name' => 'inclusion_type', 'type' => 'select', 'choices' => array( 'discount' => 'Discount', 'upgrade' => 'Upgrade', 'amenity' => 'Amenity', 'complimentary' => 'Complimentary' ) ),
                        array( 'key' => 'field_lx_partner_inclusion_description', 'label' => 'Description', 'name' => 'inclusion_description', 'type' => 'text' ),
                        array( 'key' => 'field_lx_partner_available_for_packages', 'label' => 'Available for Packages', 'name' => 'available_for_packages', 'type' => 'relationship', 'post_type' => array( 'tour_package' ) ),
                    ),
                ),

                array( 'key' => 'field_lx_partner_partner_logo', 'label' => 'Partner Logo', 'name' => 'partner_logo', 'type' => 'image' ),
                array( 'key' => 'field_lx_partner_marketing_images', 'label' => 'Marketing Images', 'name' => 'marketing_images', 'type' => 'gallery' ),
                array( 'key' => 'field_lx_partner_promotional_video_url', 'label' => 'Promotional Video URL', 'name' => 'promotional_video_url', 'type' => 'url' ),
                array( 'key' => 'field_lx_partner_marketing_description', 'label' => 'Marketing Description', 'name' => 'marketing_description', 'type' => 'wysiwyg' ),
                array( 'key' => 'field_lx_partner_key_selling_points', 'label' => 'Key Selling Points', 'name' => 'key_selling_points', 'type' => 'repeater', 'button_label' => 'Add Point', 'sub_fields' => array( array( 'key' => 'field_lx_partner_key_selling_point_item', 'label' => 'Point', 'name' => 'point', 'type' => 'text' ) ) ),

                array( 'key' => 'field_lx_partner_ai_partner_description', 'label' => 'AI Partner Description', 'name' => 'ai_partner_description', 'type' => 'wysiwyg' ),
                array( 'key' => 'field_lx_partner_ai_marketing_copy', 'label' => 'AI Marketing Copy', 'name' => 'ai_marketing_copy', 'type' => 'wysiwyg' ),
                array( 'key' => 'field_lx_partner_ai_ideal_pairing', 'label' => 'AI Ideal Pairing', 'name' => 'ai_ideal_pairing', 'type' => 'textarea' ),

                array( 'key' => 'field_lx_partner_show_in_directory', 'label' => 'Show in Directory', 'name' => 'show_in_directory', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_partner_directory_description', 'label' => 'Directory Description', 'name' => 'directory_description', 'type' => 'textarea', 'maxlength' => 200 ),
                array( 'key' => 'field_lx_partner_featured_partner', 'label' => 'Featured Partner', 'name' => 'featured_partner', 'type' => 'true_false', 'ui' => 1 ),
                array( 'key' => 'field_lx_partner_display_order', 'label' => 'Display Order', 'name' => 'display_order', 'type' => 'number' ),
            ),
            'location' => array(
                array(
                    array( 'param' => 'post_type', 'operator' => '==', 'value' => 'partner' ),
                ),
            ),
        )
    );
}
