<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <h1 class="font-medium px-8 text-center">SISTEMA DE AUTOMATIZACIÓN EN EL MUESTREO DE PH</h1>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <div class="px-8">
            @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:ring-2 ring-offset-current ring-gray-500">
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <input id="password" id="email" type="password" name="password" required autocomplete="current-password" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:ring-2 ring-offset-current ring-gray-500">
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        {{ __('Registrate') }}
                    </a>
                    <x-jet-button class="ml-4">
                        {{ __('Iniciar sesion') }}
                    </x-jet-button>
                </div>
            </form>
        </div>

    </x-jet-authentication-card>
</x-guest-layout>
