<?php
class Limoux_AI_Settings_Page {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'register_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function register_menu() {
        add_options_page( __( 'AI Settings', 'limoux' ), __( 'AI Settings', 'limoux' ), 'manage_options', 'limoux-ai-settings', array( $this, 'render_page' ) );
    }

    public function register_settings() {
        $keys = array(
            'limoux_ai_provider','limoux_ai_api_key_claude','limoux_ai_api_key_openai','limoux_ai_api_key_gemini',
            'limoux_ai_tone','limoux_ai_brand_voice','limoux_ai_prohibited_phrases','limoux_ai_required_disclaimers',
            'limoux_webhook_url','limoux_webhook_secret','limoux_webhook_events'
        );
        foreach ( $keys as $key ) { register_setting( 'limoux_ai_settings', $key ); }
    }

    public function render_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Limoux AI & Integrations', 'limoux' ); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'limoux_ai_settings' ); ?>
                <table class="form-table">
                    <tr><th scope="row"><label for="limoux_ai_provider"><?php esc_html_e( 'AI Provider', 'limoux' ); ?></label></th><td><select name="limoux_ai_provider" id="limoux_ai_provider"><option value="claude" <?php selected( get_option( 'limoux_ai_provider', 'claude' ), 'claude' ); ?>>Claude</option><option value="openai" <?php selected( get_option( 'limoux_ai_provider', 'claude' ), 'openai' ); ?>>OpenAI</option><option value="gemini" <?php selected( get_option( 'limoux_ai_provider', 'claude' ), 'gemini' ); ?>>Gemini</option></select></td></tr>
                    <tr><th scope="row"><?php esc_html_e( 'Claude API Key', 'limoux' ); ?></th><td><input type="password" class="regular-text" name="limoux_ai_api_key_claude" value="<?php echo esc_attr( get_option( 'limoux_ai_api_key_claude', '' ) ); ?>" /></td></tr>
                    <tr><th scope="row"><?php esc_html_e( 'OpenAI API Key', 'limoux' ); ?></th><td><input type="password" class="regular-text" name="limoux_ai_api_key_openai" value="<?php echo esc_attr( get_option( 'limoux_ai_api_key_openai', '' ) ); ?>" /></td></tr>
                    <tr><th scope="row"><?php esc_html_e( 'Gemini API Key', 'limoux' ); ?></th><td><input type="password" class="regular-text" name="limoux_ai_api_key_gemini" value="<?php echo esc_attr( get_option( 'limoux_ai_api_key_gemini', '' ) ); ?>" /></td></tr>
                    <tr><th scope="row"><?php esc_html_e( 'Tone', 'limoux' ); ?></th><td><input type="text" class="regular-text" name="limoux_ai_tone" value="<?php echo esc_attr( get_option( 'limoux_ai_tone', 'luxurious' ) ); ?>" /></td></tr>
                    <tr><th scope="row"><?php esc_html_e( 'Brand Voice', 'limoux' ); ?></th><td><textarea class="large-text" rows="4" name="limoux_ai_brand_voice"><?php echo esc_textarea( get_option( 'limoux_ai_brand_voice', '' ) ); ?></textarea></td></tr>
                    <tr><th scope="row"><?php esc_html_e( 'Prohibited Phrases', 'limoux' ); ?></th><td><textarea class="large-text" rows="4" name="limoux_ai_prohibited_phrases"><?php echo esc_textarea( get_option( 'limoux_ai_prohibited_phrases', '' ) ); ?></textarea></td></tr>
                    <tr><th scope="row"><?php esc_html_e( 'Required Disclaimers', 'limoux' ); ?></th><td><textarea class="large-text" rows="4" name="limoux_ai_required_disclaimers"><?php echo esc_textarea( get_option( 'limoux_ai_required_disclaimers', '' ) ); ?></textarea></td></tr>
                    <tr><th scope="row"><?php esc_html_e( 'Webhook URL', 'limoux' ); ?></th><td><input type="url" class="regular-text" name="limoux_webhook_url" value="<?php echo esc_attr( get_option( 'limoux_webhook_url', '' ) ); ?>" /></td></tr>
                    <tr><th scope="row"><?php esc_html_e( 'Webhook Secret', 'limoux' ); ?></th><td><input type="password" class="regular-text" name="limoux_webhook_secret" value="<?php echo esc_attr( get_option( 'limoux_webhook_secret', '' ) ); ?>" /></td></tr>
                    <tr><th scope="row"><?php esc_html_e( 'Webhook Events (comma separated)', 'limoux' ); ?></th><td><input type="text" class="regular-text" name="limoux_webhook_events" value="<?php echo esc_attr( get_option( 'limoux_webhook_events', '' ) ); ?>" /></td></tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
