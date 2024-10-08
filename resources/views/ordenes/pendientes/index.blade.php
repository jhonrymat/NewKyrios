@extends('adminlte::page')

@section('plugins.Select2', true, 'plugins.Sweetalert2', true)

@section('title', 'Ordenes pendientes')

@section('content')
    <div class="row">
        <div class="col-lg-12 my-3">

        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Ordenes Pendientes</h3>
                    <div class="d-flex justify-content-end">
                        <button data-toggle="modal" data-target="#createOrderModal" class="btn btn-primary btn-sm mb-2"
                            title="Crear" id="btnCreateOrder">
                            <i class="fa fa-plus-circle"></i> <span>Agregar orden</span>
                        </button>
                    </div>

                </div>
                <div class="card-body">
                    <table id="ordenes-table" class="dt-container dt-empty-footer">
                        <thead>
                            <tr>
                                <th>Orden</th>
                                <th>Cliente</th>
                                <th>Marca</th>
                                <th>Fecha</th>
                                <th>Celular</th>
                                <th>Tecnico</th>
                                <th>valor</th>
                                <th class="none">Modelo</th>
                                <th class="none">Nota Cliente</th>
                                <th class="none">Observaciones</th>
                                <th>Foto</th>
                                <th>Listo</th>
                                <th>Configuraciones</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            {{-- modal finalizar --}}
                            @include('ordenes.pendientes.finalizar-modal')
                            {{-- modal edit --}}
                            @include('ordenes.pendientes.edit-modal')
                            <!-- Modal de Confirmación de Eliminación -->
                            @include('ordenes.pendientes.delete-modal')
                            {{-- modal create --}}
                            @include('ordenes.pendientes.create-modal')
                            {{-- ver imagenes --}}
                            @include('ordenes.modal.image')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css">
    <style>
        /* Mostrar solo el ícono en pantallas pequeñas (móviles) */
        @media (max-width: 768px) {
            #btnCreateOrder span {
                display: none;
                /* Ocultar el texto */
            }

            #btnCreateOrder i {
                font-size: 1.5rem;
                /* Ajustar el tamaño del icono si es necesario */
            }
        }

        #imageContainer {
            width: auto;
            /* Ajuste automático del ancho según el contenido */
            height: auto;
            /* Ajuste automático del alto según el contenido */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            /* Asegura que el contenido que se salga del contenedor se oculte */
        }

        #imagenE {
            max-width: 100%;
            /* Asegura que la imagen no se salga del contenedor */
            max-height: 100%;
            /* Asegura que la imagen no se salga del contenedor */
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ordenes-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('ordenes.pendientes') }}", // Ruta que apuntará a tu método finalizadas
                columns: [{
                        data: 'codigo',
                        name: 'codigo'
                    },
                    {
                        data: 'nomcliente',
                        name: 'nomcliente'
                    },
                    {
                        data: 'marca',
                        name: 'marca'
                    },
                    {
                        data: 'fecha',
                        name: 'fecha'
                    },

                    {
                        data: 'celcliente',
                        name: 'celcliente'
                    },
                    {
                        data: 'tecnico',
                        name: 'tecnico'
                    },
                    {
                        data: 'valor',
                        name: 'valor'
                    },

                    {
                        data: 'modelo',
                        name: 'modelo'
                    },
                    {
                        data: 'notacliente',
                        name: 'notacliente'
                    },
                    {
                        data: 'observaciones',
                        name: 'observaciones'
                    },
                    {
                        data: 'product_image', // Nueva columna para la imagen
                        name: 'product_image',
                        render: function(data, type, row) {
                            if (data) {
                                // Convertir la cadena de rutas de imágenes a un array
                                const imagePaths = data.split(',');

                                // Crear un HTML para mostrar todas las imágenes
                                let imagesHtml = '';
                                imagePaths.forEach(path => {
                                    imagesHtml += `
                                        <div class="image-wrapper" style="position: relative; display: inline-block; margin: 5px;">
                                            <img src="/storage/${path}" class="img-thumbnail" width="50" height="50" style="cursor: pointer;" data-toggle="modal" data-target="#imageModal" data-image="/storage/${path}">
                                            <button class="btn btn-danger btn-sm delete-image" data-path="${path}" data-id="${row.codigo}" style="position: absolute; top: 0; right: 0; transform: translate(50%, -50%);">
                                                &times;
                                            </button>
                                        </div>
                                    `;
                                });

                                return imagesHtml; // Devolver el HTML con todas las imágenes
                            } else {
                                return 'No image';
                            }
                        }
                    },

                    {
                        data: 'codigo',
                        name: 'codigo',
                        render: function(data, type, row) {
                            return `
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input toggleReparado"
                                        id="switchReparado${data}" data-codigo="${data}"
                                        ${row.reparado == 'reparado' ? 'checked' : ''}>
                                    <label class="custom-control-label"
                                        for="switchReparado${data}"></label>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'codigo',
                        name: 'codigo',
                        render: function(data, type, row) {
                            return `
                                <a href="/admin/orden/${data}/pendientes" target="_blank" class="btn btn-warning btn-sm mb-2">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <button class="btn btn-success btn-sm mb-2 finalizarOrden" data-id="${data}">
                                    <i class="fa fa-check"></i>
                                </button>
                                <a data-toggle="modal" data-id="${data}"
                                    class="btn btn-primary btn-sm mb-2 editarOrden" title="Editar">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm mb-2 deleteApp"
                                    data-id="${data}">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button class="btn btn-info btn-sm mb-2 whatsappMessage" data-id="${data}">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                            `;
                        }
                    }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                responsive: true,
                columnDefs: [{
                    targets: [9, 10, 11], // La columna de "Observaciones"
                    className: "none" // Clase none para ocultarla en móvil
                }],
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>
    {{-- editar --}}
    <script>
        $(document).on('click', '.editarOrden', function() {
            var ordenId = $(this).data('id'); // Obtiene el id de la orden

            $.ajax({
                url: `/admin/orden/${ordenId}/ajax`, // Ruta para obtener los detalles de la orden
                type: 'GET',
                success: function(data) {
                    // Completar los campos del formulario con los datos recibidos
                    $('#ordenCodigoE').text(data.codigo);
                    $('#tecnicoE').val(data.tecnico);
                    $('#fechaE').val(data.fecha);
                    $('#horainicioE').val(data.horainicio);
                    $('#nomclienteE').val(data.nomcliente);
                    $('#celclienteE').val(data.celcliente);
                    $('#equipoE').val(data.equipo);
                    $('#marcaE').val(data.marca);
                    $('#modeloE').val(data.modelo);
                    $('#serialE').val(data.serial);
                    $('#cargadorE').val(data.cargador);
                    $('#bateriaE').val(data.bateria);
                    $('#otrosE').val(data.otros);
                    $('#notaclienteE').val(data.notacliente);
                    $('#observacionesE').val(data.observaciones);
                    $('#valorE').val(data.valor);

                    // Manejar las imágenes existentes
                    if (data.product_image) {
                        const imagePaths = data.product_image.split(',');
                        let imagesHtml = '';
                        imagePaths.forEach((path, index) => {
                            imagesHtml += `
                                        <div class="image-wrapper" style="position: relative; display: inline-block; margin: 5px;">
                                            <img src="/storage/${path}" class="img-thumbnail" width="50" height="50">
                                        </div>`;
                        });
                        $('#existingImagesContainer').html(
                            imagesHtml); // Mostrar las imágenes en el contenedor
                    } else {
                        $('#existingImagesContainer').html('<p>No hay imágenes disponibles</p>');
                    }

                    // Establecer la acción del formulario para actualizar
                    $('#editForm').attr('action', `/admin/orden/${ordenId}`);
                    $('#editOrderModal').modal('show'); // Mostrar el modal
                },
                error: function(error) {
                    console.log('Error al cargar los detalles de la orden:', error);
                    Swal.fire('Error', 'No se pudieron cargar los detalles de la orden.', 'error');
                }
            });
        });

        $('#editForm').on('submit', function(e) {
            e.preventDefault(); // Evitar la recarga de la página
            var formData = new FormData(this); // Serializar los datos del formulario
            var ordenId = $(this).attr('action').split('/').pop(); // Obtener el ID de la orden desde la URL

            $.ajax({
                type: "POST",
                url: "{{ route('ordenes.update', '') }}/" + ordenId, // Generar correctamente la URL
                data: formData,
                processData: false, // Impedir que jQuery procese los datos
                contentType: false, // Impedir que jQuery establezca el contentType
                success: function(response) {
                    Swal.fire(
                        'Actualizada',
                        'La orden ha sido Actualizada correctamente.',
                        'success'
                    );
                    $('#editOrderModal').modal('hide'); // Cerrar modal
                    $('#ordenes-table').DataTable().ajax.reload();
                },
                error: function(error) {
                    console.log(error);
                    Swal.fire(
                        'Error',
                        'Hubo un problema al actualizar la orden.',
                        'error'
                    );
                }
            });
        });
    </script>
    {{-- Finalizar --}}
    <script>
        $(document).on('click', '.finalizarOrden', function() {
            var ordenId = $(this).data('id'); // Obtiene el id de la orden

            $.ajax({
                url: `/admin/orden/${ordenId}/ajax`, // Ajusta según tu ruta
                type: 'GET',
                success: function(data) {
                    // Convertir la fecha de 'YYYY-MM-DD' a 'DD/MM/YYYY'
                    var fechafinOriginal = data.fechafin;
                    if (fechafinOriginal != null) {
                        var fechaFormateada = fechafinOriginal.split('/').reverse().join(
                            '-'); // Convertir a 'DD/MM/YYYY'
                    } else {
                        // Obtener la fecha actual en formato 'YYYY-MM-DD' si no hay fecha original
                        var today = new Date();
                        var day = String(today.getDate()).padStart(2,
                            '0'); // Asegurarse de que el día tenga dos dígitos
                        var month = String(today.getMonth() + 1).padStart(2,
                            '0'); // Los meses en JS son de 0 a 11
                        var year = today.getFullYear();

                        var fechaFormateada = day + '/' + month + '/' +
                            year; // Formatear como 'YYYY-MM-DD'
                    } // Completar los campos del formulario con los datos recibidos

                    $('#ordenCodigo').text(data.codigo);
                    $('#tecnico').val(data.tecnico);
                    $('#fecha').val(data.fecha);
                    $('#horainicio').val(data.horainicio);
                    $('#nomclienteFin').val(data.nomcliente);
                    $('#celcliente').val(data.celcliente);
                    $('#equipoFin').val(data.equipo);
                    $('#marcaFin').val(data.marca);
                    $('#modeloFin').val(data.modelo);
                    $('#serial').val(data.serial);
                    $('#cargador').val(data.cargador);
                    $('#bateria').val(data.bateria);
                    $('#otros').val(data.otros);
                    $('#notacliente').val(data.notacliente);
                    $('#observaciones').val(data.observaciones);
                    $('#notatecnico').val(data.notatecnico);
                    $('#valor').val(data.valor);
                    $('#fechafin').val(fechaFormateada);

                    // Establecer la acción del formulario
                    $('#finalizarForm').attr('action', `/admin/orden/finalizar/${ordenId}`);
                    $('#finalizarOrderModal').modal('show'); // Mostrar el modal
                }
            });
        });

        $('#finalizarForm').on('submit', function(e) {
            e.preventDefault(); // Evitar la recarga de la página
            var formData = $(this).serialize(); // Serializar los datos del formulario
            var ordenId = $(this).attr('action').split('/').pop(); // Obtener el ID de la orden desde la URL

            $.ajax({
                type: "PUT",
                url: "/admin/orden/finalizar/" + ordenId, // Generar correctamente la URL
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Actualizado',
                            'La orden ha sido finalizada correctamente.',
                            'success'
                        );


                        $('#finalizarOrderModal').modal('hide'); // Cerrar modal
                        $('#ordenes-table').DataTable().ajax.reload(); // Recargar tabla
                        document.getElementById('finalizarForm').reset(); // Limpiar el formulario
                    }
                },
                error: function(error) {
                    console.log(error);

                    // Verifica si el error tiene un formato JSON y contiene el mensaje de error
                    if (error.responseJSON && error.responseJSON.errors) {
                        // Extrae los errores (en este caso celcliente)
                        var errorMessages = Object.values(error.responseJSON.errors).map(function(msg) {
                            return msg[0]; // En este caso toma el primer mensaje de cada campo
                        }).join('\n'); // Únelos con un salto de línea si hay más de uno

                        // Muestra los errores en un SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Errores de validación',
                            text: errorMessages
                        });
                    } else {
                        // Muestra un error genérico si no está disponible el detalle del error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo finalizar la orden'
                        });
                    }
                }

            });
        });
    </script>
    <script>
        $(document).on('click', '.deleteApp', function() {
            var ordenId = $(this).data('id');
            $('#delete-btn').data('id', ordenId);
            $('#deleteConfirmationModal').modal('show'); // Show the confirmation modal
        });
        $('#delete-btn').click(function() {
            var ordenId = $(this).data('id');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/orden/${ordenId}`,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {
                            Swal.fire(
                                'Eliminado',
                                'La orden ha sido eliminada correctamente.',
                                'success'
                            );
                            $('#deleteConfirmationModal').modal('hide');
                            $('#ordenes-table').DataTable().ajax.reload(); // Recargar la tabla
                        },
                        error: function(error) {
                            Swal.fire(
                                'Error',
                                'Hubo un problema al eliminar la orden.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#createOrderForm').submit(function(e) {
                e.preventDefault(); // Prevenir la recarga de la página
                var formData = new FormData(this); // Serializa los datos del formulario

                $.ajax({
                    type: "POST",
                    url: "{{ route('ordenes.store') }}", // Asegúrate de que esta es la ruta correcta
                    data: formData,
                    contentType: false, // Necesario para la subida de archivos
                    processData: false, // Necesario para la subida de archivos
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Orden creada con éxito. Número de Orden: ' + response
                                .id,
                            confirmButtonText: 'Aceptar'
                        });
                        $('#createOrderModal').modal('hide'); // Cerrar modal
                        $('#ordenes-table').DataTable().ajax.reload();
                        document.getElementById('createOrderForm').reset();
                        // Restablecer Select2 también
                        $('#nomcliente').val(null).trigger(
                            'change'); // Restablecer Select2 para el cliente
                        $('#equipo').val(null).trigger(
                            'change');
                        $('#marca').val(null).trigger(
                            'change');
                        $('#modelo').val(null).trigger(
                            'change');
                    },
                    error: function(xhr) {
                        // Limpiar cualquier error anterior
                        $('.alert-danger').remove();

                        // Si ocurre un error, mostrar los errores en el modal
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<div class="alert alert-danger"><ul>';

                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value[0] + '</li>';
                        });
                        errorHtml += '</ul></div>';

                        $('#createOrderForm').prepend(
                            errorHtml); // Muestra los errores en el modal
                    }
                });
            });
        });
    </script>

    {{-- cambiar estado de la columna reparado --}}
    <script>
        $(document).on('change', '.toggleReparado', function() {
            var ordenId = $(this).data('codigo');
            var reparado = $(this).is(':checked') ? 'reparado' : '';

            $.ajax({
                url: "{{ route('ordenes.update.reparado', '') }}/" + ordenId,
                type: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    reparado: reparado
                },
                success: function(response) {
                    if (response.success) {
                        // Mostrar el enlace de WhatsApp
                        if (response.whatsapp_link && response.estado == 'reparado') {
                            Swal.fire({
                                title: 'La orden ha cambiado de estado correctamente.',
                                text: 'Puedes enviar un mensaje al cliente:',
                                html: `<a href="${response.whatsapp_link}" target="_blank" class="btn btn-success">Enviar por WhatsApp</a>`,
                                icon: 'success',
                                showCloseButton: true,
                                showCancelButton: true,
                                focusConfirm: false,
                                confirmButtonText: 'Cerrar'
                            });
                        } else {
                            Swal.fire({
                                title: 'La orden ha cambiado de estado correctamente.',
                                icon: 'success'
                            });
                        }
                        $('#ordenes-table').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Unprocessable Entity (validación fallida)
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = Object.values(errors).map(function(msg) {
                            return msg[0];
                        }).join('\n');

                        Swal.fire({
                            icon: 'error',
                            title: 'Errores de validación',
                            text: errorMessages
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo actualizar el estado de reparación'
                        });
                    }
                }
            });
        });
    </script>

    {{-- optimizando select2 --}}
    <script>
        $(document).ready(function() {
            function inicializarSelect2(selector, tipo) {
                $(selector).select2({
                    ajax: {
                        url: "{{ route('buscar.datos') }}",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term,
                                tipo: tipo // Definir el tipo de búsqueda
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item,
                                        text: item
                                    };
                                })
                            };
                        }
                    },
                    placeholder: 'Buscar ' + tipo,
                    allowClear: true,
                    tags: true,
                    minimumInputLength: 1
                });
            }

            // Inicializar Select2 para diferentes campos
            inicializarSelect2('#nomcliente', 'cliente');
            inicializarSelect2('#equipo', 'equipo');
            inicializarSelect2('#marca', 'marca');
            inicializarSelect2('#modelo', 'modelo');
        });
    </script>
    <script>
        $(document).ready(function() {
            // Evento para abrir el modal y cargar la imagen en él
            $('#ordenes-table').on('click', 'img[data-toggle="modal"]', function() {
                var imageUrl = $(this).data('image');
                $('#modalImage').attr('src', imageUrl);
            });

            // Funcionalidad de zoom en la imagen del modal
            $('#modalImage').on('click', function() {
                if ($(this).css('cursor') === 'zoom-in') {
                    $(this).css({
                        'transform': 'scale(1.5)',
                        'cursor': 'zoom-out'
                    });
                } else {
                    $(this).css({
                        'transform': 'scale(1)',
                        'cursor': 'zoom-in'
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Aplicar el zoom y ajustar el tamaño del contenedor dinámicamente
            $('.zoomable-image').on('click', function() {
                let $image = $(this);
                let $container = $image.closest('#imageContainer'); // Obtener el contenedor

                if ($image.css('cursor') === 'zoom-in') {
                    $image.css({
                        'transform': 'scale(2)',
                        'cursor': 'zoom-out',
                        'transition': 'transform 0.3s ease'
                    });
                    $container.css({
                        'height': $image.outerHeight(true) * 2 + 'px',
                        'width': $image.outerWidth(true) * 2 + 'px'
                    });
                } else {
                    $image.css({
                        'transform': 'scale(1)',
                        'cursor': 'zoom-in',
                        'transition': 'transform 0.3s ease'
                    });
                    $container.css({
                        'height': 'auto',
                        'width': 'auto'
                    });
                }
            });
        });

        $(document).on('click', '[data-toggle="modal"][data-target="#imageModal"]', function() {
            var imageUrl = $(this).data('image');

            // Asignar la imagen al modal
            $('#modalImage').attr('src', imageUrl);

            // Asignar la URL para el botón de descarga
            $('#downloadImage').attr('href', imageUrl);

            // Funcionalidad para el botón de compartir (solo si es compatible con el navegador)
            $('#shareImage').off('click').on('click', function() {
                if (navigator.share) {
                    navigator.share({
                        title: 'Imagen del Producto',
                        text: 'Mira esta imagen del producto',
                        url: imageUrl
                    }).then(() => {
                        console.log('Compartido con éxito.');
                    }).catch((error) => {
                        console.log('Error al compartir', error);
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Compartir no compatible',
                        text: 'Tu navegador no soporta la función de compartir.'
                    });
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete-image', function() {
            var imagePath = $(this).data('path'); // Obtener la ruta de la imagen a eliminar
            var ordenId = $(this).data('id'); // Obtener el ID de la orden
            var $imageWrapper = $(this).closest('.image-wrapper'); // Obtener el contenedor de la imagen

            $.ajax({
                url: "{{ route('ordenes.deleteImage', '') }}/" + ordenId,

                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr(
                        'content'), // Asegúrate de que el token esté presente
                    image_path: imagePath
                },
                success: function(response) {
                    Swal.fire('Eliminada', 'La imagen ha sido eliminada correctamente.', 'success');
                    $imageWrapper.remove(); // Eliminar la imagen del DOM
                },
                error: function(error) {
                    Swal.fire('Error', 'Hubo un problema al eliminar la imagen.', 'error');
                }
            });

        });
    </script>
    <script>
        $(document).on('click', '.whatsappMessage', function() {
            var ordenId = $(this).data('id'); // Obtener el ID de la orden

            // Realizar una solicitud AJAX para obtener el enlace de WhatsApp desde el controlador
            $.ajax({
                url: `/admin/orden/${ordenId}/send-whatsapp-message`, // Ruta hacia el controlador
                type: 'GET',
                success: function(response) {
                    if (response.whatsapp_link) {
                        // Abrir la URL de WhatsApp en una nueva pestaña
                        window.open(response.whatsapp_link, '_blank');
                    } else {
                        Swal.fire('Error', 'No se pudo generar el enlace de WhatsApp.', 'error');
                    }
                },
                error: function(error) {
                    Swal.fire('Error', 'Hubo un problema al comunicarse con el servidor.', 'error');
                }
            });
        });
    </script>
@stop
