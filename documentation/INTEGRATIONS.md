# Integrations

## Webhooks
Configured in settings options:
- `limoux_webhook_url`
- `limoux_webhook_secret`
- `limoux_webhook_events`

Dispatcher class: `inc/integrations/class-webhook-dispatcher.php`.

## REST API
Namespace: `/wp-json/limoux/v1/`.

Core routes include:
- `/partners`
- `/fleet`
- `/routes`
- `/promotions/active`
- `/testimonials`
- `/landing-pages/events`

Class: `inc/integrations/class-rest-api.php`.

## Flowmattic
Native hooks emitted in `inc/integrations/class-flowmattic.php`.
