<div wire:poll.visible.5s="next" class="relative w-full">
    <!-- Contenedor del Slider -->
    <div class="relative h-[clamp(16rem,36vw,32rem)] overflow-hidden">
        @foreach ($images as $index => $image)
            <div class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                style="opacity: {{ $index == $currentIndex ? '1' : '0' }}">
                <img src="{{ $image }}" alt="Slide {{ $index + 1 }}" class="h-full w-full object-cover">
            </div>
        @endforeach
    </div>

    <!-- Botones de Navegación -->
    <button wire:click="prev"
        class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-slate-900/60 p-3 text-white transition hover:bg-slate-900/80">
        ❮
    </button>
    <button wire:click="next"
        class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-slate-900/60 p-3 text-white transition hover:bg-slate-900/80">
        ❯
    </button>

    <!-- Indicadores -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        @foreach ($images as $index => $image)
            <span class="w-3 h-3 rounded-full {{ $index == $currentIndex ? 'bg-white' : 'bg-gray-400' }}"></span>
        @endforeach
    </div>
</div>
