<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekomendasi Pendidikan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Temukan pendidikan yang tepat sesuai minat dan kebutuhan Anda.
                </div>
            </div>
        </div>
    </div>
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:flex md:flex-row md:space-x-8">
                    <!-- Form -->
                    <form class="space-y-6 w-full md:w-1/2" id="pendidikanForm" method="POST">
                        <div>
                            <label for="field_of_study" class="block text-gray-900">Interested Field of Study</label>
                            <input type="text" name="field_of_study" id="field_of_study" autocomplete="off" required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your field of study interest here">
                        </div>
                        <div>
                            <label for="education_level" class="block text-gray-900">Academic Background / Highest Education Level</label>
                            <input type="text" name="education_level" id="education_level" autocomplete="off" required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your highest education level here">
                        </div>
                        <div>
                            <label for="skills" class="block text-gray-900">Skills / Competencies</label>
                            <input type="text" name="skills" id="skills" autocomplete="off" required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your skills here">
                        </div>
                        <div>
                            <label for="career_goals" class="block text-gray-900">Career Goals / Desired Job Sector</label>
                            <input type="text" name="career_goals" id="career_goals" autocomplete="off" required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your career goals here">
                        </div>
                        <div>
                            <label for="location_preference" class="block text-gray-900">Location Preference</label>
                            <input type="text" name="location_preference" id="location_preference" autocomplete="off" required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your preferred location here">
                        </div>
                        <div>
                            <label for="learning_style" class="block text-gray-900">Preferred Learning Style / Mode</label>
                            <select name="learning_style" id="learning_style" required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select learning style</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit"
                                class="text-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Search
                            </button>
                        </div>
                    </form>

                    <!-- Result Container -->
                    <div id="result-container" class="mt-10 md:mt-0 md:w-1/2 flex flex-col justify-start items-start">
                        <!-- Results will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.querySelector('#pendidikanForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const field_of_study = document.querySelector('#field_of_study').value.trim();
        const education_level = document.querySelector('#education_level').value.trim();
        const skills = document.querySelector('#skills').value.trim();
        const career_goals = document.querySelector('#career_goals').value.trim();
        const location_preference = document.querySelector('#location_preference').value.trim();
        const learning_style = document.querySelector('#learning_style').value;

        const resultContainer = document.getElementById('result-container');
        resultContainer.innerHTML = '';

        if (!field_of_study || !education_level || !skills || !career_goals || !location_preference || !learning_style) {
            alert('Please fill in all fields.');
            return;
        }

        try {
            const response = await fetch('http://127.0.0.1:5003/education-predict', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    field_of_study,
                    education_level,
                    skills,
                    career_goals,
                    location_preference,
                    learning_style
                }),
            });

            if (!response.ok) {
                throw new Error(`Server error: ${response.status}`);
            }

            const result = await response.json();

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

            let universityListHTML = '';
            if (result.top_universities && result.top_universities.length > 0) {
                universityListHTML = '<h3 class="text-xl font-semibold mb-2">Top Universities:</h3><ul class="list-disc list-inside mb-4">';
                result.top_universities.forEach(univ => {
                    universityListHTML += `<li>${univ.university_name} (Ranking: ${univ.ranking})</li>`;
                });
                universityListHTML += '</ul>';
            }

            resultCard.innerHTML = `
                <h2 class="text-2xl font-bold mb-4">Education Recommendation</h2>
                <p class="text-lg mb-6">${result.recommendation}</p>
                ${universityListHTML}
            `;

            resultContainer.appendChild(resultCard);

        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while contacting the server: ' + error.message);
        }
    });
</script>
