<?php
abstract class Limoux_AI_Provider_Base {
    public const PROVIDER_NAME = 'base';

    abstract public function is_configured(): bool;

    abstract public function generate( array $messages, string $system_prompt = '', int $max_tokens = 2000 );

    public function get_name(): string {
        return static::PROVIDER_NAME;
    }
}
