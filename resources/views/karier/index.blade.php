<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Karier</title>
</head>
<body>
    <x-navbar />
    <x-background />

    <div class="relative z-10 flex flex-col mt-40 -h-screen text-white px-4 max-w-310 mx-auto ">
        <h1 class="text-3xl md:text-5xl font-bold mb-4 drop-shadow-lg">Sistem Rekomendasi Karier</h1>
        <p class="text-lg md:text-xl max-w-2xl drop-shadow-md">
            Temukan arah karier dan pendidikan yang tepat melalui sistem rekomendasi berbasis Machine Learning Decision Tree.
        </p>
    </div>
</body>
</html>
