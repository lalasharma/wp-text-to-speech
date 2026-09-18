<?php
class WP_TTS_Frontend {
    public function enqueue_scripts() {
        $s = get_option('wp_tts_settings', array());
        if (empty($s['enabled'])) return;
        wp_enqueue_style('wp-tts-style', WP_TTS_PLUGIN_URL.'assets/css/style.css', array(), WP_TTS_VERSION);
        wp_enqueue_script('wp-tts-script', WP_TTS_PLUGIN_URL.'assets/js/text-to-speech.js', array(), WP_TTS_VERSION, true);
        wp_localize_script('wp-tts-script', 'wpTtsSettings', array('voiceLang'=>$s['voice_lang'] ?? 'hi-IN','voiceSpeed'=>(float)($s['voice_speed'] ?? 1),'voicePitch'=>(float)($s['voice_pitch'] ?? 1)));
    }
    public function add_tts_button($content) {
        $s=get_option('wp_tts_settings', array());
        if (empty($s['enabled']) || empty($s['enable_button']) || !is_singular() || !in_array(get_post_type(), $s['post_types'] ?? array('post','page'), true)) return $content;
        $button='<div class="wp-tts-player-wrapper"><div class="wp-tts-player"><button type="button" id="wp-tts-play-btn" class="wp-tts-btn">🔊 <span>Listen</span></button><button type="button" id="wp-tts-pause-btn" class="wp-tts-btn" style="display:none">⏸ <span>Pause</span></button><button type="button" id="wp-tts-stop-btn" class="wp-tts-btn">⏹ <span>Stop</span></button><div class="wp-tts-progress"><div id="wp-tts-progress-bar"></div></div></div><div id="wp-tts-status" aria-live="polite"></div></div>';
        return ($s['button_position'] ?? 'top') === 'bottom' ? $content.$button : (($s['button_position'] ?? 'top') === 'both' ? $button.$content.$button : $button.$content);
    }
}
