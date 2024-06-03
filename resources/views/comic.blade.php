<x-app-layout>
    <x-slot name="header">
        <h2 class="comic-title">
            {{ $comic['title'] }}
        </h2>
    </x-slot>

    <div class="comic-content">
        <div class="comic-container">
            <div class="comic-flex">
                <div class="comic-image">
                    <img class="comic-thumbnail" src="{{ $comic['thumbnail']['path'] . '/portrait_uncanny.' . $comic['thumbnail']['extension'] }}"
                        alt="{{ $comic['title'] }}">
                </div>
                <form method="POST" action="{{ route('readingList.update', $comic['id']) }}" id="añadir" data-comic_id="{{ $comic['id'] }}">
                    @csrf
                    <input type="hidden" name="comic_id" value="{{ $comic['id'] }}" id="id">
                    <button type="submit" class="btn">Añadir a mi lista +</button>
                </form>
                <div class="comic-details">
                    <h1 class="comic-main-title">{{ $comic['title'] }}</h1>
                    @if (!empty(($comic['creators']['items'])))
                    <h2 class="comic-subtitle">Autores:</h2>
                    <ul class="comic-authors">
                        @foreach ($comic['creators']['items'] as $creator)
                            <li class="comic-author">{{ $creator['name'] }}</li>
                        @endforeach
                    </ul>
                    @endif
                    @if (!empty($comic['characters']['items']))
                        <h2 class="comic-subtitle">Personajes:</h2>
                        <ul class="comic-characters">
                            @foreach ($comic['characters']['items'] as $character)
                                <li class="comic-character">{{ $character['name'] }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if (!empty($comic['stories']['items']))
                        <h2 class="comic-subtitle">Historias:</h2>
                        <ul class="comic-stories">
                            @foreach ($comic['stories']['items'] as $story)
                                <li class="comic-story">{{ $story['name'] }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if (collect($comic['prices'])->contains(function ($price) {
                        return $price['price'] != 0;
                    }))
                        <h2 class="comic-subtitle">Precio:</h2>
                        <ul class="comic-prices">
                            @foreach ($comic['prices'] as $price)
                                @if ($price['price'] != 0)
                                    <li class="comic-price">{{ $price['price'] }} $</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                    <p class="comic-description">{{ $comic['description'] }}</p>
                    <p class="comic-page-count">Numero de paginas: {{ $comic['pageCount']}}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>