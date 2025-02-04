<div>
    <div class="mb-4">
        <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input wire:model.live="search"
                type="search" id="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar" required />
            <button type="button" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buscar</button>
        </div>
    </div>
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

        {{-- wire:loading --}}
        <div wire:loading class="absolute inset-0 bg-white bg-opacity-70 dark:bg-gray-800 dark:bg-opacity-60">
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-500 animate-spin" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="my-8">
        {{ $quotes->links() }}
    </div>
</div>
