<ul>
    @foreach ($results as $comic)
        <li>
            <h2>{{ $comic['title'] }}</h2>
            <img src="{{ $comic['thumbnail']['path'] . '.' . $comic['thumbnail']['extension'] }}" alt="{{ $comic['title'] }}">
            <p>{{ $comic['description'] }}</p>
        </li>
    @endforeach
</ul>
