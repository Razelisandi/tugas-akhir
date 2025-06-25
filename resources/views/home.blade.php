<div class="z-10 relative">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Home') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
                <div
                    class="bg-gradient-to-r from-purple-900 via-indigo-900 to-blue-900 text-white rounded-2xl shadow-lg p-10">
                    <h1 class="text-4xl font-extrabold mb-6 tracking-wide">Welcome to Career and Education Recommendation
                        System</h1>
                    <p class="text-lg max-w-6xl mb-8 leading-relaxed">
                        Find the best career and education paths that match your interests, abilities, and goals with
                        advanced technology.
                    </p>
                    <div class="flex space-x-6">
                        <a href="{{ route('chatbot') }}"
                            class="px-8 py-3 bg-indigo-500 hover:bg-indigo-600 rounded-full font-semibold shadow-lg transition duration-300">Chatbot</a>
                        <a href="{{ route('karier') }}"
                            class="px-8 py-3 bg-green-500 hover:bg-green-600 rounded-full font-semibold shadow-lg transition duration-300">
                            Career Recommendation</a>
                        <a href="{{ route('pendidikan') }}"
                            class="px-8 py-3 bg-blue-500 hover:bg-blue-600 rounded-full font-semibold shadow-lg transition duration-300">
                            Education Recommendation</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <section class="bg-gray-100 rounded-xl p-8 shadow-lg border border-gray-300">
                        <h2 class="text-3xl font-bold mb-4 text-gray-900">In-Depth Career Information</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            The career world is constantly evolving with various opportunities and challenges. Here is
                            in-depth information to help you plan your career better:
                        </p>
                        <ol class="list-decimal list-inside text-gray-700 space-y-3">
                            <li><strong>Career Development Stages:</strong> Starting from exploration, learning,
                                development, to reaching the peak of your career.</li>
                            <li><strong>Example Career Paths:</strong> Information Technology, Healthcare, Education,
                                Business, and Creative industries.</li>
                            <li><strong>Job Market Trends:</strong> Increasing demand for digital skills, data analysis,
                                and soft skills.</li>
                            <li><strong>Success Strategies:</strong> Networking, continuous learning, and adapting to
                                industry changes.</li>
                            <li><strong>The Role of Technology:</strong> Using AI and data to predict career
                                opportunities and market demands.</li>
                        </ol>
                        <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4 text-green-800">
                            <h3 class="text-xl font-semibold mb-2">Fun Career Tips</h3>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Explore various fields of work to discover your passion.</li>
                                <li>Continuously improve your skills through training and online courses.</li>
                                <li>Build a professional network to open up new opportunities.</li>
                                <li>Use technology and data to make informed career decisions.</li>
                            </ul>
                        </div>
                    </section>

                    <section class="bg-gray-100 rounded-xl p-8 shadow-lg border border-gray-300">
                        <h2 class="text-3xl font-bold mb-4 text-gray-900">In-Depth Education Information</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Education is the key to unlocking future opportunities. Here is in-depth information and
                            important tips related to education:
                        </p>
                        <ol class="list-decimal list-inside text-gray-700 space-y-3">
                            <li><strong>Types of Education:</strong> Formal, non-formal, and informal, and their
                                respective roles in personal development.</li>
                            <li><strong>Study Programs:</strong> Study program choices that align with your interests
                                and career goals.</li>
                            <li><strong>Learning Methods:</strong> Online, offline, hybrid, and how to choose the best
                                one for you.</li>
                            <li><strong>Benefits of Higher Education:</strong> Better job opportunities, skill
                                development, and professional networking.</li>
                            <li><strong>The Role of Certification:</strong> Enhancing credibility and competitiveness in
                                the job market.</li>
                        </ol>
                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-blue-800">
                            <h3 class="text-xl font-semibold mb-2">Fun Education Tips</h3>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Utilize online learning resources to broaden your knowledge.</li>
                                <li>Participate in extracurricular activities to develop soft skills.</li>
                                <li>Plan your educational path according to your career goals.</li>
                                <li>Don’t hesitate to ask questions and discuss with mentors or lecturers.</li>
                            </ul>
                        </div>
                    </section>
                </div>

                <div
                    class="bg-white bg-opacity-20 backdrop-blur-md rounded-xl p-8 shadow-lg border border-white border-opacity-10 text-center">
                    <h2 class="text-3xl font-bold mb-4 text-gray-900">Start Planning Your Future</h2>
                    <p class="text-gray-700 text-opacity-90 mb-6 max-w-xl mx-auto">
                        Explore our recommendation features and make informed decisions for your career and education.
                    </p>
                    <div class="space-x-6">
                        <a href="{{ route('karier') }}"
                            class="inline-block px-8 py-3 bg-green-500 hover:bg-green-600 rounded-full font-semibold shadow-lg transition duration-300">
                            Start Career Recommendation</a>
                        <a href="{{ route('pendidikan') }}"
                            class="inline-block px-8 py-3 bg-blue-500 hover:bg-blue-600 rounded-full font-semibold shadow-lg transition duration-300">
                            Start Education Recommendation</a>
                    </div>
                </div>
            </div>
        </div>
</div>
<x-footer />
</x-app-layout>
</div>

<x-background />
