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

    <link rel="stylesheet" href="{{ asset('css/styles.css?v=0.01') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shooting-stars.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body>
    <div class="fixed">
        <div id="burger-menu" class="left-5 top-5">
            <span></span>
          </div>
          
          <div id="menu">
              <ul>
                <li><a href="{{ route('quotes.index') }}">Frases</a></li>
                <li><a href="{{ route('quotes.create') }}">Crear frase</a></li>
              </ul>
          </div>
    </div>

    <div id="stars" class="min-h-screen w-full flex flex-col justify-center items-center p-4 main">
        @livewire('quote-display')
    </div>
    
    @livewireScripts
    <script src="{{ asset('js/shooting-stars.js') }}"></script>
    <script>
        var burgerMenu = document.getElementById('burger-menu');
        var overlay = document.getElementById('menu');
        burgerMenu.addEventListener('click',function(){
            this.classList.toggle("close");
            overlay.classList.toggle("overlay");
        });
    </script>
</body>
</html>