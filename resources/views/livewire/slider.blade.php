<div class="relative w-full max-w-4xl mx-auto">
    <!-- Contenedor del Slider -->
    <div class="relative overflow-hidden rounded-lg h-96">
        @foreach ($images as $index => $image)
            <div class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                style="opacity: {{ $index == $currentIndex ? '1' : '0' }}">
                <img src="{{ $image }}" alt="Slide {{ $index + 1 }}" class="w-full h-96 object-cover">
            </div>
        @endforeach
    </div>

    <!-- Botones de Navegación -->
    <button wire:click="prev"
        class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full">
        ❮
    </button>
    <button wire:click="next"
        class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full">
        ❯
    </button>

    <!-- Indicadores -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        @foreach ($images as $index => $image)
            <span class="w-3 h-3 rounded-full {{ $index == $currentIndex ? 'bg-white' : 'bg-gray-400' }}"></span>
        @endforeach
    </div>
</div>
