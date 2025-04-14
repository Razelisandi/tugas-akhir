<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

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

    <div class="relative min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 overflow-hidden">
        <!-- Abstract circles -->
        <div
            class="absolute top-[-100px] left-[-100px] w-[400px] h-[400px] bg-white opacity-20 rounded-full blur-3xl animate-pulse">
        </div>
        <div
            class="absolute bottom-[-120px] right-[-100px] w-[300px] h-[300px] bg-white opacity-20 rounded-full blur-2xl animate-ping">
        </div>
        <div
            class="absolute top-[30%] left-[50%] w-[150px] h-[150px] bg-white opacity-10 rounded-full blur-2xl transform -translate-x-1/2">
        </div>

        <!-- Main content -->
        <div class="relative z-10 flex flex-col items-center justify-center h-screen text-white text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">Sistem Penyuluhan Karier dan Pendidikan</h1>
            <p class="text-lg md:text-xl max-w-2xl drop-shadow-md">Temukan arah karier dan pendidikan yang tepat melalui
                sistem rekomendasi berbasis Machine Learning Decision Tree.</p>
        </div>
    </div>

</body>

</html>
