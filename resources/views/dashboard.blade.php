<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SISTEMA DE AUTOMATIZACIÓN EN EL MUESTREO DE PH') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            @if(request()->routeIs('dashboard'))
                <livewire:dashboard />
            @elseif(request()->routeIs('piscinas'))
                <livewire:piscinas />
            @elseif(request()->routeIs('lecturas'))
                <livewire:lecturas />
            @endif
            </div>
        </div>
    </div>
</x-app-layout>
