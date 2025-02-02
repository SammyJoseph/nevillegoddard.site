<form action="{{ $action }}" method="POST">
    @csrf
    @if(isset($method) && $method === 'PUT')
        @method('PUT')
    @endif
    
    <div class="grid grid-cols-6 gap-3 md:gap-6 mb-6">
        <div class="relative col-span-5">
            <input name="quote" type="text" required class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="Escribir frase..." value="{{ $quote->quote ?? old('quote') }}">
        </div>
        <div class="relative col-span-1 flex justify-end items-center">
            <span class="text-xs font-medium text-gray-400 dark:text-gray-300 absolute -top-4 right-0">Activo</span>
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="status" value="1" class="sr-only peer" {{ (isset($quote) && $quote->status) || old('status', true) ? 'checked' : '' }}>
                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
            </label>
        </div>
        <div class="relative col-span-3 md:col-span-2">
            <input name="bible_verse" type="text"
                class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                placeholder="Juan 1:1" value="{{ $quote->bible_verse ?? old('bible_verse') }}">
        </div>
        <div class="col-span-6 md:col-span-4 grid grid-cols-2 gap-3 md:gap-6">
            <div class="relative">
                <select name="source_type_id" required
                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer">
                    <option value="" disabled hidden>Tipo de Fuente</option>
                    @foreach ($source_types as $source_type)
                        <option value="{{ $source_type->id }}" {{ (isset($quote) && $quote->source_type_id == $source_type->id) || (!isset($quote) && $source_type->id == 2) || old('source_type_id') == $source_type->id ? 'selected' : '' }}>{{ $source_type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative">
                @livewire('source-autocomplete', ['selectedSourceId' => $quote->source_id ?? old('source_id')])
            </div>
        </div>
    </div>
    <div class="float-end">
        <button type="submit"
            class="flex items-center rounded-md bg-slate-800 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-sm hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
            <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M840-680v480q0 33-23.5 56.5T760-120H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h480l160 160ZM480-240q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM240-560h360v-160H240v160Z"/></svg>
            {{ $buttonText }}
        </button>
    </div>
</form>