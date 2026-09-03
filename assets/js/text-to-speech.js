(function() {
    'use strict';

    const TTS = {
        utterance: null,
        isPlaying: false,
        isPaused: false,
        synth: window.speechSynthesis,
        
        init: function() {
            console.log('TTS Plugin Initialized');
            this.cacheElements();
            this.bindEvents();
        },

        cacheElements: function() {
            this.playBtn = document.getElementById('wp-tts-play-btn');
            this.pauseBtn = document.getElementById('wp-tts-pause-btn');
            this.stopBtn = document.getElementById('wp-tts-stop-btn');
            this.progressBar = document.getElementById('wp-tts-progress-bar');
            
            console.log('Play Btn:', this.playBtn);
            console.log('Pause Btn:', this.pauseBtn);
            console.log('Stop Btn:', this.stopBtn);
        },

        bindEvents: function() {
            if (this.playBtn) {
                this.playBtn.addEventListener('click', this.play.bind(this));
                console.log('Play button event bound');
            }
            if (this.pauseBtn) {
                this.pauseBtn.addEventListener('click', this.pause.bind(this));
            }
            if (this.stopBtn) {
                this.stopBtn.addEventListener('click', this.stop.bind(this));
            }
        },

        getContentText: function() {
            const article = document.querySelector('article') || 
                           document.querySelector('.post') || 
                           document.querySelector('.entry-content') ||
                           document.querySelector('main');
            
            if (article) {
                return article.innerText;
            }
            // Fallback to body content
            const body = document.querySelector('.wp-content') || document.querySelector('.content') || document.body;
            return body ? body.innerText : '';
        },

        play: function() {
            console.log('Play clicked');
            if (this.isPlaying) {
                return;
            }

            // Check browser support
            if (!this.synth) {
                alert('Text-to-Speech is not supported in your browser.');
                return;
            }

            const text = this.getContentText();
            console.log('Content length:', text.length);
            
            if (!text || text.trim().length === 0) {
                alert('No content found to read.');
                return;
            }

            // Cancel any ongoing speech
            this.synth.cancel();

            this.utterance = new SpeechSynthesisUtterance(text);
            this.utterance.rate = wpTtsSettings.voiceSpeed || 1;
            this.utterance.pitch = wpTtsSettings.voicePitch || 1;
            
            // Set language
            const lang = wpTtsSettings.voiceLang || 'en-US';
            this.utterance.lang = lang;
            
            console.log('Language set to:', lang);
            console.log('Speed:', this.utterance.rate);
            console.log('Pitch:', this.utterance.pitch);

            this.utterance.onstart = this.onStart.bind(this);
            this.utterance.onend = this.onEnd.bind(this);
            this.utterance.onerror = this.onError.bind(this);
            this.utterance.onpause = this.onPause.bind(this);
            this.utterance.onresume = this.onResume.bind(this);

            this.synth.speak(this.utterance);
            this.isPlaying = true;
            this.updateButtons();
        },

        pause: function() {
            console.log('Pause clicked');
            if (this.synth && this.isPlaying) {
                this.synth.pause();
                this.isPaused = true;
                this.updateButtons();
            }
        },

        stop: function() {
            console.log('Stop clicked');
            if (this.synth) {
                this.synth.cancel();
                this.isPlaying = false;
                this.isPaused = false;
                this.utterance = null;
                if (this.progressBar) {
                    this.progressBar.style.width = '0%';
                }
                this.updateButtons();
            }
        },

        onStart: function() {
            console.log('Speech started');
            this.isPlaying = true;
            this.isPaused = false;
            this.updateButtons();
            if (this.playBtn) {
                this.playBtn.classList.add('wp-tts-loading');
            }
        },

        onEnd: function() {
            console.log('Speech ended');
            this.isPlaying = false;
            this.isPaused = false;
            this.updateButtons();
            if (this.playBtn) {
                this.playBtn.classList.remove('wp-tts-loading');
            }
            if (this.progressBar) {
                this.progressBar.style.width = '100%';
            }
        },

        onPause: function() {
            console.log('Speech paused');
            this.isPaused = true;
            this.updateButtons();
        },

        onResume: function() {
            console.log('Speech resumed');
            this.isPaused = false;
            this.updateButtons();
        },

        onError: function(event) {
            console.error('Speech synthesis error:', event.error);
            alert('An error occurred during text-to-speech: ' + event.error);
            this.isPlaying = false;
            this.isPaused = false;
            this.updateButtons();
        },

        updateButtons: function() {
            if (!this.playBtn || !this.pauseBtn || !this.stopBtn) {
                return;
            }

            if (this.isPlaying && !this.isPaused) {
                this.playBtn.style.display = 'none';
                this.pauseBtn.style.display = 'inline-flex';
                this.stopBtn.style.display = 'inline-flex';
            } else if (this.isPaused) {
                this.playBtn.style.display = 'inline-flex';
                this.pauseBtn.style.display = 'none';
                this.stopBtn.style.display = 'inline-flex';
                this.playBtn.innerHTML = '<span class="wp-tts-icon">▶</span><span class="wp-tts-text">Resume</span>';
            } else {
                this.playBtn.style.display = 'inline-flex';
                this.pauseBtn.style.display = 'none';
                this.stopBtn.style.display = 'inline-flex';
                this.playBtn.innerHTML = '<span class="wp-tts-icon">🔊</span><span class="wp-tts-text">Listen</span>';
            }
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            TTS.init();
        });
    } else {
        TTS.init();
    }
})();
