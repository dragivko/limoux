<?php
/**
 * Image optimization pipeline.
 *
 * @package limoux
 */

class Limoux_Image_Optimizer {

    /**
     * Constructor.
     */
    public function __construct() {
        add_filter( 'wp_generate_attachment_metadata', array( $this, 'optimize_on_upload' ), 10, 2 );
        add_action( 'wp_ajax_limoux_bulk_convert_webp', array( $this, 'ajax_bulk_convert' ) );
    }

    /**
     * Optimize newly uploaded images.
     *
     * @param array $metadata Attachment metadata.
     * @param int   $attachment_id Attachment ID.
     * @return array
     */
    public function optimize_on_upload( $metadata, $attachment_id ) {
        $enabled = (int) get_option( 'limoux_webp_enabled', 1 );
        if ( 1 !== $enabled ) {
            return $metadata;
        }

        $file = get_attached_file( $attachment_id );
        if ( ! $file || ! file_exists( $file ) ) {
            return $metadata;
        }

        $max_dimension = (int) get_option( 'limoux_image_max_dimension', 2400 );
        $quality = (int) get_option( 'limoux_webp_quality', 85 );

        $editor = wp_get_image_editor( $file );
        if ( is_wp_error( $editor ) ) {
            return $metadata;
        }

        if ( $max_dimension > 0 ) {
            $size = $editor->get_size();
            if ( ! empty( $size['width'] ) && ! empty( $size['height'] ) ) {
                $editor->resize( $max_dimension, $max_dimension, false );
            }
        }

        if ( method_exists( $editor, 'set_quality' ) ) {
            $editor->set_quality( $quality );
        }

        $saved = $editor->save( $file );
        if ( is_wp_error( $saved ) ) {
            return $metadata;
        }

        return $metadata;
    }

    /**
     * Bulk optimize current media library.
     *
     * @return void
     */
    public function ajax_bulk_convert() {
        check_ajax_referer( 'limoux_wizard_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'limoux' ) ), 403 );
        }

        $ids = get_posts(
            array(
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'post_status' => 'inherit',
                'fields' => 'ids',
                'posts_per_page' => 50,
            )
        );

        $processed = 0;

        foreach ( $ids as $id ) {
            $meta = wp_get_attachment_metadata( $id );
            $this->optimize_on_upload( is_array( $meta ) ? $meta : array(), $id );
            $processed++;
        }

        wp_send_json_success( array( 'processed' => $processed ) );
    }
}
