<?php
require_once LIMOUX_DIR . '/inc/ai-providers/class-ai-provider-base.php';
require_once LIMOUX_DIR . '/inc/ai-providers/class-ai-provider-claude.php';
require_once LIMOUX_DIR . '/inc/ai-providers/class-ai-provider-openai.php';
require_once LIMOUX_DIR . '/inc/ai-providers/class-ai-provider-gemini.php';

class Limoux_AI_Engine {
    private $provider;

    public function __construct() {
        $selected = get_option( 'limoux_ai_provider', 'claude' );
        switch ( $selected ) {
            case 'openai':
                $this->provider = new Limoux_AI_Provider_OpenAI();
                break;
            case 'gemini':
                $this->provider = new Limoux_AI_Provider_Gemini();
                break;
            default:
                $this->provider = new Limoux_AI_Provider_Claude();
                break;
        }
    }

    public function generate_content( int $post_id, string $content_type ) {
        if ( ! $this->provider->is_configured() ) {
            return new WP_Error( 'limoux_ai_not_configured', __( 'AI provider API key is missing.', 'limoux' ) );
        }

        $prompt = $this->build_content_prompt( $post_id, $content_type );

        return $this->provider->generate(
            array( array( 'role' => 'user', 'content' => $prompt ) ),
            $this->build_system_prompt()
        );
    }

    private function build_system_prompt(): string {
        $tone = get_option( 'limoux_ai_tone', 'luxurious' );
        $voice = get_option( 'limoux_ai_brand_voice', '' );
        $blocked = get_option( 'limoux_ai_prohibited_phrases', '' );
        $required = get_option( 'limoux_ai_required_disclaimers', '' );
        return "You write premium transportation marketing content. Tone: {$tone}. Brand voice: {$voice}. Avoid: {$blocked}. Include required disclaimers when relevant: {$required}.";
    }

    private function build_content_prompt( int $post_id, string $content_type ): string {
        $post = get_post( $post_id );
        if ( ! $post ) {
            return 'No context provided.';
        }

        return sprintf(
            "Generate %s for post type %s with title '%s'. Existing content: %s",
            sanitize_key( $content_type ),
            sanitize_key( $post->post_type ),
            wp_strip_all_tags( $post->post_title ),
            wp_strip_all_tags( $post->post_content )
        );
    }
}
