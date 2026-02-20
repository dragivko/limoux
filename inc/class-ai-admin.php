<?php
class Limoux_AI_Admin {
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'register_metabox' ) );
        add_action( 'wp_ajax_limoux_ai_generate', array( $this, 'ajax_generate' ) );
    }

    public function register_metabox() {
        $screens = array( 'fleet_vehicle', 'tour_package', 'partner', 'service_offering', 'route', 'landing_page', 'promotion' );
        foreach ( $screens as $screen ) {
            add_meta_box( 'limoux-ai-tools', __( 'Generate with AI', 'limoux' ), array( $this, 'render_metabox' ), $screen, 'side', 'default' );
        }
    }

    public function render_metabox( $post ) {
        ?>
        <div class="limoux-ai-panel">
            <p><?php esc_html_e( 'Generate draft copy for this record.', 'limoux' ); ?></p>
            <div class="limoux-ai-actions">
                <button type="button" class="button button-primary limoux-ai-generate" data-post-id="<?php echo esc_attr( $post->ID ); ?>" data-content-type="description"><?php esc_html_e( 'Generate Description', 'limoux' ); ?></button>
                <button type="button" class="button limoux-ai-generate" data-post-id="<?php echo esc_attr( $post->ID ); ?>" data-content-type="seo_description"><?php esc_html_e( 'Generate SEO', 'limoux' ); ?></button>
            </div>
        </div>
        <?php
    }

    public function ajax_generate() {
        check_ajax_referer( 'limoux_ai_generate', 'nonce' );

        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'limoux' ) ), 403 );
        }

        $post_id = isset( $_POST['post_id'] ) ? absint( wp_unslash( $_POST['post_id'] ) ) : 0;
        $content_type = isset( $_POST['content_type'] ) ? sanitize_key( wp_unslash( $_POST['content_type'] ) ) : 'description';

        if ( ! $post_id ) {
            wp_send_json_error( array( 'message' => __( 'Invalid post.', 'limoux' ) ), 400 );
        }

        $engine = new Limoux_AI_Engine();
        $result = $engine->generate_content( $post_id, $content_type );

        if ( is_wp_error( $result ) ) {
            wp_send_json_error( array( 'message' => $result->get_error_message() ), 400 );
        }

        $meta_key = ( 'seo_description' === $content_type ) ? 'seo_description' : 'ai_generated_description';
        update_post_meta( $post_id, $meta_key, wp_kses_post( $result ) );

        wp_send_json_success( array( 'message' => __( 'AI content generated.', 'limoux' ), 'content' => $result, 'meta_key' => $meta_key ) );
    }
}
