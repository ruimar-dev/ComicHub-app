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

    <main>
        <section id="quienes-somos" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
            <div class="container">
                <h2 class="subtitle">Quiénes somos</h2>
        
                <!-- Historia de ComicHub -->
                <article class="article">
                    <h3>Historia de ComicHub</h3>
                    <p>ComicHub comenzó con una pasión por los cómics y la tecnología. Sergio, se dio cuenta de que
                        encontrar y acceder a los cómics que les gustaban era un desafío. Así que decidio crear
                        ComicHub: una plataforma en línea donde los amantes de los cómics pueden descubrir, leer y
                        discutir sus historias favoritas.</p>
                </article>
        
                <!-- Equipo -->
                <article class="article">
                    <h3>Equipo</h3>
                    <div class="team-member">
                        <img src="{{ asset('img/Foto_Sergio.jpeg') }}" alt="Sergio Ruiz">
                        <p>Sergio Ruiz - fundador y CEO</p>
                    </div>
                </article>
        
                <!-- Objetivos y Filosofía -->
                <article class="article">
                    <h3>Objetivos y Filosofía</h3>
                    <p>Nuestro objetivo en ComicHub es hacer que la experiencia de leer cómics sea más accesible,
                        emocionante y enriquecedora para todos. Creemos en la diversidad y la inclusión en la narración
                        de historias, y nos esforzamos por ofrecer una plataforma donde todos puedan encontrar cómics
                        que los representen y los inspiren. Valoramos la calidad, la comunidad y la innovación en todo
                        lo que hacemos.</p>
                </article>
        
                <!-- Redes Sociales -->
                <article class="article">
                    <h3>Redes Sociales</h3>
                    <div class="footer__social">
                        <a href="https://x.com/ruimardev?t=T1PvKIg2-U4jaU6QC-9TCg&s=09" target="_blank"><span
                                class="icon-twitter"></span></a>
                        <a href="https://github.com/ruimar-dev" target="_blank"><span class="icon-github"></span></a>
                        <a href="https://www.instagram.com/_sergio_.22?igsh=NGVhN2U2NjQ0Yg==" target="_blank"><span
                                class="icon-instagram"></span></a>
                    </div>
                </article>
        </section>
    </main>

    @include('footer')

</body>

</html>
