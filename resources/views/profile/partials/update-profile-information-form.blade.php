<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div x-data="{ showPreview: false }" x-init="showPreview = false">
            <x-input-label for="profile_photo" :value="__('Profile Photo')" />

            @if ($user->profile_photo)
                <img @click="showPreview = true" src="{{ Storage::url('profile_photos/' . $user->profile_photo) }}"
                    alt="Profile Photo"
                    class="mt-2 w-24 h-24 object-cover rounded-full border cursor-pointer hover:opacity-80 transition" />
            @endif

            <label for="profile_photo"
                class="mt-2 inline-block px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md cursor-pointer hover:bg-indigo-700 transition">
                {{ $user->profile_photo ? 'Ganti Foto' : 'Upload Foto' }}
            </label>

            <input id="profile_photo" name="profile_photo" type="file" accept="image/*" class="hidden" />

            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />

            <!-- Modal Preview -->
            <div x-show="showPreview" x-cloak x-transition
                class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">

                <div class="relative">
                    <button @click="showPreview = false"
                        class="absolute top-2 right-2 text-white bg-black bg-opacity-60 rounded-full p-1 hover:bg-opacity-90 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <img src="{{ Storage::url('profile_photos/' . $user->profile_photo) }}" alt="Preview"
                        class="max-w-full max-h-[80vh] rounded-lg shadow-lg border-4 border-white" />

                    {{-- <div class="flex justify-center mt-4">
                        <label for="profile_photo"
                            class="inline-block px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md cursor-pointer hover:bg-indigo-700 transition">
                            Ganti Foto
                        </label>
                    </div> --}}
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<style>
    [x-cloak] { display: none !important; }
</style>
