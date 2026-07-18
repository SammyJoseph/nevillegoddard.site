<div class="py-6 md:py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Card -->
            <div class="lg:col-span-2 bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-8 md:p-10 border border-slate-100">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-slate-800 leading-tight">
                        {{ __('Cargar Archivo CSV') }}
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Sube un archivo CSV con las columnas <code class="bg-slate-100 px-1 py-0.5 rounded text-xs font-mono text-slate-800">quote</code> y <code class="bg-slate-100 px-1 py-0.5 rounded text-xs font-mono text-slate-800">bible_verse</code> para importar frases de forma masiva.
                    </p>
                </div>

                <form wire:submit.prevent="import" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <label for="source-type-select" class="block text-xs font-medium text-slate-500 mb-1.5 uppercase tracking-wider">
                                Tipo de Fuente <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select 
                                    id="source-type-select" 
                                    wire:model="sourceTypeId"
                                    required
                                    class="w-full bg-white placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md pl-3 pr-10 py-2.5 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow-md appearance-none cursor-pointer"
                                >
                                    <option value="" disabled hidden>Selecciona Tipo</option>
                                    @foreach ($source_types as $source_type)
                                        <option value="{{ $source_type->id }}">{{ $source_type->name }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('sourceTypeId') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative" x-data="{ open: false }">
                            <label for="source-name-input" class="block text-xs font-medium text-slate-500 mb-1.5 uppercase tracking-wider">
                                Fuente <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="source-name-input"
                                wire:model.live="sourceName" 
                                class="w-full bg-white placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2.5 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow-md" 
                                placeholder="Escribe el nombre de la obra (libro, conferencia...)"
                                x-on:focus="$wire.loadRecentSources(); open = true"
                                x-on:click.away="open = false"
                                autocomplete="off"
                            >
                            @if(!empty($sources))
                                <ul 
                                    class="absolute z-50 w-full bg-white border border-slate-200 rounded-md shadow-lg py-2 mt-1 max-h-60 overflow-y-auto"
                                    x-show="open"
                                    x-transition
                                >
                                    @foreach($sources as $source)
                                        <li 
                                            class="px-4 py-2 hover:bg-slate-50 cursor-pointer text-sm text-slate-700 transition" 
                                            wire:click="selectSource('{{ addslashes($source) }}')"
                                            x-on:click="open = false"
                                        >
                                            {{ $source }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            @error('sourceName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5 uppercase tracking-wider">
                            Archivo CSV <span class="text-red-500">*</span>
                        </label>
                        <div 
                            class="relative border-2 border-dashed rounded-lg p-8 text-center cursor-pointer transition-all bg-slate-50 hover:bg-slate-100/50"
                            :class="isDragging ? 'border-blue-400 bg-blue-50/30 shadow-inner' : 'border-slate-200 hover:border-slate-400'"
                            x-data="{ isDragging: false }"
                            x-on:dragover.prevent="isDragging = true"
                            x-on:dragleave.prevent="isDragging = false"
                            x-on:drop.prevent="
                                isDragging = false; 
                                const files = $event.dataTransfer.files;
                                if (files.length > 0) {
                                    $refs.fileInput.files = files;
                                    $refs.fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                                }
                            "
                        >
                            <input 
                                type="file" 
                                id="csv-file-input"
                                x-ref="fileInput"
                                wire:model="csvFile" 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                accept=".csv,.txt"
                            >
                            
                            <div class="space-y-3">
                                <div class="mx-auto h-12 w-12 text-slate-400">
                                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>

                                @if ($csvFile)
                                    <div class="text-sm font-semibold text-slate-800">
                                        {{ $csvFile->getClientOriginalName() }}
                                    </div>
                                    <p class="text-xs text-slate-500">
                                        Archivo cargado correctamente. Listo para procesar.
                                    </p>
                                @else
                                    <div class="text-sm font-medium text-slate-600">
                                        <span>Arrastra tu archivo CSV aquí, o</span>
                                        <span class="text-blue-600 hover:underline">búscalo en tu equipo</span>
                                    </div>
                                    <p class="text-xs text-slate-400">
                                        Formato .CSV o .TXT (Max. 10MB)
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div wire:loading wire:target="csvFile" class="w-full mt-3">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                <span>Subiendo archivo al servidor...</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-blue-600 h-1.5 rounded-full animate-pulse" style="width: 100%"></div>
                            </div>
                        </div>

                        @error('csvFile') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button 
                            type="submit" 
                            id="submit-import-button"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-md bg-slate-800 hover:bg-slate-700 text-sm font-medium text-white shadow-sm hover:shadow-lg focus:outline-none transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span wire:loading.remove wire:target="import" class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                {{ __('Importar Frases') }}
                            </span>
                            <span wire:loading.inline-flex wire:target="import" class="items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Procesando importación...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="space-y-6">
                @if ($isImported)
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-lg p-6 shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 text-emerald-600 bg-white rounded-full p-1.5 shadow-sm">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-semibold text-emerald-800 uppercase tracking-wide">Importación Exitosa</h3>
                                <p class="text-2xl font-bold text-emerald-950 mt-1">{{ $successCount }}</p>
                                <p class="text-xs text-emerald-700">frases creadas e integradas.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errorMessage)
                    <div class="bg-gradient-to-br from-rose-50 to-rose-100 border border-rose-200 rounded-lg p-6 shadow-sm animate-shake">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 text-rose-600 bg-white rounded-full p-1.5 shadow-sm">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-semibold text-rose-800 uppercase tracking-wide">Error de Importación</h3>
                                <p class="text-xs text-rose-950 mt-2 font-medium leading-relaxed bg-white/50 p-3 rounded border border-rose-100">
                                    {{ $errorMessage }}
                                </p>
                                <p class="text-xs text-rose-700 mt-2">Ningún registro fue guardado en la base de datos (Transacción revertida).</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (!empty($skippedQuotes))
                    <div class="bg-white border border-slate-200 rounded-lg shadow-md overflow-hidden">
                        <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex justify-between items-center">
                            <h4 class="text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Filas Omitidas (Duplicados: {{ count($skippedQuotes) }})
                            </h4>
                            <span class="bg-amber-100 text-amber-800 text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                Omitidas
                            </span>
                        </div>
                        <div class="max-h-96 overflow-y-auto divide-y divide-slate-100">
                            @foreach ($skippedQuotes as $skipped)
                                <div class="p-3.5 hover:bg-slate-50 transition text-xs">
                                    <div class="flex justify-between items-center text-slate-500 font-medium mb-1">
                                        <span>Fila {{ $skipped['line'] }}</span>
                                        @if($skipped['bible_verse'])
                                            <span class="bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded text-[10px]">
                                                {{ $skipped['bible_verse'] }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-slate-700 italic font-serif leading-relaxed line-clamp-3">
                                        "{{ $skipped['quote'] }}"
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
