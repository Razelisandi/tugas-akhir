<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/RL 1080x1080.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>Chatbot</title>
</head>

<body class="bg-gray-100 h-screen w-screen overflow-hidden">
    <x-navbar />
    <x-background />

    <div class="relative flex flex-col h-full xl:mx-70 p-0">
        <!-- Chat Area -->
        <main id="chat-main" class="flex-1 overflow-y-auto mx-20 mt-20 rounded-2xl p-6 space-y-4 bg-white">
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
        <form id="chat-form" class="flex gap-2 p-4 bg-white mx-20 rounded-2xl my-10">
            <input id="message" type="text" placeholder="Tulis pesan..."
                class="flex-1 px-4 py-2 rounded-lg border border-gray-300 outline-none focus:ring-2 focus:ring-indigo-500 text-sm" />
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                Kirim
            </button>
        </form>
    </div>

    <script>
        document.getElementById("chat-form").addEventListener("submit", async function(e) {
            e.preventDefault();

            const messageInput = document.getElementById("message");
            const userMessage = messageInput.value;

            if (!userMessage) return;

            const main = document.getElementById("chat-main");
            const userBubble = `<div class="flex justify-end">
                                <div class="bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm break-words whitespace-pre-wrap max-w-full sm:max-w-2xl overflow-hidden">${userMessage}</div>
                            </div>`;
            main.innerHTML += userBubble;

            try {
                // Kirim pesan ke Flask chatbot
                const res = await fetch("http://127.0.0.1:5000/chat", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        message: userMessage
                    })
                });

                if (!res.ok) {
                    throw new Error("Gagal mengambil response dari chatbot");
                }

                const data = await res.json();
                const botResponse = data.response;

                // Tampilkan response dari chatbot
                const botBubble = `<div class="flex justify-start">
                                    <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm break-words whitespace-pre-wrap max-w-full sm:max-w-2xl overflow-hidden">${botResponse}</div>
                                </div>`;
                main.innerHTML += botBubble;

                // Jika bot memberikan respons terkait beasiswa, panggil API beasiswa
                if (botResponse.includes("informasi beasiswa")) {
                    const beasiswaRes = await fetch("http://127.0.0.1:5000/beasiswa");
                    const beasiswaData = await beasiswaRes.json();
                    const beasiswaMessage = beasiswaData.beasiswa ? beasiswaData.beasiswa : "Tidak ada informasi beasiswa terbaru.";

                    const beasiswaBubble = `<div class="flex justify-start">
                                             <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm break-words whitespace-pre-wrap max-w-full sm:max-w-2xl overflow-hidden">${beasiswaMessage}</div>
                                         </div>`;
                    main.innerHTML += beasiswaBubble;
                }

            } catch (error) {
                console.error("Terjadi kesalahan:", error);
                main.innerHTML += `<div class="flex justify-start">
                                    <div class="bg-red-200 text-red-800 px-4 py-2 rounded-lg max-w-2xl text-sm">Oops, chatbot tidak merespons.</div>
                                </div>`;
            }

            messageInput.value = "";

            // Scroll otomatis ke bawah
            main.scrollTop = main.scrollHeight;
        });
    </script>
</body>

</html>
