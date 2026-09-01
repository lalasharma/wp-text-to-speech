# WP Text to Speech

A lightweight WordPress plugin that adds text-to-speech functionality to your website. Convert post content to audio with easy-to-use controls.

## Features

✨ **Core Features:**
- Convert post/page content to speech with one click
- Play, pause, and stop controls
- Adjustable speech speed and pitch
- Support for multiple languages
- Responsive design that works on mobile and desktop
- Progress bar showing playback position

🎛️ **Admin Settings:**
- Enable/disable plugin globally
- Choose voice language
- Adjust voice speed (0.5x - 2.0x)
- Adjust voice pitch (0.5 - 2.0)
- Show/hide player button
- Position button (top, bottom, or both)
- Enable/disable for specific post types

## Requirements

- WordPress 5.0 or higher
- PHP 7.2 or higher
- Modern browser with Web Speech API support (Chrome, Firefox, Safari, Edge)

## Installation

1. Download or clone this repository to your `/wp-content/plugins/` directory
2. Activate the plugin through the WordPress admin panel
3. Go to **Text to Speech** in the WordPress admin menu to configure settings

## Usage

### For Website Visitors

1. Navigate to any post or page where the plugin is enabled
2. Click the **"Listen"** button to start text-to-speech
3. Use the controls:
   - **Pause**: Temporarily pause the audio
   - **Resume**: Continue playing from where it paused
   - **Stop**: Stop the audio and reset

### For Administrators

1. Go to **Text to Speech** in the WordPress admin menu
2. Configure the following settings:
   - **Enable Plugin**: Toggle to enable/disable the entire feature
   - **Voice Language**: Select from 10 supported languages
   - **Voice Speed**: Set playback speed (0.5x - 2.0x normal speed)
   - **Voice Pitch**: Adjust voice pitch (0.5 - 2.0)
   - **Show Player Button**: Enable/disable the listening interface
   - **Button Position**: Choose where the player appears (top, bottom, or both)
   - **Enabled Post Types**: Select which post types should have TTS

## Supported Languages

- English (US)
- English (UK)
- Spanish
- French
- German
- Italian
- Portuguese (Brazil)
- Japanese
- Chinese (Simplified)
- Hindi

## Browser Support

The plugin uses the Web Speech API, which is supported in:

- Chrome/Chromium 25+
- Firefox 49+
- Safari 14.1+
- Edge 79+

Older browsers will show a notification that text-to-speech is not supported.

## File Structure

```
wp-text-to-speech/
├── wp-text-to-speech.php          # Main plugin file
├── includes/
│   ├── class-wp-tts-loader.php   # Plugin loader
│   ├── class-wp-tts-settings.php # Settings page
│   └── class-wp-tts-frontend.php # Frontend functionality
├── assets/
│   ├── css/
│   │   └── style.css             # Player styling
│   └── js/
│       └── text-to-speech.js     # TTS functionality
└── README.md                       # This file
```

## Frequently Asked Questions

### Q: Does this plugin store user audio?
A: No, the plugin uses the browser's native Web Speech API. Audio is processed locally on the user's device and is not sent to any external servers (unless you configure Google Cloud integration).

### Q: Can I customize the player appearance?
A: Yes, you can edit the CSS in `assets/css/style.css` to match your theme.

### Q: What happens if a user's browser doesn't support Text-to-Speech?
A: Users will see a notification message, and the plugin won't display errors.

### Q: Can I add TTS to custom post types?
A: Yes, in the plugin settings, you can select which post types should have text-to-speech enabled.

## Troubleshooting

### Player button doesn't appear
- Make sure the plugin is enabled in settings
- Verify the post type is enabled
- Check that you're viewing a singular post/page, not an archive

### Speech doesn't work
- Ensure your browser supports the Web Speech API
- Check browser console for error messages
- Try a different browser

### Volume is too low
- Check your system volume settings
- Try increasing the pitch setting
- Some browsers adjust volume based on system settings

## Performance

The plugin is lightweight and has minimal impact on page load times:
- Main stylesheet: ~2KB
- Main script: ~5KB
- No external dependencies or API calls (unless configured)

## Security

- All user input is sanitized using WordPress security functions
- Settings are stored securely in the WordPress database
- No external data is transmitted without user consent

## Changelog

### Version 1.1.0
- Added Hindi language support

### Version 1.0.0
- Initial release
- Text-to-speech playback
- Admin settings panel
- Multi-language support
- Responsive player controls

## License

This plugin is licensed under the GPL v2 or later. See the LICENSE file for details.

## Author

Developed by [Lala Sharma](https://github.com/lalasharma)

## Contributing

Contributions are welcome! Please feel free to submit issues or pull requests.

## Support

For issues, feature requests, or support, please visit the [GitHub repository](https://github.com/lalasharma/wp-text-to-speech).
