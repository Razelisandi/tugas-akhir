<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/RL 1080x1080.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>Pendidikan</title>
</head>
<body>
    <x-navbar />
    <x-background />

    <div class="relative z-10 flex flex-col mt-40 -h-screen text-white px-4 max-w-310 mx-auto ">
        <h1 class="text-3xl md:text-5xl font-bold mb-4 drop-shadow-lg">Sistem Rekomendasi Pendidikan</h1>
        <p class="text-lg md:text-xl max-w-2xl drop-shadow-md">
            Mau kuliah dimana ni?
            <br>
            Yuk, kita cari yang sesuai!
        </p>

        <form class="mt-10 space-y-6 w-110" action="#" method="POST">
            <div>
                <label for="minat" class="block text-sm font-medium text-white">Minat</label>
                <input type="text" name="minat" id="minat" autocomplete="minat" required
                    class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="kemampuan" class="block text-sm font-medium text-white">Kemampuan</label>
                </div>
                <input type="text" name="kemampuan" id="kemampuan" autocomplete="current-password" required
                    class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
            </div>

            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500  focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Cari yang cocok
                </button>
            </div>
        </form>
    </div>
</body>
</html>
