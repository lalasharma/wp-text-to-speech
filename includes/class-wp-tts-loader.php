<?php
/**
 * Main plugin loader class
 */

class WP_TTS_Loader {
    private $settings;
    private $frontend;

    public function __construct() {
        $this->settings = new WP_TTS_Settings();
        $this->frontend = new WP_TTS_Frontend();
    }

    public function run() {
        // Admin hooks
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));

        // Frontend hooks
        add_action('wp_enqueue_scripts', array($this->frontend, 'enqueue_scripts'));
        add_action('wp_footer', array($this->frontend, 'render_player'));
        add_filter('the_content', array($this->frontend, 'add_tts_button'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'WP Text to Speech',
            'Text to Speech',
            'manage_options',
            'wp-text-to-speech',
            array($this->settings, 'render_settings_page'),
            'dashicons-microphone',
            30
        );
    }

    public function register_settings() {
        register_setting(
            'wp_tts_settings_group',
            'wp_tts_settings',
            array(
                'type' => 'object',
                'sanitize_callback' => array($this, 'sanitize_settings'),
            )
        );
    }

    public function sanitize_settings($input) {
        $sanitized = array();
        $sanitized['enabled'] = isset($input['enabled']) ? 1 : 0;
        $sanitized['voice_lang'] = sanitize_text_field($input['voice_lang'] ?? 'en-US');
        $sanitized['voice_speed'] = floatval($input['voice_speed'] ?? 1);
        $sanitized['voice_pitch'] = floatval($input['voice_pitch'] ?? 1);
        $sanitized['enable_button'] = isset($input['enable_button']) ? 1 : 0;
        $sanitized['button_position'] = sanitize_text_field($input['button_position'] ?? 'top');
        $sanitized['post_types'] = isset($input['post_types']) ? array_map('sanitize_text_field', $input['post_types']) : array();
        return $sanitized;
    }
}
