<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MainTendue') - Donations solidaires</title>

{{--
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- CSS Principal -->
    @vite(['resources/css/app.css', ])



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


     @stack('styles')
</head>
<body>


      <div class="flash-container">
        @if(session('success'))
            <div id="flash-message" class="alert-flash success fade-in">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="close-btn">&times;</button>
            </div>
        @endif

    @if(session('error'))
            <div id="flash-message" class="alert-flash error fade-in">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="close-btn">&times;</button>
            </div>
        @endif
    </div>

     <div id="app" style="display: flex; flex-direction: column; min-height: 100vh;">
    @include('layouts.header')


    <main class="main-content">
        @yield('content')
    </main>

         @include('layouts.footer')
     </div>



    <!-- Votre JavaScript -->
    @vite(['resources/js/app.js'])

    <!-- Scripts additionnels -->
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flash = document.getElementById('flash-message');
            if (flash) {
                setTimeout(() => {
                    flash.classList.add('fade-out'); // Utilise l'animation de ton CSS
                    setTimeout(() => flash.remove(), 500);
                }, 5000); // Disparaît après 5 secondes
            }
        });
    </script>

     <!-- JavaScript -->
    {{-- <script src="{{ asset('js/app.js') }}"></script>  --}}
     {{-- @stack('scripts')  --}}
    {{-- @yield('scripts') --}}
     {{-- @vite([ 'resources/js/app.js']) --}}
</body>
</html>
