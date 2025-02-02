<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Frase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 md:p-12">
                @include('components.quote-form', [
                    'action' => route('quotes.store'),
                    'buttonText' => 'Guardar',
                ])
            </div>
        </div>
    </div>
</x-app-layout>
