<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buscador de Comics') }}
        </h2>
    </x-slot>

    <div class="py-12 content">
        <div class="bg-#ddd dark:bg-gray-900 py-6">
            <div class="container mx-auto px-4">
                <h1 class="text-3xl font-bold text-center mt-6 mb-4 text-black dark:text-white">Buscador de Comic Marvel</h1>
                            
                <div class="form-group mb-4">
                    <input required type="text" name="name" id="name" class="w-full text-black px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="(Ex. Hulk, Iron Man, Spider-Man, etc...)">
                </div>
                <div class="flex justify-end">
                    <input type="submit" id="button" value="Buscar" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 cursor-pointer">
                    <button id="loading-button2" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 cursor-pointer" style="display:none;">Cargando...</button>
                </div>
            </div>
        </div>
        <div class="container p-8 md:mx-auto"id="comics-grid">
            @if (isset($error))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @else
                    <!-- Sección de Cómics -->
                    @foreach ($comics as $comic)
                        <div class="comic-card">
                            <a href="{{ route('comics.show', $comic['id']) }}" target="_blank">
                                <img src="{{ $comic['thumbnail']['path'] . '/portrait_uncanny.' . $comic['thumbnail']['extension'] }}"
                                    alt="{{ $comic['title'] }}">
                            </a>
                            <h5 class="card-title">{{ $comic['title'] }}</h5>
                        </div>
                    @endforeach
                    </div>
                    <button id="load-more" data-offset="12">Cargar más</button>
                    <button id="loading-button" style="display:none;">Cargando...</button>
            @endif
        </div>
    </div>
</x-app-layout>