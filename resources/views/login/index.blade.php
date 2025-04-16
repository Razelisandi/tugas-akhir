<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/RL 1080x1080.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>Login</title>
</head>

<body>
    <div class="relative flex items-center justify-center min-h-screen bg-gray-100 px-6 py-12">
        <x-background />

        <div class="z-10 w-full max-w-sm">
            <div class="text-center">
                <img class="mx-auto h-10 w-auto" src="{{ asset('images/RL 1080x1080.png') }}" alt="Your Company">
                <h2 class="mt-10 text-2xl font-bold tracking-tight text-white">Sign in to your account</h2>
            </div>

            <form class="mt-10 space-y-6" action="#" method="POST">
                <div>
                    <label for="email" class="block text-sm font-medium text-white">Email address</label>
                    <input type="email" name="email" id="email" autocomplete="email" required
                        class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-white">Password</label>
                        <a href="#" class="text-sm font-semibold text-blue-300 hover:text-blue-400">Forgot password?</a>
                    </div>
                    <input type="password" name="password" id="password" autocomplete="current-password" required
                        class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500  focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign in
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-white">
                Not a member?
                <a href="#" class="font-semibold text-blue-300 hover:text-blue-400">Register</a>
            </p>
        </div>
    </div>


</body>

</html>
