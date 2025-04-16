<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/RL 1080x1080.png') }}" type="image/x-icon">
    <link href="/src/styles.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>Sistem</title>
</head>

<script>
    function toggleMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }
</script>


<body>
    <x-navbar />
    <x-background />

    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen text-white text-center px-4">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">
            Sistem Penyuluhan Karier dan Pendidikan
        </h1>
        <p class="text-lg md:text-xl max-w-2xl drop-shadow-md">
            Temukan arah karier dan pendidikan yang tepat melalui sistem rekomendasi berbasis Machine Learning Decision Tree.
        </p>
    </div>

</body>

</html>
