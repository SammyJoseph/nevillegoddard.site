<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Neville Goddard') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('img/nevilletoon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Upright:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v=0.02">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shooting-stars.css') }}?v=0.02">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body>
    <div class="fixed z-50">
        <div id="burger-menu" class="left-5 top-5">
            <span></span>
        </div>
        
        <div id="menu" x-data="{
            autoplayActive: false,
            autoplaySeconds: '6',
            tempActive: false,
            tempSeconds: '6',
            init() {
                this.tempActive = this.autoplayActive;
                this.tempSeconds = this.autoplaySeconds;
            },
            saveAutoplay() {
                this.autoplayActive = this.tempActive;
                this.autoplaySeconds = this.tempSeconds;
                window.dispatchEvent(new CustomEvent('update-autoplay', {
                    detail: {
                        active: this.autoplayActive,
                        seconds: parseInt(this.autoplaySeconds)
                    }
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

                <li class="w-full max-w-[280px] p-4 rounded-[25px] border border-white/10 bg-white/[0.03] text-white/85 text-left flex flex-col gap-3 backdrop-blur-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium tracking-wider uppercase text-white/80">Autoplay</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="tempActive" class="sr-only peer">
                            <div class="w-11 h-6 bg-white/20 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                    
                    <div x-show="tempActive" x-transition class="flex flex-col gap-1.5 pt-1">
                        <label class="text-xs text-white/60">Cambiar frase cada:</label>
                        <select x-model="tempSeconds" class="bg-zinc-900/90 text-white border border-white/20 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-white/50 cursor-pointer">
                            <option value="3">3 segundos</option>
                            <option value="6">6 segundos</option>
                            <option value="15">15 segundos</option>
                            <option value="30">30 segundos</option>
                        </select>
                    </div>

                    <button 
                        type="button" 
                        @click="saveAutoplay()"
                        class="mt-1 w-full py-2 px-4 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white font-medium text-xs tracking-wider uppercase transition-all hover:scale-[1.02] active:scale-[0.98]"
                    >
                        Guardar
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div id="stars" class="min-h-screen w-full flex flex-col justify-center items-center p-4 main">
        <div id="stars-background"></div>
        @livewire('quote-display')
    </div>
    
    @livewireScripts
    <script src="{{ asset('js/shooting-stars.js') }}?v=0.02"></script>
    <script>
        var burgerMenu = document.getElementById('burger-menu');
        var overlay = document.getElementById('menu');
        if (burgerMenu && overlay) {
            burgerMenu.addEventListener('click',function(){
                this.classList.toggle("close");
                overlay.classList.toggle("overlay");
                document.body.classList.toggle("menu-open");
            });
        }
    </script>
</body>
</html>