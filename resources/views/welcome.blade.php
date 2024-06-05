<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ComicHub</title>

    <link rel="icon" href="{{ asset('img/mobile-logo-claro.png') }}" type="image/x-icon" />

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

<body class="font-sans antialiased dark:bg-#eee dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-#eee dark:text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-full lg:max-w-full">
                @include('header')

                <main class="mt-6 ">
                    <h1 class="title">Encuentra y ordena tus cómics indispensables dentro del vasto universo Marvel
                    </h1>
                    <section class="hero">
                        <div>
                            <h2>Explora el universo Marvel con ComicHub</h2>
                            <p>Bienvenido a ComicHub, tu destino definitivo para explorar y disfrutar de los cómics más
                                emocionantes de Marvel. Sumérgete en historias épicas, descubre nuevos personajes y
                                sigue las aventuras de tus héroes favoritos.</p>
                        </div>
                        <div class="imagenes">
                            <img src="{{ asset('img/iluminati.png') }}" alt="">
                        </div>
                    </section>
                    <section class="search-section">
                        <div class="imagenes">
                            <img src="{{ asset('img/Portada-del-cómic-dedicada-a-la-Fuengirola-Comic-Con.jpeg') }}"
                                alt="">
                        </div>
                        <div>
                            <h2>Encuentra tus cómics favoritos fácilmente</h2>
                            <p>Con ComicHub, la búsqueda de tus cómics favoritos es más sencilla que nunca. Utiliza
                                nuestra potente herramienta de búsqueda para encontrar rápidamente los cómics que te
                                interesan. Filtra por personajes, escritores, series o cualquier otra palabra clave que
                                desees.</p>
                            <p>Explora nuestro extenso catálogo y descubre nuevas joyas del universo Marvel. Ya sea que
                                busques cómics clásicos, eventos épicos o las últimas novedades, ComicHub tiene todo lo
                                que necesitas para satisfacer tu pasión por los cómics.</p>
                        </div>
                    </section>
                    <section>
                        <div class="register-section">
                            <div>
                                <h2>Regístrate para una experiencia personalizada</h2>
                                <p>Únete a ComicHub y disfruta de beneficios exclusivos. Regístrate para crear tu lista
                                    de lectura personalizada, donde podrás organizar y hacer un seguimiento de tus
                                    cómics favoritos, marcar los que has leído o planear leer en el futuro. Además
                                    estarás al tanto de las últimas novedades del universo Marvel.</p>
                            </div>
                            <div class="imagenes">
                                <img src="{{ asset('img/portada.png') }}" alt="">
                            </div>
                        </div>
                        <di class="register">
                            <a href="{{ route('register') }}" class="section__register">Registrarse</a>
                        </di>
                    </section>

                    <section class="contact-section">
                        <h2>¿Necesitas ayuda o tienes alguna pregunta?</h2>
                        <p>Estamos aquí para ayudarte. Contáctanos para resolver tus dudas, recibir asistencia técnica o
                            proporcionarnos tus comentarios. Tu opinión es importante para nosotros.</p>
                        <a href="{{ route('contact.index') }}" class="section__link">Contactar</a>
                    </section>
                </main>

                @include('footer')
            </div>
        </div>
    </div>
</body>
</html>
