<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekomendasi Karier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Bingung pilih karier? Tenang, kami bantu!
                </div>
            </div>
        </div>
    </div>
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:flex md:flex-row md:space-x-8">
                    <!-- Form -->
                    <form class="space-y-6 w-full md:w-1/2" id="karierForm" method="POST">
                        <div>
                            <label for="minat" class="block text-gray-900">Interested Sector of Job</label>
                            <p id="hint-minat" class="mt-1 text-xs text-red-600 hidden">Please answer in English.</p>
                            <input type="text" name="minat" id="minat" autocomplete="off" required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your sector of job interest here">
                        </div>
                        <div>
                            <label for="kemampuan" class="block text-gray-900">Skills</label>
                            <p id="hint-kemampuan" class="mt-1 text-xs text-red-600 hidden">Please answer in English.
                            </p>
                            <input type="text" name="kemampuan" id="kemampuan" autocomplete="off" required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your skills here">
                        </div>
                        <div>
                            <button type="submit"
                                class="text-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Search
                            </button>
                        </div>
                    </form>

                    <div id="result-container" class="mt-10 md:mt-0 md:w-1/2 flex flex-col justify-start items-start">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .fade-slide-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .fade-slide-in.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>


<script>
    const inputMinat = document.getElementById('minat');
    const hintMinat = document.getElementById('hint-minat');
    inputMinat.addEventListener('focus', () => {
        hintMinat.classList.remove('hidden');
    });
    inputMinat.addEventListener('blur', () => {
        hintMinat.classList.add('hidden');
    });

    const inputKemampuan = document.getElementById('kemampuan');
    const hintKemampuan = document.getElementById('hint-kemampuan');
    inputKemampuan.addEventListener('focus', () => {
        hintKemampuan.classList.remove('hidden');
    });
    inputKemampuan.addEventListener('blur', () => {
        hintKemampuan.classList.add('hidden');
    });

    document.querySelector('#karierForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const minat = document.querySelector('#minat').value;
        const kemampuan = document.querySelector('#kemampuan').value;
        const resultContainer = document.getElementById('result-container');
        resultContainer.innerHTML = '';

        try {
            const response = await fetch('http://127.0.0.1:5001/predict', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    minat,
                    kemampuan
                }),
            });
            const result = await response.json();

            const appId = 'e5ba88ba';
            const appKey = '552e8ae1ac56353814c7f5ba74d4dba6';
            const keyword = result.rekomendasi;

            const jobsRes = await fetch(
                `https://api.adzuna.com/v1/api/jobs/gb/search/1?app_id=${appId}&app_key=${appKey}&results_per_page=5&what=${keyword}&content-type=application/json`
            );
            const jobsData = await jobsRes.json();

            const resultCard = document.createElement('div');
            resultCard.classList.add(
                'bg-white',
                'text-gray-900',
                'dark:bg-gray-800',
                'dark:text-white',
                'p-6',
                'rounded-xl',
                'shadow-xl',
                'w-full'
            );

            let jobsListHTML = '';
            if (jobsData.results && jobsData.results.length > 0) {
                jobsListHTML = jobsData.results.map(job => `
                        <li class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md">
                            <h4 class="text-lg font-semibold">${job.title}</h4>
                            <p class="text-sm">${job.company.display_name} - ${job.location.display_name}</p>
                            <a href="${job.redirect_url}" class="text-indigo-600 dark:text-indigo-300 underline" target="_blank">More Detail</a>
                        </li>
                    `).join('');
            } else {
                jobsListHTML =
                    `<p class="text-gray-400">Maaf, tidak ditemukan lowongan kerja yang cocok.</p>`;
            }

            resultCard.innerHTML = `
                    <h2 class="text-2xl font-bold mb-4">Career Recommendation</h2>
                    <p class="text-lg mb-6">${result.rekomendasi}</p>
                    <h3 class="text-xl font-semibold mb-2">Available Job:</h3>
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
