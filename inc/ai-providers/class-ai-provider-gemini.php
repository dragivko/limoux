<?php
class Limoux_AI_Provider_Gemini extends Limoux_AI_Provider_Base {
    public const PROVIDER_NAME = 'gemini';

    public function is_configured(): bool {
        return ! empty( get_option( 'limoux_ai_api_key_gemini', '' ) );
    }

    public function generate( array $messages, string $system_prompt = '', int $max_tokens = 2000 ) {
        $prompt = $system_prompt . "\n\n" . implode("\n", array_map(static function( $message ) { return isset( $message['content'] ) ? (string) $message['content'] : ''; }, $messages));
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key=' . rawurlencode( get_option( 'limoux_ai_api_key_gemini', '' ) );

        $response = wp_remote_post(
            $url,
            array(
                'headers' => array( 'Content-Type' => 'application/json' ),
                'body' => wp_json_encode(
                    array(
                        'contents' => array( array( 'parts' => array( array( 'text' => $prompt ) ) ) ),
                        'generationConfig' => array( 'maxOutputTokens' => $max_tokens ),
                    )
                ),
                'timeout' => 20,
            )
        );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $data = json_decode( wp_remote_retrieve_body( $response ), true );
        return isset( $data['candidates'][0]['content']['parts'][0]['text'] ) ? (string) $data['candidates'][0]['content']['parts'][0]['text'] : new WP_Error( 'limoux_ai_error', __( 'AI response was invalid.', 'limoux' ) );
    }
}
