<?php
/**
 * Plugin Name: WP Text to Speech
 * Plugin URI: https://github.com/lalasharma/wp-text-to-speech
 * Description: Convert post content and custom text to speech with audio playback
 * Version: 1.0.0
 * Author: Lala Sharma
 * Author URI: https://github.com/lalasharma
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-text-to-speech
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WP_TTS_VERSION', '1.0.0');
define('WP_TTS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_TTS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include plugin files
require_once WP_TTS_PLUGIN_DIR . 'includes/class-wp-tts-loader.php';
require_once WP_TTS_PLUGIN_DIR . 'includes/class-wp-tts-settings.php';
require_once WP_TTS_PLUGIN_DIR . 'includes/class-wp-tts-frontend.php';

// Initialize the plugin
function wp_tts_init() {
    $loader = new WP_TTS_Loader();
    $loader->run();
}

add_action('plugins_loaded', 'wp_tts_init');

// Activation hook
register_activation_hook(__FILE__, 'wp_tts_activate');
function wp_tts_activate() {
    // Set default options
    if (!get_option('wp_tts_settings')) {
        $default_settings = array(
            'enabled' => 1,
            'voice_lang' => 'en-US',
            'voice_speed' => 1,
            'voice_pitch' => 1,
            'enable_button' => 1,
            'button_position' => 'top',
            'post_types' => array('post', 'page'),
        );
        add_option('wp_tts_settings', $default_settings);
    }
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'wp_tts_deactivate');
function wp_tts_deactivate() {
    // Cleanup if needed
}
