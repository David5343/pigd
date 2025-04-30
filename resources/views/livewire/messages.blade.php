@php
    $colors = [
        'success' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'hover' => 'hover:text-green-900'],
        'error' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'hover' => 'hover:text-red-900'],
        'warning' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'hover' => 'hover:text-yellow-900'],
        'info' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'hover' => 'hover:text-blue-900'],
    ];

    $style = $colors[$type] ?? $colors['success'];
@endphp

<div>
    @if ($msg)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-30">
            <div class="relative {{ $style['bg'] }} {{ $style['text'] }} p-4 rounded-lg shadow-lg max-w-md w-full mx-4">
                <button wire:click="close"
                    class="absolute top-2 right-2 text-2xl font-bold {{ $style['text'] }} {{ $style['hover'] }}">
                    &times;
                </button>
                <div class="flex flex-col w-full">
                    <h2 class="text-xl font-bold text-gray-700 mb-4">PIGD</h2>
                </div>
                <div class="flex flex-col w-full">
                    <h1 class="text-xl font-bold text-gray-700 mb-4"> {{ $msg }}</h1>
                </div>
            </div>
        </div>
    @endif
</div>
