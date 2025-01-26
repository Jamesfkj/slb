<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informations sur mon profile') }}
        </h2>
        
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Modifier les informations de votre compte.") }}
        </p>
    </header>
    @if (session('success'))
                <div class="alert alert-success custom-alert" id="success-message">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nom et prenoms')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />

        </div>
        <div>
            <x-input-label for="phone" :value="__('Téléphone')" />
            <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full" :value="old('telephone', $user->telephone)" required autocomplete="username" />

        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enrégistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
