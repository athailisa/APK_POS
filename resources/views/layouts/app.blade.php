<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Isi title yang kita kirimkan dari views lain-->
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- memanggil Link bootstraps-->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="container mx-auto">

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Isi konten yang kita kirimkan dari views lain-->
         <div class="mt-4">
     @yield('content')
</div>

</div>
    
</body>
</html>