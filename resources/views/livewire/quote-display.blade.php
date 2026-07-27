<div
    x-data="{ 
        quotes: @js($quotes),
        currentIndex: 0,
        isPlaying: false,
        intervalSeconds: parseInt(localStorage.getItem('autoplay_interval')) || 10,
        timer: null,
        progressOffset: 131.95,
        progressTransition: 'none',
        touchStartX: 0,
        touchEndX: 0,
        animationTimeout: null,

        get currentQuote() {
            return this.quotes.length > 0 ? this.quotes[this.currentIndex] : null;
        },

        nextQuote() {
            if (!this.quotes.length) return;
            if (this.currentIndex < this.quotes.length - 1) {
                this.currentIndex++;
            } else {
                this.currentIndex = 0;
            }
            this.onQuoteChanged();
        },

        previousQuote() {
            if (!this.quotes.length) return;
            if (this.currentIndex > 0) {
                this.currentIndex--;
                this.onQuoteChanged();
            }
        },

        onQuoteChanged() {
            const bibleVerse = this.$refs.bibleVerse;
            const source = this.$refs.source;
            if (bibleVerse) bibleVerse.classList.remove('animate');
            if (source) source.classList.remove('animate');

            this.refreshAnimations();
            if (this.isPlaying) {
                this.startTimer();
            }
        },

        resetProgressRing() {
            this.progressTransition = 'none';
            this.progressOffset = 131.95;
            if (this.isPlaying) {
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        this.progressTransition = `stroke-dashoffset ${this.intervalSeconds}s linear`;
                        this.progressOffset = 0;
                    });
                });
            }
        },

        startTimer() {
            this.stopTimer();
            if (this.isPlaying) {
                this.resetProgressRing();
                this.timer = setInterval(() => {
                    this.nextQuote();
                }, this.intervalSeconds * 1000);
            } else {
                this.progressTransition = 'none';
                this.progressOffset = 131.95;
            }
        },

        stopTimer() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
            this.progressTransition = 'none';
            this.progressOffset = 131.95;
        },

        togglePlay() {
            this.isPlaying = !this.isPlaying;
            if (this.isPlaying) {
                this.startTimer();
            } else {
                this.stopTimer();
            }
        },

        handleKeyup(e) {
            if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) return;
            if (e.key === 'ArrowRight') {
                this.stopTimer();
                this.nextQuote();
            } else if (e.key === 'ArrowLeft') {
                this.stopTimer();
                this.previousQuote();
            }
        },

        handleTouchStart(e) {
            if (e.changedTouches && e.changedTouches.length) {
                this.touchStartX = e.changedTouches[0].screenX;
            }
        },

        handleTouchEnd(e) {
            if (e.changedTouches && e.changedTouches.length) {
                this.touchEndX = e.changedTouches[0].screenX;
                this.handleSwipe();
            }
        },

        handleSwipe() {
            const diff = this.touchEndX - this.touchStartX;
            if (Math.abs(diff) > 50) {
                if (diff < 0) {
                    this.stopTimer();
                    this.nextQuote();
                } else {
                    this.stopTimer();
                    this.previousQuote();
                }
            }
        },

        refreshAnimations() {
            if (this.animationTimeout) {
                clearTimeout(this.animationTimeout);
                this.animationTimeout = null;
            }

            this.$nextTick(() => {
                const spans = this.$refs.quoteText ? this.$refs.quoteText.querySelectorAll('span') : [];
                const bibleVerse = this.$refs.bibleVerse;
                const source = this.$refs.source;

                if (bibleVerse) bibleVerse.classList.remove('animate');
                if (source) source.classList.remove('animate');

                if (spans.length) {
                    spans.forEach((span, index) => {
                        span.style.animation = 'none';
                        span.offsetHeight; // Trigger reflow
                        span.style.animation = `fade-in 0.8s ${0.1 * (index + 1)}s forwards cubic-bezier(0.11, 0, 0.5, 0)`;
                    });
                }

                const delay = (spans ? spans.length : 0) * 100 + 800;
                this.animationTimeout = setTimeout(() => {
                    if (bibleVerse) bibleVerse.classList.add('animate');
                    if (source) source.classList.add('animate');
                    this.animationTimeout = null;
                }, delay);
            });
        }
    }"
    x-init="refreshAnimations()"
    x-on:keyup.window="handleKeyup($event)"
    x-on:touchstart.passive="handleTouchStart($event)"
    x-on:touchend.passive="handleTouchEnd($event)"
    x-on:update-autoplay-interval.window="
        intervalSeconds = $event.detail.seconds;
        if (isPlaying) {
            startTimer();
        }
    "
>
    {{-- Quote --}}
    <template x-if="currentQuote">
        <div>
            <template x-if="currentQuote.edit_url">
                <a :href="currentQuote.edit_url">
                    <h1 x-ref="quoteText" class="text-white text-4xl sm:text-5xl lg:text-6xl !leading-tight font-cormorant-upright-medium"> 
                        <template x-for="(word, index) in currentQuote.words" :key="currentQuote.id + '-' + index">
                            <span class="h1-word mr-[0.25em]" x-text="word"></span>
                        </template>
                    </h1>
                </a>
            </template>
            <template x-if="!currentQuote.edit_url">
                <h1 x-ref="quoteText" class="text-white text-4xl sm:text-5xl lg:text-6xl !leading-tight font-cormorant-upright-medium"> 
                    <template x-for="(word, index) in currentQuote.words" :key="currentQuote.id + '-' + index">
                        <span class="h1-word mr-[0.25em]" x-text="word"></span>
                    </template>
                </h1>
            </template>
            {{-- Source --}}
            <div class="text-white my-6 text-sm sm:text-base space-y-2">
                <template x-if="currentQuote.bible_verse">
                    <div class="flex justify-center">
                        <a 
                            :href="'https://www.biblegateway.com/passage/?search=' + encodeURIComponent(currentQuote.bible_verse) + '&version=RVR1960'" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            @click="if (isPlaying) { isPlaying = false; stopTimer(); }"
                            class="inline-block"
                        >
                            <h3 x-ref="bibleVerse" id="bible-verse" class="italic text-center font-merriweather-regular hover:underline" x-text="currentQuote.bible_verse"></h3>
                        </a>
                    </div>
                </template>
                <h3 x-ref="source" id="source" class="text-center font-merriweather-regular" x-text="currentQuote.source_text"></h3>
            </div>
        </div>
    </template>

    <template x-if="!currentQuote">
        <div>
            <h1 x-ref="quoteText" class="text-white text-4xl sm:text-5xl lg:text-6xl !leading-tight font-cormorant-upright-medium"> 
                <span class="h1-word mr-[0.25em]">No</span>
                <span class="h1-word mr-[0.25em]">hay</span>
                <span class="h1-word mr-[0.25em]">frases</span>
                <span class="h1-word mr-[0.25em]">disponibles</span>
            </h1>
            <div class="text-white my-4 text-sm sm:text-base">
                <h3 x-ref="bibleVerse" id="bible-verse" class="italic text-center font-merriweather-regular"></h3>
                <h3 x-ref="source" id="source" class="text-center font-merriweather-regular"></h3>
            </div>
        </div>
    </template>

    {{-- Bottom controls --}}
    <div class="fixed bottom-3 left-1/2 transform -translate-x-1/2 flex items-center justify-center">
        <div class="flex items-center gap-3 bg-black/40 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10 shadow-lg">
            {{-- If PAUSED: Show Previous Button --}}
            <template x-if="!isPlaying">
                <button 
                    type="button" 
                    @click="stopTimer(); previousQuote()"
                    :disabled="currentIndex <= 0"
                    :class="currentIndex <= 0 ? 'p-2 rounded-full opacity-30 cursor-not-allowed text-white' : 'p-2 rounded-full hover:bg-white/10 transition-colors text-white disabled:opacity-40 disabled:cursor-not-allowed'"
                    title="Frase anterior (Flecha izquierda)"
                >
                    {{-- Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                        <path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/>
                    </svg>
                </button>
            </template>

            {{-- Play / Pause Button --}}
            <button 
                type="button" 
                @click="togglePlay()" 
                class="relative p-2.5 rounded-full hover:bg-white/10 transition-colors text-white flex items-center justify-center disabled:opacity-40 disabled:cursor-not-allowed"
                :title="isPlaying ? 'Pausar' : 'Reproducir'"
            >
                {{-- Animated Circular Progress Ring around Pause button --}}
                <svg 
                    x-show="isPlaying" 
                    class="absolute -inset-0.5 w-[calc(100%+4px)] h-[calc(100%+4px)] -rotate-90 pointer-events-none" 
                    viewBox="0 0 48 48"
                >
                    {{-- Background Track --}}
                    <circle
                        cx="24"
                        cy="24"
                        r="21"
                        fill="none"
                        stroke="rgba(255, 255, 255, 0.15)"
                        stroke-width="2"
                    />
                    {{-- Progress Ring starting at 12:00 (due to -rotate-90) --}}
                    <circle
                        cx="24"
                        cy="24"
                        r="21"
                        fill="none"
                        stroke="#ffffff"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-dasharray="131.95"
                        :stroke-dashoffset="progressOffset"
                        :style="{ transition: progressTransition }"
                    />
                </svg>

                {{-- Pause SVG --}}
                <svg x-show="isPlaying" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="relative z-10">
                    <path d="M520-200v-560h160v560H520Zm-240 0v-560h160v560H280Z"/>
                </svg>
                {{-- Play SVG --}}
                <svg x-show="!isPlaying" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="relative z-10">
                    <path d="M320-200v-560l440 280-440 280Z"/>
                </svg>
            </button>

            {{-- If PAUSED: Show Next Button --}}
            <template x-if="!isPlaying">
                <button 
                    type="button" 
                    @click="stopTimer(); nextQuote()"
                    class="p-2 rounded-full hover:bg-white/10 transition-colors text-white disabled:opacity-40 disabled:cursor-not-allowed"
                    title="Siguiente frase (Flecha derecha)"
                >
                    {{-- Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                        <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/>
                    </svg>
                </button>
            </template>
        </div>
    </div>
</div>