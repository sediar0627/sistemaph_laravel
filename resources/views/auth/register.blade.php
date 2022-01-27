<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <h1 class="font-medium">SISTEMA DE AUTOMATIZACIÓN EN EL MUESTREO DE PH</h1>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:ring-2 ring-offset-current ring-gray-500">
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <input id="email" type="email" name="email" :value="old('email')" required class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:ring-2 ring-offset-current ring-gray-500">
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <input id="password" type="password" name="password" required autocomplete="new-password" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:ring-2 ring-offset-current ring-gray-500">
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:ring-2 ring-offset-current ring-gray-500">
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Iniciar sesion') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Registrarte') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
