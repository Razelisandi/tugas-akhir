<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Chatbot</title>
</head>

<body class="bg-gray-100 h-screen w-screen overflow-hidden">
    <x-navbar />
    <x-background />

    <div class="relative flex flex-col h-full xl:mx-70 p-0">
        <!-- Chat Area -->
        <main class="flex-1 overflow-y-auto mx-20 mt-20 rounded-2xl p-6 space-y-4 bg-white">
            <!-- User message -->
            <div class="flex justify-end">
                <div class="bg-indigo-500 text-white px-4 py-2 rounded-lg max-w-2xl text-sm">
                    Hai Bot, apa kabar?
                </div>
            </div>

            <!-- Bot message -->
            <div class="flex justify-start">
                <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg max-w-2xl text-sm">
                    Halo, Zel! Aku baik. Ada yang bisa aku bantu hari ini?
                </div>
            </div>
        </main>

        <!-- Input -->
        <form class="flex gap-2 p-4 bg-white mx-20 rounded-2xl my-10">
            <input type="text" placeholder="Tulis pesan..."
                class="flex-1 px-4 py-2 rounded-lg border border-gray-300 outline-none focus:ring-2 focus:ring-indigo-500 text-sm" />
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                Kirim
            </button>
        </form>

    </div>
</body>



</html>
