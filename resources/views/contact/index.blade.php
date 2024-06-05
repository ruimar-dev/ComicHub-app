<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ComicHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    @vite(['resources/css/main.css', 'resources/js/style.js'])
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    @include('header')
    <div class="container mensaje">
        <div class="flex justify-center">
            <div class="form-container">
                <div class="header">
                    <h2>Contacto</h2>
                </div>
    
                <div class="content">
                    <p>¡Gracias por ponerte en contacto con nosotros! Por favor, completa el siguiente formulario y te responderemos lo antes posible.</p>
    
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
    
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}">
                        </div>
    
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror
    
                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}">
                        </div>
    
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
    
                        <div class="form-group">
                            <label for="message">Mensaje:</label>
                            <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                        </div>
    
                        @error('message')
                            <div class="error">{{ $message }}</div>
                        @enderror
    
                        <div class="text-center">
                            <button type="submit">Enviar Mensaje</button>
                        </div>
                    </form>
                    @if (session('message'))
                        <script>
                            alert("{{ session('message') }}");
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>    
    @include('footer')
</body>

</html>
