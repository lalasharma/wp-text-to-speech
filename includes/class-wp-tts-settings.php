<?php
class WP_TTS_Settings {
    public function render_settings_page() {
        if (!current_user_can('manage_options')) return;
        $s = get_option('wp_tts_settings', array());
        $languages = array('en-US'=>'English (US)','en-GB'=>'English (UK)','hi-IN'=>'Hindi','bn-IN'=>'Bengali','gu-IN'=>'Gujarati','kn-IN'=>'Kannada','ml-IN'=>'Malayalam','mr-IN'=>'Marathi','pa-IN'=>'Punjabi','ta-IN'=>'Tamil','te-IN'=>'Telugu','ur-PK'=>'Urdu','es-ES'=>'Spanish','fr-FR'=>'French','de-DE'=>'German','it-IT'=>'Italian','pt-BR'=>'Portuguese (Brazil)','ja-JP'=>'Japanese','zh-CN'=>'Chinese (Simplified)');
        ?>
        <div class="wrap"><h1><?php echo esc_html(get_admin_page_title()); ?></h1><form method="post" action="options.php">
        <?php settings_fields('wp_tts_settings_group'); ?><table class="form-table">
        <tr><th>Enable plugin</th><td><input type="checkbox" name="wp_tts_settings[enabled]" value="1" <?php checked(!empty($s['enabled'])); ?>></td></tr>
        <tr><th><label for="wp-tts-language">Voice language</label></th><td><select id="wp-tts-language" name="wp_tts_settings[voice_lang]"><?php foreach ($languages as $code=>$label): ?><option value="<?php echo esc_attr($code); ?>" <?php selected($s['voice_lang'] ?? 'hi-IN', $code); ?>><?php echo esc_html($label); ?></option><?php endforeach; ?></select><p class="description">Playback depends on voices installed in the visitor's browser/device.</p></td></tr>
        <tr><th>Speed</th><td><input type="number" name="wp_tts_settings[voice_speed]" min=".5" max="2" step=".1" value="<?php echo esc_attr($s['voice_speed'] ?? 1); ?>"></td></tr>
        <tr><th>Pitch</th><td><input type="number" name="wp_tts_settings[voice_pitch]" min=".5" max="2" step=".1" value="<?php echo esc_attr($s['voice_pitch'] ?? 1); ?>"></td></tr>
        <tr><th>Show listen button</th><td><input type="checkbox" name="wp_tts_settings[enable_button]" value="1" <?php checked(!empty($s['enable_button'])); ?>></td></tr>
        <tr><th>Button position</th><td><select name="wp_tts_settings[button_position]"><option value="top" <?php selected($s['button_position'] ?? 'top','top'); ?>>Top</option><option value="bottom" <?php selected($s['button_position'] ?? '','bottom'); ?>>Bottom</option><option value="both" <?php selected($s['button_position'] ?? '','both'); ?>>Both</option></select></td></tr>
        <tr><th>Post types</th><td><?php $types=get_post_types(array('public'=>true),'objects'); $enabled=$s['post_types'] ?? array('post','page'); foreach($types as $type): ?><label><input type="checkbox" name="wp_tts_settings[post_types][]" value="<?php echo esc_attr($type->name); ?>" <?php checked(in_array($type->name,$enabled,true)); ?>> <?php echo esc_html($type->label); ?></label><br><?php endforeach; ?></td></tr>
        </table><?php submit_button(); ?></form></div><?php
    }
}
