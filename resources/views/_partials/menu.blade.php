<div class="fixed z-50">
    <div id="burger-menu" class="left-5 top-5">
        <span></span>
    </div>
    
    <div id="menu" x-data="{
        selectedSeconds: parseInt(localStorage.getItem('autoplay_interval')) || 10,
        selectInterval(sec) {
            this.selectedSeconds = sec;
            localStorage.setItem('autoplay_interval', sec);
            window.dispatchEvent(new CustomEvent('update-autoplay-interval', {
                detail: { seconds: sec }
            }));
            var burgerMenu = document.getElementById('burger-menu');
            var overlay = document.getElementById('menu');
            if (burgerMenu && overlay) {
                burgerMenu.classList.remove('close');
                overlay.classList.remove('overlay');
                document.body.classList.remove('menu-open');
            }
        }
    }">
        <ul>
            @auth
                @hasanyrole('admin|super-admin')
                    <li><a href="{{ route('quotes.index') }}">Frases</a></li>
                    <li><a href="{{ route('quotes.create') }}">Crear frase</a></li>
                @endhasanyrole
            @endauth

            <li class="w-full max-w-[280px] p-4 rounded-[25px] border border-white/10 bg-white/[0.03] text-white/85 text-center flex flex-col gap-3 backdrop-blur-sm">
                <span class="text-xs font-medium tracking-wider uppercase text-white/60">Cambiar frase cada:</span>
                
                <div class="grid grid-cols-2 gap-2">
                    <button 
                        type="button" 
                        @click="selectInterval(10)"
                        :class="selectedSeconds === 10 ? 'bg-white text-black font-semibold border-white' : 'bg-white/10 text-white hover:bg-white/20 border-white/20'"
                        class="py-2 px-3 rounded-xl border text-sm font-medium transition-all hover:scale-[1.03] active:scale-[0.97]"
                    >
                        10s
                    </button>
                    <button 
                        type="button" 
                        @click="selectInterval(20)"
                        :class="selectedSeconds === 20 ? 'bg-white text-black font-semibold border-white' : 'bg-white/10 text-white hover:bg-white/20 border-white/20'"
                        class="py-2 px-3 rounded-xl border text-sm font-medium transition-all hover:scale-[1.03] active:scale-[0.97]"
                    >
                        20s
                    </button>
                    <button 
                        type="button" 
                        @click="selectInterval(30)"
                        :class="selectedSeconds === 30 ? 'bg-white text-black font-semibold border-white' : 'bg-white/10 text-white hover:bg-white/20 border-white/20'"
                        class="py-2 px-3 rounded-xl border text-sm font-medium transition-all hover:scale-[1.03] active:scale-[0.97]"
                    >
                        30s
                    </button>
                    <button 
                        type="button" 
                        @click="selectInterval(60)"
                        :class="selectedSeconds === 60 ? 'bg-white text-black font-semibold border-white' : 'bg-white/10 text-white hover:bg-white/20 border-white/20'"
                        class="py-2 px-3 rounded-xl border text-sm font-medium transition-all hover:scale-[1.03] active:scale-[0.97]"
                    >
                        60s
                    </button>
                </div>
            </li>
        </ul>
    </div>
</div>
