let offset = 0;
const limit = 12;
let loadedComicIds = new Set(); // Keep track of loaded comic IDs

$("#load-more").on("click", function (){
    var terminoBusqueda = $('#name').val();
    var loadMoreButton = $(this);
    var loadingButton = $('#loading-button');
    offset += limit;
    // Show the loading button and hide the load more button
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
                if (!loadedComicIds.has(comic.id)) { // Check if the comic ID is not already loaded
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
                    loadedComicIds.add(comic.id); // Add the comic ID to the set
                }
            });
            $('#load-more').data('offset', offset + data.length);
             // Hide the loading button and show the load more button
             loadingButton.hide();
             loadMoreButton.show();
        }
    });
});

// Method to search comics
$("#button").on("click", function (){
    var terminoBusqueda = $('#name').val();
    var loadMoreButton = $('#load-more');
    var loadingButton = $('#loading-button');
    var loadingButton2 = $('#loading-button2');
    var buscar = $('#button');

    // Show the loading button and hide the load more button
    buscar.hide();
    loadingButton2.show();
    
    $.ajax({
        url: "/dashboard/search?search=" + encodeURIComponent(terminoBusqueda),
        type: 'GET',

        success: function(data) {
            var comicsContainer = $('#comics-grid');
            comicsContainer.html(data);
            
            // Hide the loading button and show the load more button
            loadingButton2.hide();
            buscar.show();
        
            // Check if there are no comics to display
            if (comicsContainer.children().length === 0) {
                // Display a message when there are no comics to display
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
            // Hide the loading button and show the load more button
            loadingButton2.hide();
            buscar.show();
        }
    });
});

// Recover the ID of the comic to add to the reading list
var addedComicIds = JSON.parse(localStorage.getItem('addedComicIds')) || {};

// Add a comic to the reading list
$('#añadir').on('submit', function(e){
    e.preventDefault();
    var comic_id = $(this).data('comic_id');

    // First, check if the comic is already in the reading list
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
        // Add the comic ID to the list of added comics
        addedComicIds[comic_id] = true;
        localStorage.setItem('addedComicIds', JSON.stringify(addedComicIds));
        // Show the success message with SweetAlert2
        Swal.fire({
            title: '¡Éxito!',
            text: 'Cómic añadido a tu lista de lectura',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    });
});

// Update the reading status of a comic
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
            // Show the success message with SweetAlert2
            Swal.fire({
                title: '¡Éxito!',
                text: 'Estado de lectura actualizado',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
    });
});

// SweetAlert2 configuration with Bootstrap styling
var swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
});

// Delete a comic from the reading list
$('.delete-comic').on('submit', function(e){
    e.preventDefault();
    var comic_id = $(this).data('comic_id');
    var comic_element = $(this).closest('.comic-item'); //  Get the comic element to remove

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
                    comic_element.remove(); // Remove the comic element from the DOM

                    swalWithBootstrapButtons.fire(
                        '¡Eliminado!',
                        'El cómic ha sido eliminado de la lista de lectura.',
                        'success'
                    );

                    // Check if there are no comics in the reading list
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

