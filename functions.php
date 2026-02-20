<?php
/**
 * Limoux theme bootstrap.
 *
 * @package limoux
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'LIMOUX_VERSION', '1.3.0' );
define( 'LIMOUX_DIR', get_template_directory() );
define( 'LIMOUX_URI', get_template_directory_uri() );

require_once LIMOUX_DIR . '/inc/functions-cpt.php';
require_once LIMOUX_DIR . '/inc/class-schema-manager.php';
require_once LIMOUX_DIR . '/inc/class-ai-engine.php';
require_once LIMOUX_DIR . '/inc/class-ai-settings-page.php';
require_once LIMOUX_DIR . '/inc/class-ai-admin.php';
require_once LIMOUX_DIR . '/inc/integrations/class-webhook-dispatcher.php';
require_once LIMOUX_DIR . '/inc/integrations/class-rest-api.php';
require_once LIMOUX_DIR . '/inc/integrations/class-flowmattic.php';

add_action( 'after_setup_theme', 'limoux_setup_theme' );

function limoux_setup_theme() {
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/custom.css' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'responsive-embeds' );
}

add_action( 'wp_enqueue_scripts', 'limoux_enqueue_assets' );

function limoux_enqueue_assets() {
    wp_enqueue_style( 'limoux-style', get_stylesheet_uri(), array(), LIMOUX_VERSION );
    wp_enqueue_style( 'limoux-custom', LIMOUX_URI . '/assets/css/custom.css', array( 'limoux-style' ), LIMOUX_VERSION );
    wp_enqueue_script( 'limoux-main', LIMOUX_URI . '/assets/js/main.js', array(), LIMOUX_VERSION, true );
}

add_action( 'admin_enqueue_scripts', 'limoux_enqueue_admin_assets' );

function limoux_enqueue_admin_assets() {
    wp_enqueue_style( 'limoux-ai-admin', LIMOUX_URI . '/assets/css/ai-admin.css', array(), LIMOUX_VERSION );
    wp_enqueue_script( 'limoux-ai-admin', LIMOUX_URI . '/assets/js/ai-admin.js', array( 'jquery' ), LIMOUX_VERSION, true );

    wp_localize_script(
        'limoux-ai-admin',
        'limouxAi',
        array(
            'nonce'   => wp_create_nonce( 'limoux_ai_generate' ),
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        )
    );
}

add_action( 'admin_init', 'limoux_validate_scf_dependency' );

function limoux_validate_scf_dependency() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    add_action(
        'admin_notices',
        static function() {
            echo '<div class="notice notice-error"><p>';
            echo esc_html__( 'Limoux requires the Secure Custom Fields plugin.', 'limoux' ) . ' ';
            echo '<a href="' . esc_url( admin_url( 'plugin-install.php?s=secure+custom+fields&tab=search' ) ) . '">';
            echo esc_html__( 'Install it now.', 'limoux' );
            echo '</a></p></div>';
        }
    );
}

new Limoux_Schema_Manager();
new Limoux_AI_Settings_Page();
new Limoux_AI_Admin();
new Limoux_Webhook_Dispatcher();
new Limoux_REST_API();
new Limoux_Flowmattic();
