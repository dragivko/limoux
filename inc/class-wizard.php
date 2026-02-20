<?php
/**
 * Onboarding wizard controller.
 *
 * @package limoux
 */

class Limoux_Wizard {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'after_switch_theme', array( $this, 'mark_wizard_pending' ) );
        add_action( 'admin_menu', array( $this, 'register_menu' ), 20 );
        add_action( 'admin_init', array( $this, 'maybe_redirect_to_wizard' ) );

        add_action( 'wp_ajax_limoux_wizard_save_state', array( $this, 'ajax_save_state' ) );
        add_action( 'wp_ajax_limoux_wizard_launch', array( $this, 'ajax_launch' ) );
        add_action( 'wp_ajax_limoux_wizard_test_ai', array( $this, 'ajax_test_ai' ) );
        add_action( 'wp_ajax_limoux_wizard_generate_service_areas', array( $this, 'ajax_generate_service_areas' ) );
    }

    /**
     * Theme activation state.
     *
     * @return void
     */
    public function mark_wizard_pending() {
        update_option( 'limoux_wizard_complete', false );
        update_option( 'limoux_wizard_state', array( 'current_step' => 0 ) );
    }

    /**
     * Register wizard submenu.
     *
     * @return void
     */
    public function register_menu() {
        add_submenu_page(
            'limoux-dashboard',
            __( 'Setup Wizard', 'limoux' ),
            __( 'Setup Wizard', 'limoux' ),
            'manage_options',
            'limoux-wizard',
            array( $this, 'render_page' )
        );
    }

    /**
     * Auto-redirect on first activation.
     *
     * @return void
     */
    public function maybe_redirect_to_wizard() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( wp_doing_ajax() ) {
            return;
        }

        $screen = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';

        if ( 'limoux-wizard' === $screen && isset( $_GET['rerun'] ) ) {
            update_option( 'limoux_wizard_complete', false );
            update_option( 'limoux_wizard_state', array( 'current_step' => 0 ) );
        }

        if ( 'limoux-wizard' === $screen ) {
            return;
        }

        if ( (bool) get_option( 'limoux_wizard_complete', false ) ) {
            return;
        }

        wp_safe_redirect( admin_url( 'admin.php?page=limoux-wizard' ) );
        exit;
    }

    /**
     * Render wizard app root.
     *
     * @return void
     */
    public function render_page() {
        echo '<div class="wrap"><div id="limoux-wizard-root"></div></div>';
    }

    /**
     * Save wizard state.
     *
     * @return void
     */
    public function ajax_save_state() {
        check_ajax_referer( 'limoux_wizard_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'limoux' ) ), 403 );
        }

        $state_raw = isset( $_POST['state'] ) ? wp_unslash( $_POST['state'] ) : '{}';
        $decoded = json_decode( (string) $state_raw, true );

        if ( ! is_array( $decoded ) ) {
            wp_send_json_error( array( 'message' => __( 'Invalid state payload.', 'limoux' ) ), 400 );
        }

        update_option( 'limoux_wizard_state', $decoded );
        wp_send_json_success();
    }

    /**
     * Finalize wizard.
     *
     * @return void
     */
    public function ajax_launch() {
        check_ajax_referer( 'limoux_wizard_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'limoux' ) ), 403 );
        }

        update_option( 'limoux_wizard_complete', true );

        $state = get_option( 'limoux_wizard_state', array() );

        $option_map = array(
            'ai_provider'          => 'limoux_ai_provider',
            'ai_model'             => 'limoux_ai_model',
            'business_name'        => 'limoux_business_name',
            'business_city'        => 'limoux_business_city',
            'business_state'       => 'limoux_business_state',
            'business_phone'       => 'limoux_business_phone',
            'business_email'       => 'limoux_business_email',
            'business_description' => 'limoux_business_description',
            'font_pairing'         => 'limoux_font_pairing',
            'color_scheme'         => 'limoux_color_scheme',
            'brand_voice'          => 'limoux_ai_brand_voice',
            'prohibited_phrases'   => 'limoux_ai_prohibited_phrases',
            'required_disclaimers' => 'limoux_ai_required_disclaimers',
            'content_length'       => 'limoux_ai_content_length',
        );

        foreach ( $option_map as $state_key => $option_key ) {
            if ( isset( $state[ $state_key ] ) ) {
                update_option( $option_key, sanitize_textarea_field( (string) $state[ $state_key ] ) );
            }
        }

        if ( isset( $state['ai_api_key'] ) && isset( $state['ai_provider'] ) ) {
            $api_key = sanitize_text_field( (string) $state['ai_api_key'] );
            $provider = sanitize_key( (string) $state['ai_provider'] );

            if ( 'openai' === $provider ) {
                update_option( 'limoux_ai_api_key_openai', $api_key );
            } elseif ( 'gemini' === $provider ) {
                update_option( 'limoux_ai_api_key_gemini', $api_key );
            } else {
                update_option( 'limoux_ai_api_key_claude', $api_key );
            }
        }

        wp_send_json_success(
            array(
                'redirect' => admin_url( 'admin.php?page=limoux-dashboard&limoux_setup=complete' ),
            )
        );
    }

    /**
     * Test AI provider connection.
     *
     * @return void
     */
    public function ajax_test_ai() {
        check_ajax_referer( 'limoux_wizard_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'limoux' ) ), 403 );
        }

        $provider = isset( $_POST['provider'] ) ? sanitize_key( wp_unslash( $_POST['provider'] ) ) : 'claude';
        $api_key = isset( $_POST['api_key'] ) ? sanitize_text_field( wp_unslash( $_POST['api_key'] ) ) : '';
        $model = isset( $_POST['model'] ) ? sanitize_text_field( wp_unslash( $_POST['model'] ) ) : '';

        if ( '' === $api_key ) {
            wp_send_json_error( array( 'message' => __( 'API key is required.', 'limoux' ) ), 400 );
        }

        update_option( 'limoux_ai_provider', $provider );
        update_option( 'limoux_ai_model', $model );

        if ( 'openai' === $provider ) {
            update_option( 'limoux_ai_api_key_openai', $api_key );
        } elseif ( 'gemini' === $provider ) {
            update_option( 'limoux_ai_api_key_gemini', $api_key );
        } else {
            update_option( 'limoux_ai_api_key_claude', $api_key );
        }

        $engine = new Limoux_AI_Engine();
        $result = $engine->generate_content( 0, 'connection_test' );

        if ( is_wp_error( $result ) ) {
            wp_send_json_error( array( 'message' => $result->get_error_message() ), 400 );
        }

        wp_send_json_success( array( 'message' => __( 'Connection successful.', 'limoux' ) ) );
    }

    /**
     * Generate suggested service areas.
     *
     * @return void
     */
    public function ajax_generate_service_areas() {
        check_ajax_referer( 'limoux_wizard_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'limoux' ) ), 403 );
        }

        $manual = isset( $_POST['manual_areas'] ) ? sanitize_textarea_field( wp_unslash( $_POST['manual_areas'] ) ) : '';

        $areas = array();

        if ( '' !== trim( $manual ) ) {
            $areas = array_filter( array_map( 'trim', explode( "\n", $manual ) ) );
        } else {
            $city = (string) get_option( 'limoux_business_city', '' );
            $state = (string) get_option( 'limoux_business_state', '' );

            $fallback = array(
                trim( $city . ' Downtown' ),
                trim( $city . ' Airport' ),
                trim( $city . ' Financial District' ),
                trim( $city . ' Convention Center' ),
                trim( $city . ', ' . $state . ' Metro Area' ),
            );

            $areas = array_values( array_filter( $fallback ) );
        }

        $created = array();

        foreach ( $areas as $area_name ) {
            $post_id = wp_insert_post(
                array(
                    'post_type' => 'service_area',
                    'post_status' => 'draft',
                    'post_title' => sanitize_text_field( $area_name ),
                    'post_excerpt' => __( 'Generated during onboarding wizard.', 'limoux' ),
                )
            );

            if ( ! is_wp_error( $post_id ) ) {
                $created[] = $post_id;
            }
        }

        wp_send_json_success(
            array(
                'count' => count( $created ),
                'ids'   => $created,
            )
        );
    }
}
