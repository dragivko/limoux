<?php
/**
 * Registers all CPTs and fields.
 *
 * @package limoux
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$limoux_cpt_files = array(
    '/inc/cpt/class-fleet-vehicle.php',
    '/inc/cpt/class-service-offering.php',
    '/inc/cpt/class-tour-package.php',
    '/inc/cpt/class-partner.php',
    '/inc/cpt/class-testimonial.php',
    '/inc/cpt/class-service-area.php',
    '/inc/cpt/class-route.php',
    '/inc/cpt/class-landing-page.php',
    '/inc/cpt/class-promotion.php',
    '/inc/cpt/class-faq.php',
);

foreach ( $limoux_cpt_files as $limoux_file ) {
    require_once LIMOUX_DIR . $limoux_file;
}

$limoux_field_files = array(
    '/inc/custom-fields/fleet-vehicle-fields.php',
    '/inc/custom-fields/tour-package-fields.php',
    '/inc/custom-fields/partner-fields.php',
    '/inc/custom-fields/service-offering-fields.php',
    '/inc/custom-fields/testimonial-fields.php',
    '/inc/custom-fields/service-area-fields.php',
    '/inc/custom-fields/route-fields.php',
    '/inc/custom-fields/landing-page-fields.php',
    '/inc/custom-fields/promotion-fields.php',
    '/inc/custom-fields/faq-fields.php',
);

foreach ( $limoux_field_files as $limoux_file ) {
    require_once LIMOUX_DIR . $limoux_file;
}

new Limoux_Fleet_Vehicle_CPT();
new Limoux_Service_Offering_CPT();
new Limoux_Tour_Package_CPT();
new Limoux_Partner_CPT();
new Limoux_Testimonial_CPT();
new Limoux_Service_Area_CPT();
new Limoux_Route_CPT();
new Limoux_Landing_Page_CPT();
new Limoux_Promotion_CPT();
new Limoux_FAQ_CPT();
