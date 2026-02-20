<?php
/**
 * Theme settings admin page.
 *
 * @package limoux
 */

class Limoux_Theme_Settings {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'register_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    /**
     * Register Limoux admin menu.
     *
     * @return void
     */
    public function register_menu() {
        add_menu_page(
            __( 'Limoux', 'limoux' ),
            __( 'Limoux', 'limoux' ),
            'manage_options',
            'limoux-dashboard',
            array( $this, 'render_dashboard' ),
            'dashicons-admin-site-alt3',
            59
        );

        add_submenu_page(
            'limoux-dashboard',
            __( 'Theme Settings', 'limoux' ),
            __( 'Settings', 'limoux' ),
            'manage_options',
            'limoux-settings',
            array( $this, 'render_settings' )
        );
    }

    /**
     * Register options.
     *
     * @return void
     */
    public function register_settings() {
        $keys = array(
            'limoux_business_name','limoux_business_tagline','limoux_business_phone','limoux_business_email','limoux_business_url',
            'limoux_business_street','limoux_business_city','limoux_business_state','limoux_business_zip','limoux_business_country',
            'limoux_primary_service_type','limoux_business_description',
            'limoux_social_facebook','limoux_social_instagram','limoux_social_x','limoux_social_linkedin','limoux_social_tiktok','limoux_social_youtube','limoux_social_yelp','limoux_social_tripadvisor',
            'limoux_font_pairing','limoux_color_scheme','limoux_color_primary_dark','limoux_color_primary_accent','limoux_color_secondary_accent','limoux_color_background_light','limoux_color_text',
            'limoux_ai_provider','limoux_ai_model','limoux_ai_rate_limit','limoux_ai_brand_voice','limoux_ai_tone','limoux_ai_prohibited_phrases','limoux_ai_required_disclaimers','limoux_ai_content_length',
            'limoux_ai_api_key_claude','limoux_ai_api_key_openai','limoux_ai_api_key_gemini',
            'limoux_webhook_url','limoux_webhook_secret','limoux_webhook_events','limoux_google_maps_api_key',
            'limoux_webp_enabled','limoux_webp_quality','limoux_image_max_dimension','limoux_exif_mode'
        );

        foreach ( $keys as $key ) {
            register_setting( 'limoux_theme_settings', $key );
        }
    }

    /**
     * Render dashboard page.
     *
     * @return void
     */
    public function render_dashboard() {
        echo '<div class="wrap"><h1>' . esc_html__( 'Limoux Dashboard', 'limoux' ) . '</h1>';
        echo '<p>' . esc_html__( 'Use Settings to configure business, design, AI, integrations, and media optimization.', 'limoux' ) . '</p>';
        echo '<p><a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=limoux-settings' ) ) . '">' . esc_html__( 'Open Settings', 'limoux' ) . '</a> ';
        echo '<a class="button" href="' . esc_url( admin_url( 'admin.php?page=limoux-wizard' ) ) . '">' . esc_html__( 'Open Setup Wizard', 'limoux' ) . '</a></p></div>';
    }

    /**
     * Render settings page.
     *
     * @return void
     */
    public function render_settings() {
        $tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'general';
        $tabs = array(
            'general' => __( 'General', 'limoux' ),
            'design' => __( 'Design', 'limoux' ),
            'ai' => __( 'AI Engine', 'limoux' ),
            'integrations' => __( 'Integrations', 'limoux' ),
            'images' => __( 'Image Optimization', 'limoux' ),
        );

        echo '<div class="wrap"><h1>' . esc_html__( 'Theme Settings', 'limoux' ) . '</h1>';
        echo '<h2 class="nav-tab-wrapper">';
        foreach ( $tabs as $slug => $label ) {
            $active = ( $tab === $slug ) ? ' nav-tab-active' : '';
            echo '<a class="nav-tab' . esc_attr( $active ) . '" href="' . esc_url( admin_url( 'admin.php?page=limoux-settings&tab=' . $slug ) ) . '">' . esc_html( $label ) . '</a>';
        }
        echo '</h2>';

        echo '<form method="post" action="options.php">';
        settings_fields( 'limoux_theme_settings' );

        if ( 'design' === $tab ) {
            $this->render_design_tab();
        } elseif ( 'ai' === $tab ) {
            $this->render_ai_tab();
        } elseif ( 'integrations' === $tab ) {
            $this->render_integrations_tab();
        } elseif ( 'images' === $tab ) {
            $this->render_images_tab();
        } else {
            $this->render_general_tab();
        }

        submit_button();
        echo '</form>';
        echo '<p><a class="button" href="' . esc_url( admin_url( 'admin.php?page=limoux-wizard&rerun=1' ) ) . '">' . esc_html__( 'Re-run Setup Wizard', 'limoux' ) . '</a></p>';
        echo '</div>';
    }

    /**
     * Render general tab.
     *
     * @return void
     */
    private function render_general_tab() {
        $this->render_text_field( 'limoux_business_name', 'Business Name' );
        $this->render_text_field( 'limoux_business_tagline', 'Tagline' );
        $this->render_text_field( 'limoux_business_phone', 'Phone' );
        $this->render_text_field( 'limoux_business_email', 'Email', 'email' );
        $this->render_text_field( 'limoux_business_city', 'City' );
        $this->render_text_field( 'limoux_business_state', 'State' );
        $this->render_text_field( 'limoux_business_zip', 'ZIP' );
        $this->render_textarea_field( 'limoux_business_description', 'Business Description' );
    }

    /**
     * Render design tab.
     *
     * @return void
     */
    private function render_design_tab() {
        $this->render_select_field( 'limoux_font_pairing', 'Font Pairing', array( 'classic-luxury' => 'Classic Luxury', 'modern-executive' => 'Modern Executive', 'refined-serif' => 'Refined Serif', 'contemporary' => 'Contemporary', 'bold-prestige' => 'Bold Prestige' ) );
        $this->render_select_field( 'limoux_color_scheme', 'Color Scheme', array( 'midnight-gold' => 'Midnight Gold', 'obsidian-silver' => 'Obsidian Silver', 'navy-champagne' => 'Navy & Champagne', 'charcoal-emerald' => 'Charcoal & Emerald', 'midnight-rose-gold' => 'Midnight & Rose Gold', 'black-white' => 'Pure Black & White' ) );
        $this->render_text_field( 'limoux_color_primary_dark', 'Primary Dark' );
        $this->render_text_field( 'limoux_color_primary_accent', 'Primary Accent' );
        $this->render_text_field( 'limoux_color_background_light', 'Background Light' );
        $this->render_text_field( 'limoux_color_text', 'Text Color' );
    }

    /**
     * Render AI tab.
     *
     * @return void
     */
    private function render_ai_tab() {
        $this->render_select_field( 'limoux_ai_provider', 'AI Provider', array( 'claude' => 'Claude', 'openai' => 'OpenAI', 'gemini' => 'Gemini' ) );
        $this->render_text_field( 'limoux_ai_model', 'Model' );
        $this->render_text_field( 'limoux_ai_api_key_claude', 'Claude API Key', 'password' );
        $this->render_text_field( 'limoux_ai_api_key_openai', 'OpenAI API Key', 'password' );
        $this->render_text_field( 'limoux_ai_api_key_gemini', 'Gemini API Key', 'password' );
        $this->render_text_field( 'limoux_ai_rate_limit', 'Rate Limit (RPM)', 'number' );
        $this->render_text_field( 'limoux_ai_brand_voice', 'Brand Voice Preset' );
        $this->render_text_field( 'limoux_ai_tone', 'Tone' );
        $this->render_textarea_field( 'limoux_ai_prohibited_phrases', 'Prohibited Phrases' );
        $this->render_textarea_field( 'limoux_ai_required_disclaimers', 'Required Disclaimers' );
        $this->render_select_field( 'limoux_ai_content_length', 'Content Length Preference', array( 'short' => 'Short & Punchy', 'standard' => 'Standard', 'long' => 'Long-Form' ) );
    }

    /**
     * Render integrations tab.
     *
     * @return void
     */
    private function render_integrations_tab() {
        $this->render_text_field( 'limoux_webhook_url', 'Webhook URL', 'url' );
        $this->render_text_field( 'limoux_webhook_secret', 'Webhook Secret' );
        $this->render_text_field( 'limoux_webhook_events', 'Webhook Events (comma separated)' );
        $this->render_text_field( 'limoux_google_maps_api_key', 'Google Maps API Key' );
    }

    /**
     * Render image optimization tab.
     *
     * @return void
     */
    private function render_images_tab() {
        $this->render_select_field( 'limoux_webp_enabled', 'WebP Conversion', array( '1' => 'Enabled', '0' => 'Disabled' ) );
        $this->render_text_field( 'limoux_webp_quality', 'WebP Quality', 'number' );
        $this->render_select_field( 'limoux_image_max_dimension', 'Maximum Dimension', array( '1200' => '1200', '1600' => '1600', '2400' => '2400', '0' => 'No limit' ) );
        $this->render_select_field( 'limoux_exif_mode', 'EXIF', array( 'strip_all' => 'Strip all', 'preserve_copyright' => 'Preserve copyright', 'keep_all' => 'Keep all' ) );
    }

    /**
     * Render input row.
     */
    private function render_text_field( $name, $label, $type = 'text' ) {
        $value = (string) get_option( $name, '' );
        echo '<p><label for="' . esc_attr( $name ) . '"><strong>' . esc_html( $label ) . '</strong></label><br />';
        echo '<input class="regular-text" type="' . esc_attr( $type ) . '" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" /></p>';
    }

    /**
     * Render textarea row.
     */
    private function render_textarea_field( $name, $label ) {
        $value = (string) get_option( $name, '' );
        echo '<p><label for="' . esc_attr( $name ) . '"><strong>' . esc_html( $label ) . '</strong></label><br />';
        echo '<textarea class="large-text" rows="4" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $value ) . '</textarea></p>';
    }

    /**
     * Render select row.
     */
    private function render_select_field( $name, $label, $choices ) {
        $value = (string) get_option( $name, '' );
        echo '<p><label for="' . esc_attr( $name ) . '"><strong>' . esc_html( $label ) . '</strong></label><br />';
        echo '<select id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">';
        foreach ( $choices as $choice => $choice_label ) {
            echo '<option value="' . esc_attr( $choice ) . '" ' . selected( $value, (string) $choice, false ) . '>' . esc_html( $choice_label ) . '</option>';
        }
        echo '</select></p>';
    }
}
