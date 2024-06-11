<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{__('Lista de lectura')}}
        </h2>
    </x-slot>
    <div class="comic-container">
        @if (count($comics) == 0)
            <p class="no-comics">No hay cómics en tu lista de lectura</p>
        @endif
        @foreach ($comics as $comic)
        <div id="message" style="display: none;"></div>
            <div class="comic-item">
                <img src="{{ $comic['thumbnail']['path'] . '/portrait_uncanny.' . $comic['thumbnail']['extension'] }}" alt="{{ $comic['title'] }}">
                <p id="comic-title">{{ $comic['title'] }}</p>
                <form method="POST" action="{{ route('readingList.update', $comic['id']) }}" class="update-reading-status" data-comic_id="{{ $comic['id'] }}">
                    @csrf
                    @method('PUT')
                    <input type="radio" id="unread" name="status" id="status"  value="unread" {{ $comic['status'] == 'unread' ? 'checked' : '' }}>
                    <label for="unread" class="state">Sin leer</label>
                    <input type="radio" id="reading" name="status" id="status" value="reading" {{ $comic['status'] == 'reading' ? 'checked' : '' }}>
                    <label for="reading" class="state">En proceso</label>
                    <input type="radio" id="read" name="status" id="status" value="read" {{ $comic['status'] == 'read' ? 'checked' : '' }}>
                    <label for="read" class="state">Leído</label>
                    <button type="submit" class="update_button">Actualizar estado</button>
                </form>
                <form method="POST" action="{{ route('readingList.destroy', $comic['id']) }}" class="delete-comic" data-comic_id="{{ $comic['id'] }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete_button">Eliminar de la lista de lectura</button>
                </form>
            </div>
        @endforeach
    </div>
</x-app-layout>