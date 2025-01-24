<div class="relative" x-data="{ open: false }">
    <input 
        type="text" 
        wire:model.live="query" 
        name="source" 
        class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" 
        placeholder="Fuente"
        x-on:focus="open = true"
        x-on:click.away="open = false"
    >
    @if(!empty($sources))
        <ul 
            class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg py-2 px-3"
            x-show="open"
        >
            @foreach($sources as $source)
                <li 
                    class="p-1 hover:bg-gray-100 cursor-pointer text-xs text-gray-500" 
                    wire:click="$set('query', '{{ $source }}')"
                    x-on:click="$wire.set('query', '{{ $source }}'); open = false"
                >
                    {{ $source }}
                </li>
            @endforeach
        </ul>
    @endif
</div>