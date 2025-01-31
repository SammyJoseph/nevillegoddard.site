<div
    x-data="{ 
        refreshAnimations() {
            this.$nextTick(() => {
                const spans = this.$refs.quoteText.querySelectorAll('span');
                const bibleVerse = this.$refs.bibleVerse;
                const source = this.$refs.source;

                spans.forEach((span, index) => {
                    span.style.animation = 'none';
                    span.offsetHeight; // Trigger reflow
                    span.style.animation = `fade-in 0.8s ${0.1 * (index + 1)}s forwards cubic-bezier(0.11, 0, 0.5, 0)`;
                });

                bibleVerse.classList.remove('animate');
                source.classList.remove('animate');

                setTimeout(() => {
                    bibleVerse.classList.add('animate');
                    source.classList.add('animate');
                }, spans.length * 100 + 800); // Wait for all spans to animate
            });
        }
    }"
    x-init="refreshAnimations"
    x-on:quote-refreshed.window="refreshAnimations"
>
    {{-- Quote --}}
    <h1 x-ref="quoteText" class="text-white text-4xl sm:text-5xl lg:text-6xl !leading-tight font-cormorant-upright-medium"> 
        @foreach ($words as $word)
            <span class="h1-word">{{ $word }}</span>
        @endforeach
    </h1>
    {{-- Source --}}
    <div class="text-white my-4 text-sm sm:text-base">
        <h3 x-ref="bibleVerse" id="bible-verse" class="italic text-center font-merriweather-regular">{{ $quote->bible_verse }}</h3>
        <h3 x-ref="source" id="source" class="text-center font-merriweather-regular">{{ $quote->source->sourceType->name . ': ' . $quote->source->name }}</h3>
    </div>
    {{-- Refresh button --}}
    <div class="text-center">
        <button 
            type="button" 
            wire:click="refreshQuote" 
            class="p-2 rounded-full hover:bg-white/10 transition-colors duration-200"
        >
            <svg 
                xmlns="http://www.w3.org/2000/svg" 
                height="24px" 
                viewBox="0 -960 960 960" 
                width="24px" 
                fill="#ffffff"
                wire:loading.remove
                wire:target="refreshQuote"
            >
                <path d="M480-80q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-440h80q0 117 81.5 198.5T480-160q117 0 198.5-81.5T760-440q0-117-81.5-198.5T480-720h-6l62 62-56 58-160-160 160-160 56 58-62 62h6q75 0 140.5 28.5t114 77q48.5 48.5 77 114T840-440q0 75-28.5 140.5t-77 114q-48.5 48.5-114 77T480-80Z"/>
            </svg>
            <svg 
                xmlns="http://www.w3.org/2000/svg" 
                height="24px" 
                viewBox="0 -960 960 960" 
                width="24px" 
                fill="#ffffff"
                wire:loading
                wire:target="refreshQuote"
                class="animate-spin"
            >
                <path d="M480-80q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-440h80q0 117 81.5 198.5T480-160q117 0 198.5-81.5T760-440q0-117-81.5-198.5T480-720h-6l62 62-56 58-160-160 160-160 56 58-62 62h6q75 0 140.5 28.5t114 77q48.5 48.5 77 114T840-440q0 75-28.5 140.5t-77 114q-48.5 48.5-114 77T480-80Z"/>
            </svg>
        </button>
    </div>
</div>