<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="/resources/css/banniere.All.Page.css"> --}}
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
            @vite(['resources/css/banniere.All.Page.css', 'resources/js/app.js'])


    <title>Document</title>
</head>
<body>
   <section class="banniere-all">
        <div class="banniere-all-page">
            <div class="banniere-content-all-page">
                <h1>@yield('title')</h1>
            </div>
        </div>
    </section> 
    
</body>
</html>