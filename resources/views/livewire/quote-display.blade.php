<div
    x-data="{ 
        isPlaying: false,
        intervalSeconds: 10,
        timer: null,
        progressOffset: 131.95,
        progressTransition: 'none',

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
                    $wire.nextQuote();
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

        refreshAnimations() {
            this.$nextTick(() => {
                const spans = this.$refs.quoteText ? this.$refs.quoteText.querySelectorAll('span') : [];
                const bibleVerse = this.$refs.bibleVerse;
                const source = this.$refs.source;

                if (spans.length) {
                    spans.forEach((span, index) => {
                        span.style.animation = 'none';
                        span.offsetHeight; // Trigger reflow
                        span.style.animation = `fade-in 0.8s ${0.1 * (index + 1)}s forwards cubic-bezier(0.11, 0, 0.5, 0)`;
                    });
                }

                if (bibleVerse) bibleVerse.classList.remove('animate');
                if (source) source.classList.remove('animate');

                setTimeout(() => {
                    if (bibleVerse) bibleVerse.classList.add('animate');
                    if (source) source.classList.add('animate');
                }, (spans ? spans.length : 0) * 100 + 800);
            });
        }
    }"
    x-init="refreshAnimations()"
    x-on:quote-refreshed.window="
        refreshAnimations();
        if (isPlaying) {
            startTimer();
        }
    "
    x-on:update-autoplay-interval.window="
        intervalSeconds = $event.detail.seconds;
        if (isPlaying) {
            startTimer();
        }
    "
>
    {{-- Quote --}}
    @if ($quote)
        @hasanyrole('admin|super-admin')
            <a href="{{ route('quotes.edit', $quote) }}">
        @endhasanyrole
                <h1 x-ref="quoteText" class="text-white text-4xl sm:text-5xl lg:text-6xl !leading-tight font-cormorant-upright-medium"> 
                    @foreach ($words as $word)
                        <span class="h1-word">{{ $word }}</span>
                    @endforeach
                </h1>
        @hasanyrole('admin|super-admin')
            </a>
        @endhasanyrole
        {{-- Source --}}
        <div class="text-white my-6 text-sm sm:text-base space-y-2">
            <a href="https://www.google.com/search?q={{ urlencode($quote->bible_verse) }}" target="_blank" rel="noopener noreferrer">
                <h3 x-ref="bibleVerse" id="bible-verse" class="italic text-center font-merriweather-regular hover:underline">{{ $quote->bible_verse }}</h3>
            </a>
            <h3 x-ref="source" id="source" class="text-center font-merriweather-regular">{{ $quote->source->sourceType->name . ': ' . $quote->source->name }}</h3>
        </div>
    @else
        <h1 x-ref="quoteText" class="text-white text-4xl sm:text-5xl lg:text-6xl !leading-tight font-cormorant-upright-medium"> 
            <span class="h1-word">No</span>
            <span class="h1-word">hay</span>
            <span class="h1-word">frases</span>
            <span class="h1-word">disponibles</span>
        </h1>
        <div class="text-white my-4 text-sm sm:text-base">
            <h3 x-ref="bibleVerse" id="bible-verse" class="italic text-center font-merriweather-regular"></h3>
            <h3 x-ref="source" id="source" class="text-center font-merriweather-regular"></h3>
        </div>
    @endif

    {{-- Bottom controls --}}
    <div class="fixed bottom-3 left-1/2 transform -translate-x-1/2 flex items-center justify-center">
        <div class="flex items-center gap-3 bg-black/40 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10 shadow-lg">
            {{-- If PAUSED: Show Previous Button --}}
            <template x-if="!isPlaying">
                <button 
                    type="button" 
                    wire:click="previousQuote"
                    wire:loading.attr="disabled"
                    wire:target="previousQuote, nextQuote, refreshQuote"
                    @click="stopTimer()"
                    @if ($currentIndex <= 0) disabled class="p-2 rounded-full opacity-30 cursor-not-allowed text-white" @else class="p-2 rounded-full hover:bg-white/10 transition-colors text-white disabled:opacity-40 disabled:cursor-not-allowed" @endif
                    title="Frase anterior"
                >
                    {{-- Icon --}}
                    <svg wire:loading.remove wire:target="previousQuote" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                        <path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/>
                    </svg>
                    {{-- Spinner --}}
                    <svg wire:loading wire:target="previousQuote" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="animate-spin">
                        <path d="M480-80q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-440h80q0 117 81.5 198.5T480-160q117 0 198.5-81.5T760-440q0-117-81.5-198.5T480-720h-6l62 62-56 58-160-160 160-160 56 58-62 62h6q75 0 140.5 28.5t114 77q48.5 48.5 77 114T840-440q0 75-28.5 140.5t-77 114q-48.5 48.5-114 77T480-80Z"/>
                    </svg>
                </button>
            </template>

            {{-- Play / Pause Button --}}
            <button 
                type="button" 
                @click="togglePlay()" 
                wire:loading.attr="disabled"
                wire:target="previousQuote, nextQuote, refreshQuote"
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
                    wire:click="nextQuote"
                    wire:loading.attr="disabled"
                    wire:target="previousQuote, nextQuote, refreshQuote"
                    @click="stopTimer()"
                    class="p-2 rounded-full hover:bg-white/10 transition-colors text-white disabled:opacity-40 disabled:cursor-not-allowed"
                    title="Siguiente frase"
                >
                    {{-- Icon --}}
                    <svg wire:loading.remove wire:target="nextQuote" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                        <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/>
                    </svg>
                    {{-- Spinner --}}
                    <svg wire:loading wire:target="nextQuote" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="animate-spin">
                        <path d="M480-80q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-440h80q0 117 81.5 198.5T480-160q117 0 198.5-81.5T760-440q0-117-81.5-198.5T480-720h-6l62 62-56 58-160-160 160-160 56 58-62 62h6q75 0 140.5 28.5t114 77q48.5 48.5 77 114T840-440q0 75-28.5 140.5t-77 114q-48.5 48.5-114 77T480-80Z"/>
                    </svg>
                </button>
            </template>
        </div>
    </div>
</div>