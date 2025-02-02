<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Frases') }}
        </h2>
    </x-slot>

    <div class="sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 md:p-12">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Frase
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Versículo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tipo de fuente
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Fuente
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotes as $quote)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $quote->id }}
                                </th>
                                <td class="px-6 py-4 min-w-[300px] flex items-center space-x-1">
                                    {{-- <svg class="{{ $quote->status ? 'text-green-400' : 'text-gray-300' }} w-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M480-200q-117 0-198.5-81.5T200-480q0-117 81.5-198.5T480-760q117 0 198.5 81.5T760-480q0 117-81.5 198.5T480-200Z"/></svg> --}}
                                    <p class="{{ $quote->status ? '' : 'text-gray-300' }}">{{ $quote->quote }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $quote->bible_verse }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $quote->source->sourceType->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $quote->source->name }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('quotes.edit', $quote) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-8">
                    {{ $quotes->links() }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
