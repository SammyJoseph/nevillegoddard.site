<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Frases') }}
        </h2>
    </x-slot>

    <div class="sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl dark:shadow-gray-900/50 sm:rounded-lg px-4 py-0 md:p-8">
                @livewire('quotes-table')
            </div>
        </div>
    </div>

</x-app-layout>