let offset = 0;
const limit = 12;
let loadedComicIds = new Set(); // Almacena los IDs de los cómics ya cargados

$("#load-more").on("click", function (){
    var terminoBusqueda = $('#name').val();
    var loadMoreButton = $(this);
    var loadingButton = $('#loading-button');
    offset += limit;
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
                if (!loadedComicIds.has(comic.id)) { // Solo agrega el cómic si su ID no está en loadedComicIds
                    var url = comicShowUrl + '/' + comic['id'];
                    var comicCard = `
                        <div class="comic-card">
                        <a href=" ${url}" target="_blank">
                                <img src="${comic.thumbnail.path}/portrait_uncanny.${comic.thumbnail.extension}" alt="${comic.title}">
                                <h5 class="card-title">${comic.title}</h5>
                            </a>
                        </div>
                    `;
                    comicsContainer.append(comicCard);
                    loadedComicIds.add(comic.id); // Agrega el ID del cómic a loadedComicIds
                }
            });
            $('#load-more').data('offset', offset + data.length);
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
    var loadingButton2 = $('#loading-button2');
    var buscar = $('#button');

    // Mostrar el botón de cargando y ocultar el botón de buscar
    buscar.hide();
    loadingButton2.show();
    
    $.ajax({
        url: "/dashboard/search?search=" + encodeURIComponent(terminoBusqueda),
        type: 'GET',

        success: function(data) {
            var comicsContainer = $('#comics-grid');
            comicsContainer.html(data);
            
            // Ocultar el botón de cargando y mostrar el botón de buscar
            loadingButton2.hide();
            buscar.show();
        
            // Verificar si los datos están vacíos
            if (comicsContainer.children().length === 0) {
                // Mostrar un mensaje y ocultar el botón de "cargar más"
                comicsContainer.css({
                    'display': 'flex',
                    'justify-content': 'center',
                    'align-items': 'center',
                });
                comicsContainer.html('<p class="no-comics">No se encontraron resultados para tu búsqueda.</p>');
                loadMoreButton.hide();
            } else {
                comicsContainer.css({
                    'display': 'grid',
                    'grid-template-columns': 'repeat(auto-fill, minmax(250px, 1fr))',
                    'gap': '16px',
                    'align-items': 'stretch',
                });
                loadMoreButton.show();
            }
        
            history.pushState(null, '', '?search=' + encodeURIComponent(terminoBusqueda));
        },
        error: function(xhr, status, error) {
            console.error('Error al buscar cómics:', error);
            // Ocultar el botón de cargando y mostrar el botón de buscar
            loadingButton2.hide();
            buscar.show();
        }
    });
});
// Recuperar los IDs de los cómics añadidos del almacenamiento local
var addedComicIds = JSON.parse(localStorage.getItem('addedComicIds')) || {};

$('#añadir').on('submit', function(e){
    e.preventDefault();
    var comic_id = $(this).data('comic_id');

    // Comprueba si el cómic ya está en la lista de lectura
    if (addedComicIds[comic_id]) {
        Swal.fire({
            title: '¡Error!',
            text: 'Este cómic ya está en tu lista de lectura',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    $.post('/reading-list/add', { comic_id: comic_id, _token: $('meta[name="csrf-token"]').attr("content") }, function() {
        // Añade el ID del cómic al registro y lo guarda en el almacenamiento local
        addedComicIds[comic_id] = true;
        localStorage.setItem('addedComicIds', JSON.stringify(addedComicIds));
        // Muestra el mensaje con SweetAlert2
        Swal.fire({
            title: '¡Éxito!',
            text: 'Cómic añadido a tu lista de lectura',
            icon: 'success',
            confirmButtonText: 'OK'
        });
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
            // Muestra el mensaje con SweetAlert2
            Swal.fire({
                title: '¡Éxito!',
                text: 'Estado de lectura actualizado',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
    });
});

var swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
});

$('.delete-comic').on('submit', function(e){
    e.preventDefault();
    var comic_id = $(this).data('comic_id');
    var comic_element = $(this).closest('.comic-item'); // Encuentra el elemento del cómic

    swalWithBootstrapButtons.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '¡Sí, bórralo!',
        cancelButtonText: '¡No, cancela!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/reading-list/remove/' + comic_id,
                type: 'POST',
                data: { 
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr("content") 
                },
                success: function() {
                    comic_element.remove(); // Elimina el elemento del cómic del DOM

                    swalWithBootstrapButtons.fire(
                        '¡Eliminado!',
                        'El cómic ha sido eliminado de la lista de lectura.',
                        'success'
                    );

                    // Comprueba si quedan cómics en la lista de lectura
                    if ($('.comic-item').length === 0) {
                        $('.comic-container').append('<p class="no-comics">No hay cómics en tu lista de lectura</p>');
                    }
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'Tu cómic está seguro :)',
                'error'
            );
        }
    });
});

