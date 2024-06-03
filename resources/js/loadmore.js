$("#load-more").on("click", function (){
    var offset = $(this).data('offset');
    var terminoBusqueda = $('#name').val();
    var loadMoreButton = $(this);
    var loadingButton = $('#loading-button');

    // Mostrar el botón de cargando y ocultar el botón de cargar más
    loadMoreButton.hide();
    loadingButton.show();
    $.ajax({
        url: "/dashboard/load-more",
        type: 'GET',
        data: { 
            search: terminoBusqueda,
            offset: offset 
        },
        success: function(data) {
            var comicsContainer = $('#comics-grid');
            data.forEach(function(comic) {
                var url = comicShowUrl + '/' + comic['id'];
                var comicCard = `
                    <div class="comic-card">
                    '<a href=" ${url}" target="_blank">'
                            <img src="${comic.thumbnail.path}/portrait_uncanny.${comic.thumbnail.extension}" alt="${comic.title}">
                            <h5 class="card-title">${comic.title}</h5>
                        </a>
                    </div>
                `;
                comicsContainer.append(comicCard);
            });
            $('#load-more').data('offset', offset + data.length);
             // Ocultar el botón de cargando y mostrar el botón de cargar más
             loadingButton.hide();
             loadMoreButton.show();
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar más cómics:', error);
            // Ocultar el botón de cargando y mostrar el botón de cargar más
            loadingButton.hide();
            loadMoreButton.show();
        }
    });
});
$("#button").on("click", function (){
    var terminoBusqueda = $('#name').val();
    var loadMoreButton = $('#load-more');
    var loadingButton = $('#loading-button');

    // Mostrar el botón de cargando y ocultar el botón de buscar
    loadMoreButton.hide();
    loadingButton.show();
    
    $.ajax({
        url: "/dashboard/search",
        type: 'POST',
        data: {
            search: terminoBusqueda,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function(data) {
            var comicsContainer = $('#comics-grid');
            comicsContainer.empty();
            data.forEach(function(comic) {
                var url = comicShowUrl + '/' + comic['id'];
                var comicCard = `
                    <div class="comic-card">
                    '<a href=" ${url}" target="_blank">'
                            <img src="${comic.thumbnail.path}/portrait_uncanny.${comic.thumbnail.extension}" alt="${comic.title}">
                            <h5 class="card-title">${comic.title}</h5>
                        </a>
                    </div>
                `;
                comicsContainer.append(comicCard);
            });
            // Ocultar el botón de cargando y mostrar el botón de buscar
            loadingButton.hide();
             loadMoreButton.show();
        },
        error: function(xhr, status, error) {
            console.error('Error al buscar cómics:', error);
            // Ocultar el botón de cargando y mostrar el botón de buscar
            loadingButton.hide();
             loadMoreButton.show();
        }
    });
});

$('#añadir').on('submit', function(e){
    e.preventDefault();
    var comic_id = $(this).data('comic_id');

    $.post('/reading-list/add', { comic_id: comic_id, _token: $('meta[name="csrf-token"]').attr("content") }, function() {
        alert('Cómic añadido a la lista de lectura');
    });
});

// Actualizar el estado de lectura de un cómic
$('.update-reading-status').on('submit', function(e){
    e.preventDefault();
    var comic_id = $(this).data('comic_id');
    var status = $('input[name="status"]:checked', this).val();

    $.ajax({
        url: '/reading-list/update/' + comic_id,
        type: 'POST',
        data: { 
            _method: 'PUT',
            status: status,
            _token: $('meta[name="csrf-token"]').attr("content") 
        },
        success: function() {
            alert('Estado de lectura actualizado');
        }
    });
});

// Eliminar un cómic de la lista de lectura
$('.delete-comic').on('submit', function(e){
    e.preventDefault();
    var comic_id = $(this).data('comic_id');
    var comic_element = $(this).closest('.comic-item'); // Encuentra el elemento del cómic

    $.ajax({
        url: '/reading-list/remove/' + comic_id,
        type: 'POST',
        data: { 
            _method: 'DELETE',
            _token: $('meta[name="csrf-token"]').attr("content") 
        },
        success: function() {
            comic_element.remove(); // Elimina el elemento del cómic del DOM
            alert('Cómic eliminado de la lista de lectura');

            // Comprueba si quedan cómics en la lista de lectura
            if ($('.comic-item').length === 0) {
                $('.comic-container').append('<p class="no-comics">No hay cómics en tu lista de lectura</p>');
            }
        }
    });
});