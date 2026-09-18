<?php
class WP_TTS_Loader {
    private $settings;
    private $frontend;
    public function __construct() {
        $this->settings = new WP_TTS_Settings();
        $this->frontend = new WP_TTS_Frontend();
    }
    public function run() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_enqueue_scripts', array($this->frontend, 'enqueue_scripts'));
        add_filter('the_content', array($this->frontend, 'add_tts_button'));
    }
    public function add_admin_menu() {
        add_menu_page('WP Text to Speech', 'Text to Speech', 'manage_options', 'wp-text-to-speech', array($this->settings, 'render_settings_page'), 'dashicons-microphone', 30);
    }
    public function register_settings() {
        register_setting('wp_tts_settings_group', 'wp_tts_settings', array('sanitize_callback' => array($this, 'sanitize_settings')));
    }
    public function sanitize_settings($input) {
        $input = is_array($input) ? $input : array();
        return array(
            'enabled' => empty($input['enabled']) ? 0 : 1,
            'voice_lang' => sanitize_text_field($input['voice_lang'] ?? 'hi-IN'),
            'voice_speed' => min(2, max(.5, (float) ($input['voice_speed'] ?? 1))),
            'voice_pitch' => min(2, max(.5, (float) ($input['voice_pitch'] ?? 1))),
            'enable_button' => empty($input['enable_button']) ? 0 : 1,
            'button_position' => in_array($input['button_position'] ?? 'top', array('top','bottom','both'), true) ? $input['button_position'] : 'top',
            'post_types' => array_map('sanitize_key', (array) ($input['post_types'] ?? array('post','page'))),
        );
    }
}
