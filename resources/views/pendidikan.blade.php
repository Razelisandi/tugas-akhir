<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Education Recommendation') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Temukan pendidikan yang tepat sesuai minat dan kebutuhan Anda.
                </div>
            </div>
        </div>
    </div> --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-xl pb-0">Try Education Recommender</div>
                <div class="p-6 md:flex md:flex-row md:space-x-8">
                    <!-- Form -->
                    <form class="space-y-6 w-full md:w-1/2" id="pendidikanForm" method="POST">
                        <div>
                            <label for="field_of_study" class="block text-gray-900">Interested Field of Study</label>
                            <p id="hint-field-of-study" class="mt-1 text-xs text-red-600 hidden">Please answer in
                                English.</p>
                            <input type="text" name="field_of_study" id="field_of_study" autocomplete="off" required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your field of study interest here">
                        </div>
                        <div>
                            <label for="education_level" class="block text-gray-900">Academic Background / Highest
                                Education Level</label>
                            <p id="hint-education-level" class="mt-1 text-xs text-red-600 hidden">Please answer in
                                English.</p>
                            <input type="text" name="education_level" id="education_level" autocomplete="off"
                                required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your highest education level here">
                        </div>
                        <div>
                            <label for="skills" class="block text-gray-900">Skills / Competencies</label>
                            <p id="hint-skills" class="mt-1 text-xs text-red-600 hidden">Please answer in
                                English.</p>
                            <input type="text" name="skills" id="skills" autocomplete="off" required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your skills here">
                        </div>
                        <div>
                            <label for="career_goals" class="block text-gray-900">Career Goals / Desired Job
                                Sector</label>
                            <p id="hint-career-goals" class="mt-1 text-xs text-red-600 hidden">Please answer in
                                English.</p>
                            <input type="text" name="career_goals" id="career_goals" autocomplete="off" required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your career goals here">
                        </div>
                        <div>
                            <label for="location_preference" class="block text-gray-900">Location Preference</label>
                            <p id="hint-location-preference" class="mt-1 text-xs text-red-600 hidden">Please answer in
                                English.</p>
                            <input type="text" name="location_preference" id="location_preference" autocomplete="off"
                                required
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter your preferred location here">
                        </div>
                        <div>
                            <label for="learning_style" class="block text-gray-900">Preferred Learning Style /
                                Mode</label>
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
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:flex md:flex-row md:space-x-8">
                    <div class="w-full">
                        <h3 class="text-xl font-semibold mb-4">History</h3>
                        <table id="search-history"
                            class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-md">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Field of Study</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Education Level</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Skills</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Career Goals</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Location</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Style</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Recommendation</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Rows will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer />
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
    const inputStudy = document.getElementById('field_of_study');
    const hintStudy = document.getElementById('hint-field-of-study');
    inputStudy.addEventListener('focus', () => {
        hintStudy.classList.remove('hidden');
    });
    inputStudy.addEventListener('blur', () => {
        hintStudy.classList.add('hidden');
    });

    const inputLevel = document.getElementById('education_level');
    const hintLevel = document.getElementById('hint-education-level');
    inputLevel.addEventListener('focus', () => {
        hintLevel.classList.remove('hidden');
    });
    inputLevel.addEventListener('blur', () => {
        hintLevel.classList.add('hidden');
    });

    const inputSkill = document.getElementById('skills');
    const hintSkill = document.getElementById('hint-skills');
    inputSkill.addEventListener('focus', () => {
        hintSkill.classList.remove('hidden');
    });
    inputSkill.addEventListener('blur', () => {
        hintSkill.classList.add('hidden');
    });

    const inputGoal = document.getElementById('career_goals');
    const hintGoal = document.getElementById('hint-career-goals');
    inputGoal.addEventListener('focus', () => {
        hintGoal.classList.remove('hidden');
    });
    inputGoal.addEventListener('blur', () => {
        hintGoal.classList.add('hidden');
    });

    const inputLocation = document.getElementById('location_preference');
    const hintLocation = document.getElementById('hint-location-preference');
    inputLocation.addEventListener('focus', () => {
        hintLocation.classList.remove('hidden');
    });
    inputLocation.addEventListener('blur', () => {
        hintLocation.classList.add('hidden');
    });

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

        if (!field_of_study || !education_level || !skills || !career_goals || !location_preference || !
            learning_style) {
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
                universityListHTML =
                    '<h3 class="text-xl font-semibold mb-2">Top Universities:</h3><ul class="list-disc list-inside mb-4">';
                result.top_universities.forEach(univ => {
                    universityListHTML +=
                        `<li>${univ.university_name} (Ranking: ${univ.ranking})</li>`;
                });
                universityListHTML += '</ul>';
            }

            resultCard.innerHTML = `
                <h2 class="text-2xl font-bold mb-4">Education Recommendation</h2>
                <p class="text-lg mb-6">${result.recommendation}</p>
                ${universityListHTML}
                <button id="save-btn" class="mt-4 px-4 py-2 bg-green-600 text-white rounded">Save</button>
            `;

            resultContainer.appendChild(resultCard);

            document.getElementById('save-btn').addEventListener('click', () => saveSearch(result
                .recommendation, result.top_universities));

        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while contacting the server: ' + error.message);
        }
    });

    async function saveSearch(recommendation, top_universities) {
        const field_of_study = document.getElementById('field_of_study').value;
        const education_level = document.getElementById('education_level').value;
        const skills = document.getElementById('skills').value;
        const career_goals = document.getElementById('career_goals').value;
        const location_preference = document.getElementById('location_preference').value;
        const learning_style = document.getElementById('learning_style').value;

        try {
            const response = await fetch('/pendidikan/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    field_of_study,
                    education_level,
                    skills,
                    career_goals,
                    location_preference,
                    learning_style,
                    recommendation,
                    top_universities
                }),
            });
            if (!response.ok) throw new Error('Failed to save search');
            alert('Search saved successfully!');
            fetchSearchHistory();
        } catch (error) {
            console.error('Error saving search:', error);
            alert('Failed to save search. Please make sure you are logged in.');
        }
    }

    async function fetchSearchHistory() {
        try {
            const response = await fetch('/pendidikan/history');
            if (!response.ok) throw new Error('Failed to fetch history');
            const data = await response.json();
            const historyTableBody = document.querySelector('#search-history tbody');
            historyTableBody.innerHTML = '';
            data.data.forEach(item => {
                const tr = document.createElement('tr');
                tr.classList.add('hover:bg-gray-100');
                tr.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.field_of_study}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.education_level}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.skills}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.career_goals}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.location_preference}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.learning_style}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.recommendation}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <button class="px-3 py-1 bg-indigo-600 text-white rounded" onclick='loadHistory(${JSON.stringify(item)})'>Load</button>
                    <button class="ml-2 px-3 py-1 bg-red-600 text-white rounded" onclick='deleteSearch(${item.id})'>Delete</button>
                </td>
            `;
                historyTableBody.appendChild(tr);
            });
        } catch (error) {
            console.error('Error fetching history:', error);
        }
    }

    function loadHistory(item) {
        document.getElementById('field_of_study').value = item.field_of_study;
        document.getElementById('education_level').value = item.education_level;
        document.getElementById('skills').value = item.skills;
        document.getElementById('career_goals').value = item.career_goals;
        document.getElementById('location_preference').value = item.location_preference;
        document.getElementById('learning_style').value = item.learning_style;

        const resultContainer = document.getElementById('result-container');
        resultContainer.innerHTML = '';

        let universityListHTML = '';
        if (item.top_universities && item.top_universities.length > 0) {
            universityListHTML =
                '<h3 class="text-xl font-semibold mb-2">Top Universities:</h3><ul class="list-disc list-inside mb-4">';
            item.top_universities.forEach(univ => {
                universityListHTML += `<li>${univ.university_name} (Ranking: ${univ.ranking})</li>`;
            });
            universityListHTML += '</ul>';
        }

        const resultCard = document.createElement('div');
        resultCard.classList.add(
            'bg-white', 'text-gray-900', 'dark:bg-gray-800', 'dark:text-white',
            'p-6', 'rounded-xl', 'shadow-xl', 'w-full'
        );

        resultCard.innerHTML = `
        <h2 class="text-2xl font-bold mb-4">Education Recommendation</h2>
        <p class="text-lg mb-6">${item.recommendation}</p>
        ${universityListHTML}
    `;

        resultContainer.appendChild(resultCard);
    }


    async function deleteSearch(id) {
        if (!confirm('Are you sure you want to delete this search?')) return;

        try {
            const response = await fetch(`/pendidikan/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            if (!response.ok) throw new Error('Failed to delete search');
            alert('Search deleted successfully!');
            fetchSearchHistory();
        } catch (error) {
            console.error('Error deleting search:', error);
            alert('Failed to delete search.');
        }
    }

    // Fetch search history on page load
    fetchSearchHistory();
</script>
