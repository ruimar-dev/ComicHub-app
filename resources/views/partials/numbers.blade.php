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
@endif
