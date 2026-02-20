<?php
class Limoux_AI_Provider_Claude extends Limoux_AI_Provider_Base {
    public const PROVIDER_NAME = 'claude';

    public function is_configured(): bool {
        return ! empty( get_option( 'limoux_ai_api_key_claude', '' ) );
    }

    public function generate( array $messages, string $system_prompt = '', int $max_tokens = 2000 ) {
        $response = wp_remote_post(
            'https://api.anthropic.com/v1/messages',
            array(
                'headers' => array(
                    'x-api-key' => get_option( 'limoux_ai_api_key_claude', '' ),
                    'anthropic-version' => '2023-06-01',
                    'content-type' => 'application/json',
                ),
                'body' => wp_json_encode(
                    array(
                        'model' => 'claude-sonnet-4-20250514',
                        'max_tokens' => $max_tokens,
                        'system' => $system_prompt,
                        'messages' => $messages,
                    )
                ),
                'timeout' => 20,
            )
        );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $data = json_decode( wp_remote_retrieve_body( $response ), true );
        return isset( $data['content'][0]['text'] ) ? (string) $data['content'][0]['text'] : new WP_Error( 'limoux_ai_error', __( 'AI response was invalid.', 'limoux' ) );
    }
}
