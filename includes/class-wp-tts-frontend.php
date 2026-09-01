<?php
/**
 * Frontend class for text-to-speech functionality
 */

class WP_TTS_Frontend {
    public function enqueue_scripts() {
        $settings = get_option('wp_tts_settings');
        
        if (empty($settings['enabled'])) {
            return;
        }

        // Enqueue CSS
        wp_enqueue_style(
            'wp-tts-style',
            WP_TTS_PLUGIN_URL . 'assets/css/style.css',
            array(),
            WP_TTS_VERSION
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'wp-tts-script',
            WP_TTS_PLUGIN_URL . 'assets/js/text-to-speech.js',
            array(),
            WP_TTS_VERSION,
            true
        );

        // Pass settings to JavaScript
        wp_localize_script(
            'wp-tts-script',
            'wpTtsSettings',
            array(
                'voiceLang' => $settings['voice_lang'] ?? 'en-US',
                'voiceSpeed' => floatval($settings['voice_speed'] ?? 1),
                'voicePitch' => floatval($settings['voice_pitch'] ?? 1),
            )
        );
    }

    public function add_tts_button($content) {
        $settings = get_option('wp_tts_settings');
        
        if (empty($settings['enabled']) || empty($settings['enable_button'])) {
            return $content;
        }

        // Check if current post type is enabled
        if (!in_array(get_post_type(), $settings['post_types'] ?? array())) {
            return $content;
        }

        // Only show on singular pages
        if (!is_singular()) {
            return $content;
        }

        $button = $this->get_player_button();
        $position = $settings['button_position'] ?? 'top';

        switch ($position) {
            case 'top':
                return $button . $content;
            case 'bottom':
                return $content . $button;
            case 'both':
                return $button . $content . $button;
            default:
                return $button . $content;
        }
    }

    private function get_player_button() {
        return '<div class="wp-tts-player-wrapper">
            <div class="wp-tts-player">
                <button id="wp-tts-play-btn" class="wp-tts-btn wp-tts-play" title="Play text-to-speech">
                    <span class="wp-tts-icon">🔊</span>
                    <span class="wp-tts-text">Listen</span>
                </button>
                <button id="wp-tts-pause-btn" class="wp-tts-btn wp-tts-pause" title="Pause text-to-speech" style="display:none;">
                    <span class="wp-tts-icon">⏸</span>
                    <span class="wp-tts-text">Pause</span>
                </button>
                <button id="wp-tts-stop-btn" class="wp-tts-btn wp-tts-stop" title="Stop text-to-speech">
                    <span class="wp-tts-icon">⏹</span>
                    <span class="wp-tts-text">Stop</span>
                </button>
                <div class="wp-tts-progress">
                    <div class="wp-tts-progress-bar" id="wp-tts-progress-bar"></div>
                </div>
            </div>
        </div>';
    }

    public function render_player() {
        $settings = get_option('wp_tts_settings');
        
        if (empty($settings['enabled'])) {
            return;
        }
        ?>
        <div id="wp-tts-hidden" style="display:none;"></div>
        <?php
    }
}
