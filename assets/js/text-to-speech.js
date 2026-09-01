(function() {
    'use strict';

    const TTS = {
        utterance: null,
        isPlaying: false,
        isPaused: false,
        synth: window.speechSynthesis,
        
        init: function() {
            this.cacheElements();
            this.bindEvents();
        },

        cacheElements: function() {
            this.playBtn = document.getElementById('wp-tts-play-btn');
            this.pauseBtn = document.getElementById('wp-tts-pause-btn');
            this.stopBtn = document.getElementById('wp-tts-stop-btn');
            this.progressBar = document.getElementById('wp-tts-progress-bar');
        },

        bindEvents: function() {
            if (this.playBtn) {
                this.playBtn.addEventListener('click', this.play.bind(this));
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
            return document.body.innerText;
        },

        play: function() {
            if (this.isPlaying) {
                return;
            }

            // Check browser support
            if (!this.synth) {
                alert('Text-to-Speech is not supported in your browser.');
                return;
            }

            const text = this.getContentText();
            if (!text) {
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
            if (this.synth && this.isPlaying) {
                this.synth.pause();
                this.isPaused = true;
                this.updateButtons();
            }
        },

        stop: function() {
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
            this.isPlaying = true;
            this.isPaused = false;
            this.updateButtons();
            if (this.playBtn) {
                this.playBtn.classList.add('wp-tts-loading');
            }
        },

        onEnd: function() {
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
            this.isPaused = true;
            this.updateButtons();
        },

        onResume: function() {
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
