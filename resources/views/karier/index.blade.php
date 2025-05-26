<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/RL 1080x1080.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>Karier</title>
</head>

<body>
    <x-navbar />
    <x-background />

    <div class="relative z-10 flex flex-col md:flex-row mt-40 text-white px-4 max-w-7xl mx-auto">
        <!-- Kolom kiri untuk form -->
        <div class="flex flex-col w-full md:w-1/2">
            <h1 class="text-3xl md:text-5xl font-bold mb-4 drop-shadow-lg">Sistem Rekomendasi Karier</h1>
            <p class="text-lg md:text-xl max-w-2xl drop-shadow-md">
                Bingung pilih karier? Tenang, kami bantu!
                <br>
                Rekomendasi pintar sesuai minat dan potensimu.
            </p>

            <form class="mt-10 space-y-6 w-full max-w-md" id="karierForm" method="POST">
                @csrf
                <div>
                    <label for="minat" class="block text-sm font-medium text-white">Bidang Yang Diminati</label>
                    <input type="text" name="minat" id="minat" autocomplete="off" required
                        class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                </div>

                <div>
                    <label for="kemampuan" class="block text-sm font-medium text-white">Kemampuan Yang Dikuasai</label>
                    <input type="text" name="kemampuan" id="kemampuan" autocomplete="off" required
                        class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Cari pilihan karier
                    </button>
                </div>
            </form>
        </div>

        <!-- Kolom kanan untuk hasil rekomendasi -->
        <div id="result-container" class="mt-10 md:mt-0 md:w-1/2 md:ml-8 flex flex-col justify-start items-start">
            <!-- Hasil akan ditampilkan di sini -->
        </div>
    </div>

    <script>
        document.querySelector('#karierForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const minat = document.querySelector('#minat').value;
            const kemampuan = document.querySelector('#kemampuan').value;
            const resultContainer = document.getElementById('result-container');
            resultContainer.innerHTML = '';

            try {
                const response = await fetch('http://127.0.0.1:5001/predict', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ minat, kemampuan }),
                });
                const result = await response.json();

                const appId = 'e5ba88ba';
                const appKey = '552e8ae1ac56353814c7f5ba74d4dba6';
                const keyword = result.rekomendasi;

                const jobsRes = await fetch(`https://api.adzuna.com/v1/api/jobs/gb/search/1?app_id=${appId}&app_key=${appKey}&results_per_page=5&what=${keyword}&content-type=application/json`);
                const jobsData = await jobsRes.json();

                const resultCard = document.createElement('div');
                resultCard.classList.add('bg-gray-800', 'text-white', 'p-6', 'rounded-xl', 'shadow-xl', 'w-full');

                let jobsListHTML = '';
                if (jobsData.results && jobsData.results.length > 0) {
                    jobsListHTML = jobsData.results.map(job => `
                        <li class="bg-gray-700 p-4 rounded-md">
                            <h4 class="text-lg font-semibold">${job.title}</h4>
                            <p class="text-sm">${job.company.display_name} - ${job.location.display_name}</p>
                            <a href="${job.redirect_url}" class="text-indigo-300 underline" target="_blank">Lihat Detail</a>
                        </li>
                    `).join('');
                } else {
                    jobsListHTML = `<p class="text-gray-400">Maaf, tidak ditemukan lowongan kerja yang cocok.</p>`;
                }

                resultCard.innerHTML = `
                    <h2 class="text-2xl font-bold mb-4">Rekomendasi Karier</h2>
                    <p class="text-lg mb-6">${result.rekomendasi}</p>
                    <h3 class="text-xl font-semibold mb-2">Lowongan Pekerjaan Terkait:</h3>
                    <ul class="space-y-4">
                        ${jobsListHTML}
                    </ul>
                `;

                resultContainer.appendChild(resultCard);

            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghubungi server.');
            }
        });
    </script>
</body>

</html>
