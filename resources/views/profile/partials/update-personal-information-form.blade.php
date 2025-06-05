<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Upload Your CV') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Upload your CV in PDF format. The AI will extract information automatically.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('cv.upload') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="cv_pdf" :value="__('Upload CV (PDF Only)')" />
            <input id="cv_pdf" name="cv_pdf" type="file" accept=".pdf"
                class="mt-2 block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700" />
            <x-input-error class="mt-2" :messages="$errors->get('cv_pdf')" />
        </div>

        @php
            $showFields = old('personal_name') || old('personal_last_education') || old('personal_organization_history') || old('personal_achievement_history') || session('manual_input', false);
        @endphp

        <div id="manual-input-fields" style="display: {{ $showFields ? 'block' : 'none' }};">
            <div>
            <x-input-label for="personal_name" :value="__('Name')" />
            <x-text-input id="personal_name" name="personal_name" type="text" class="mt-2 block w-full" :value="old('personal_name')" />
            <x-input-error class="mt-2" :messages="$errors->get('personal_name')" />
            </div>

            <div>
            <x-input-label for="personal_last_education" :value="__('Riwayat Pendidikan Terakhir')" />
            <x-text-input id="personal_last_education" name="personal_last_education" type="text" class="mt-2 block w-full" :value="old('personal_last_education')" />
            <x-input-error class="mt-2" :messages="$errors->get('personal_last_education')" />
            </div>

            <div>
            <x-input-label for="personal_organization_history" :value="__('Riwayat Organisasi')" />
            <x-text-input id="personal_organization_history" name="personal_organization_history" type="text" class="mt-2 block w-full" :value="old('personal_organization_history')" />
            <x-input-error class="mt-2" :messages="$errors->get('personal_organization_history')" />
            </div>

            <div>
            <x-input-label for="personal_achievement_history" :value="__('Riwayat Prestasi')" />
            <x-text-input id="personal_achievement_history" name="personal_achievement_history" type="text" class="mt-2 block w-full" :value="old('personal_achievement_history')" />
            <x-input-error class="mt-2" :messages="$errors->get('personal_achievement_history')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Upload CV') }}</x-primary-button>
            <a href="#" id="input-manually-btn" class="text-sm text-indigo-600 hover:underline">
                {{ __('Input Manually') }}
            </a>
        </div>
    </form>

    <script>
        document.getElementById('input-manually-btn').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('manual-input-fields').style.display = 'block';
        });
    </script>
</section>
