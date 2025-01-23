<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Neville Goddard') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Upright:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shooting-stars.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body>
    <div id="stars" class="min-h-screen w-full flex flex-col justify-center items-center p-4 main">
        <h1 class="text-white text-4xl sm:text-5xl lg:text-6xl !leading-tight font-cormorant-upright-medium"> 
            @foreach ($words as $word)
                <span class="h1-word">{{ $word }}</span>
            @endforeach
        </h1>
        <div class="text-white mt-6 text-sm sm:text-base">
            <h3 id="bible-verse" class="italic text-center font-merriweather-regular">{{ $quote->bible_verse }}</h3>
            <h3 id="source" class="text-center font-merriweather-regular">{{ $quote->sourceType->name . ': ' . $quote->source }}</h3>
        </div>
    </div>
    
    @livewireScripts
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/shooting-stars.js') }}"></script>
</body>
</html>