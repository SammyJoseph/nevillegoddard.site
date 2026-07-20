<form action="{{ $action }}" method="POST">
    @csrf
    @if(isset($method) && $method === 'PUT')
        @method('PUT')
    @endif
    
    <div class="grid grid-cols-6 gap-4 md:gap-6 mb-6">
        <div class="relative col-span-6 md:col-span-5 order-1">
            <textarea
            name="quote" required rows="4" placeholder="Escribir frase..."
            class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm
                    border border-slate-200 rounded-md px-3 py-2
                    focus:outline-none focus:border-slate-400 hover:border-slate-300
                    shadow-sm focus:shadow
                    field-sizing-content resize-none"            
            >{{ $quote->quote ?? old('quote') }}</textarea>
        </div>
        <div class="relative col-span-3 md:col-span-1 flex justify-end items-center order-3 md:order-2">
            <span class="text-xs font-medium text-gray-400 dark:text-gray-300 absolute -top-2 md:-top-4 right-0">Activo</span>
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="status" value="1" class="sr-only peer" {{ (isset($quote) && $quote->status) || (!isset($quote) && old('status', true)) ? 'checked' : '' }}>
                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
            </label>
        </div>
        <div class="relative col-span-3 md:col-span-2 order-2 md:order-3">
            <input name="bible_verse" type="text"
                class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                placeholder="Juan 1:1" value="{{ $quote->bible_verse ?? old('bible_verse') }}">
        </div>
        <div class="col-span-6 md:col-span-4 grid grid-cols-2 gap-3 md:gap-6 order-4">
            <div class="relative">
                <select name="source_type_id" required
                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer">
                    <option value="" disabled hidden>Tipo de Fuente</option>
                    @foreach ($source_types as $source_type)
                        <option value="{{ $source_type->id }}" {{ (isset($quote) && $quote->source->source_type_id == $source_type->id) || (!isset($quote) && $source_type->id == 2) || old('source_type_id') == $source_type->id ? 'selected' : '' }}>{{ $source_type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative">
                @livewire('source-autocomplete', ['curSource' => $quote->source->name ?? old('source_id')])
            </div>
        </div>
    </div>
    <div class="float-end flex items-center gap-3">
        @if(isset($method) && $method === 'PUT')
            <div x-data="{ showDeleteModal: false }">
                <button type="button" @click="showDeleteModal = true"
                    class="flex items-center rounded-md bg-red-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-sm hover:shadow-lg focus:bg-red-700 focus:shadow-none active:bg-red-700 hover:bg-red-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                    Eliminar
                </button>

                <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
                        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showDeleteModal = false" aria-hidden="true"></div>

                        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

                        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Eliminar frase</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">¿Estás seguro de que deseas eliminar esta frase? Esta acción no se puede deshacer.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <form action="{{ route('quotes.destroy', $quote) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                                        Eliminar
                                    </button>
                                </form>
                                <button type="button" @click="showDeleteModal = false"
                                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <button type="submit"
            class="flex items-center rounded-md bg-slate-800 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-sm hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
            <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M840-680v480q0 33-23.5 56.5T760-120H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h480l160 160ZM480-240q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM240-560h360v-160H240v160Z"/></svg>
            {{ $buttonText }}
        </button>
    </div>
</form>