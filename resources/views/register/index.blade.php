<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/RL 1080x1080.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>Register</title>
</head>

<body>
    <div class="relative flex items-center justify-center min-h-screen bg-gray-100 px-6 py-12">
        <x-background />

        <div class="z-10 w-full max-w-sm">
            <div class="text-center">
                <img class="mx-auto h-10 w-auto" src="{{ asset('images/RL 1080x1080.png') }}" alt="Your Company">
                <h2 class="mt-10 text-2xl font-bold tracking-tight text-white">Create Your Own Account</h2>
            </div>

            <form class="mt-10 space-y-6" action="#" method="POST">
                <div>
                    <label for="fullName" class="block text-sm font-medium text-white">Full Name</label>
                    <input type="text" name="fullName" id="fullName" required
                        class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-white">Email address</label>
                    <input type="email" name="email" id="email" autocomplete="email" required
                        class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-white">Password</label>
                    </div>
                    <input type="password" name="password" id="password" autocomplete="current-password" required
                        class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="confirmPassword" class="block text-sm font-medium text-white">Confirm
                            Password</label>
                    </div>
                    <input type="password" name="confirmPassword" id="confirmPassword" autocomplete="current-password"
                        required
                        class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="uploadCV" class="block text-sm font-medium text-white">Upload Your CV</label>
                    </div>
                    <input type="file" name="uploadCV" id="uploadCV"
                        class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500  focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign Up
                    </button>
                    <p class="mt-5 text-center text-sm text-white">
                        Not a member?
                        <a href="#" class="font-semibold text-blue-300 hover:text-blue-400">Register</a>
                    </p>
                    <p class="mt-5 text-center text-sm text-white">
                        Or
                    </p>
                </div>
            </form>

            <div class="mt-4">
                <a href="#"
                    class="flex items-center justify-center w-full px-4 py-2 text-sm font-semibold text-white bg-red-500 rounded-md hover:bg-red-600">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 533.5 544.3">
                        <path fill="#fff"
                            d="M533.5 278.4c0-17.7-1.6-35.1-4.8-52H272v98.5h146.9c-6.3 34.2-25.3 63.2-53.8 82.4v68h86.7c50.7-46.8 81.7-115.7 81.7-197z" />
                        <path fill="#fff"
                            d="M272 544.3c72.8 0 133.9-24.1 178.5-65.5l-86.7-68c-24.1 16.2-54.8 25.7-91.8 25.7-70.6 0-130.4-47.6-151.8-111.6h-90.2v69.8C80.5 486.4 169.6 544.3 272 544.3z" />
                        <path fill="#fff"
                            d="M120.2 324.9c-7.7-22.8-7.7-47.4 0-70.2v-69.8H30C10.8 220.7 0 245.3 0 272s10.8 51.3 30.2 86.9l90-69.8z" />
                        <path fill="#fff"
                            d="M272 107.6c39.6 0 75.3 13.6 103.2 40.5l77.4-77.4C407.1 24.1 345.9 0 272 0 169.6 0 80.5 57.9 30.2 145.1l90 69.8c21.4-64 81.2-111.6 151.8-111.6z" />
                    </svg>
                    Sign in with Google
                </a>
            </div>


        </div>
    </div>


</body>

</html>
