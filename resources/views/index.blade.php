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
            selectedSeconds: 10,
            selectInterval(sec) {
                this.selectedSeconds = sec;
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