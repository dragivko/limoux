<?php
class Limoux_AI_Provider_OpenAI extends Limoux_AI_Provider_Base {
    public const PROVIDER_NAME = 'openai';

    public function is_configured(): bool {
        return ! empty( get_option( 'limoux_ai_api_key_openai', '' ) );
    }

    public function generate( array $messages, string $system_prompt = '', int $max_tokens = 2000 ) {
        $response = wp_remote_post(
            'https://api.openai.com/v1/chat/completions',
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . get_option( 'limoux_ai_api_key_openai', '' ),
                    'Content-Type' => 'application/json',
                ),
                'body' => wp_json_encode(
                    array(
                        'model' => 'gpt-4o',
                        'messages' => array_merge( array( array( 'role' => 'system', 'content' => $system_prompt ) ), $messages ),
                        'max_tokens' => $max_tokens,
                    )
                ),
                'timeout' => 20,
            )
        );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $data = json_decode( wp_remote_retrieve_body( $response ), true );
        return isset( $data['choices'][0]['message']['content'] ) ? (string) $data['choices'][0]['message']['content'] : new WP_Error( 'limoux_ai_error', __( 'AI response was invalid.', 'limoux' ) );
    }
}
