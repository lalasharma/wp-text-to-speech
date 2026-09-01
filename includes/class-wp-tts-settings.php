<?php
/**
 * Settings page class
 */

class WP_TTS_Settings {
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        $settings = get_option('wp_tts_settings');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php settings_fields('wp_tts_settings_group'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="wp_tts_enabled">Enable Plugin</label>
                        </th>
                        <td>
                            <input type="checkbox" id="wp_tts_enabled" name="wp_tts_settings[enabled]" value="1" 
                                   <?php checked(!empty($settings['enabled']), 1); ?> />
                            <p class="description">Enable or disable text-to-speech functionality</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wp_tts_voice_lang">Voice Language</label>
                        </th>
                        <td>
                            <select id="wp_tts_voice_lang" name="wp_tts_settings[voice_lang]">
                                <option value="en-US" <?php selected($settings['voice_lang'] ?? 'en-US', 'en-US'); ?>>English (US)</option>
                                <option value="en-GB" <?php selected($settings['voice_lang'] ?? '', 'en-GB'); ?>>English (UK)</option>
                                <option value="es-ES" <?php selected($settings['voice_lang'] ?? '', 'es-ES'); ?>>Spanish</option>
                                <option value="fr-FR" <?php selected($settings['voice_lang'] ?? '', 'fr-FR'); ?>>French</option>
                                <option value="de-DE" <?php selected($settings['voice_lang'] ?? '', 'de-DE'); ?>>German</option>
                                <option value="it-IT" <?php selected($settings['voice_lang'] ?? '', 'it-IT'); ?>>Italian</option>
                                <option value="pt-BR" <?php selected($settings['voice_lang'] ?? '', 'pt-BR'); ?>>Portuguese (Brazil)</option>
                                <option value="ja-JP" <?php selected($settings['voice_lang'] ?? '', 'ja-JP'); ?>>Japanese</option>
                                <option value="zh-CN" <?php selected($settings['voice_lang'] ?? '', 'zh-CN'); ?>>Chinese (Simplified)</option>
                                <option value="hi-IN" <?php selected($settings['voice_lang'] ?? '', 'hi-IN'); ?>>Hindi</option>
                            </select>
                            <p class="description">Select the language for text-to-speech</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wp_tts_voice_speed">Voice Speed</label>
                        </th>
                        <td>
                            <input type="number" id="wp_tts_voice_speed" name="wp_tts_settings[voice_speed]" 
                                   value="<?php echo esc_attr($settings['voice_speed'] ?? 1); ?>" min="0.5" max="2" step="0.1" />
                            <p class="description">Speed of speech (0.5 - 2.0, default: 1.0)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wp_tts_voice_pitch">Voice Pitch</label>
                        </th>
                        <td>
                            <input type="number" id="wp_tts_voice_pitch" name="wp_tts_settings[voice_pitch]" 
                                   value="<?php echo esc_attr($settings['voice_pitch'] ?? 1); ?>" min="0.5" max="2" step="0.1" />
                            <p class="description">Pitch of speech (0.5 - 2.0, default: 1.0)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wp_tts_enable_button">Show Player Button</label>
                        </th>
                        <td>
                            <input type="checkbox" id="wp_tts_enable_button" name="wp_tts_settings[enable_button]" value="1" 
                                   <?php checked(!empty($settings['enable_button']), 1); ?> />
                            <p class="description">Display text-to-speech button on posts</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wp_tts_button_position">Button Position</label>
                        </th>
                        <td>
                            <select id="wp_tts_button_position" name="wp_tts_settings[button_position]">
                                <option value="top" <?php selected($settings['button_position'] ?? 'top', 'top'); ?>>Top of Content</option>
                                <option value="bottom" <?php selected($settings['button_position'] ?? '', 'bottom'); ?>>Bottom of Content</option>
                                <option value="both" <?php selected($settings['button_position'] ?? '', 'both'); ?>>Both</option>
                            </select>
                            <p class="description">Where to display the player button</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Enabled Post Types</label>
                        </th>
                        <td>
                            <?php
                            $post_types = get_post_types(array('public' => true), 'objects');
                            $enabled_types = $settings['post_types'] ?? array();
                            foreach ($post_types as $post_type) {
                                ?>
                                <label>
                                    <input type="checkbox" name="wp_tts_settings[post_types][]" value="<?php echo esc_attr($post_type->name); ?>" 
                                           <?php checked(in_array($post_type->name, $enabled_types), true); ?> />
                                    <?php echo esc_html($post_type->label); ?>
                                </label><br />
                                <?php
                            }
                            ?>
                            <p class="description">Select which post types should have text-to-speech</p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
