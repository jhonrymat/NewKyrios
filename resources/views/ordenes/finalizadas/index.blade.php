@extends('adminlte::page')

@section(['plugins.Select2', true, 'plugins.sweetalert2', true])

@section('title', 'Ordenes finalizadas')

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
                    <h3 class="card-title">Listado de Ordenes Finalizadas</h3>
                </div>
                <div class="card-body">
                    <table id="ordenes-table" class="dt-container dt-empty-footer">
                        <thead>
                            <tr>
                                <th>Orden</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Celular</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Tecnico</th>
                                <th>Foto</th>
                                <th>Configuraciones</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center"></tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('ordenes.finalizadas.edit-modal')
        @include('ordenes.finalizadas.delete-modal')
        {{-- ver imagenes --}}
        @include('ordenes.modal.image')
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css">
    <style>
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
    <script>
        $(document).ready(function() {
            $('#ordenes-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('ordenes.finalizadas') }}", // Ruta que apuntará a tu método finalizadas
                columns: [{
                        data: 'codigo',
                        name: 'codigo'
                    },
                    {
                        data: 'fecha',
                        name: 'fecha'
                    },
                    {
                        data: 'nomcliente',
                        name: 'nomcliente'
                    },
                    {
                        data: 'celcliente',
                        name: 'celcliente'
                    },
                    {
                        data: 'marca',
                        name: 'marca'
                    },
                    {
                        data: 'modelo',
                        name: 'modelo'
                    },
                    {
                        data: 'tecnico',
                        name: 'tecnico'
                    },
                    {
                        data: 'product_image', // Nueva columna para la imagen
                        name: 'product_image',
                        render: function(data, type, row) {
                            if (data) {
                                return `<img src="/storage/${data}" class="img-thumbnail" width="50" height="50" style="cursor: pointer;" data-toggle="modal" data-target="#imageModal" data-image="/storage/${data}">`;
                            } else {
                                return 'No image';
                            }
                        }
                    },
                    {
                        data: 'codigo',
                        name: 'codigo',
                        render: function(data, type, row) {
                            // Crear el mensaje para el cliente
                            var mensaje =
                                `Hola ${row.nomcliente}, tu equipo ${row.marca} ${row.modelo} ha sido reparado y está listo para ser entregado.`;
                            var mensajeCodificado = encodeURIComponent(mensaje);
                            var whatsappLink =
                                `https://wa.me/57${row.celcliente}?text=${mensajeCodificado}`;

                            return `
                                <a href="/admin/orden/${data}/finalizados" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <button class="btn btn-primary btn-sm editOrder" data-id="${data}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm deleteApp" data-id="${data}">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <a href="${whatsappLink}" target="_blank" class="btn btn-success btn-sm">
                                    <i class="fab fa-whatsapp"></i></a>
                            `;
                        }
                    }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                responsive: true,
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>
    <script>
        $(document).on('click', '.editOrder', function() {
            var ordenId = $(this).data('id'); // Obtiene el id de la orden

            $.ajax({
                url: `/admin/orden/${ordenId}/edit`, // Ajusta según tu ruta
                type: 'GET',
                success: function(data) {
                    // Convertir la fecha de 'YYYY-MM-DD' a 'DD/MM/YYYY'
                    var fechafinOriginal = data.fechafin;
                    if (fechafinOriginal != null) {
                        var fechaFormateada = fechafinOriginal.split('/').reverse().join(
                            '-'); // Convertir a 'DD/MM/YYYY'
                    }



                    // Completar los campos del formulario con los datos recibidos
                    $('#ordenCodigo').text(data.codigo);
                    $('#tecnico').val(data.tecnico);
                    $('#fecha').val(data.fecha);
                    $('#horainicio').val(data.horainicio);
                    $('#nomcliente').val(data.nomcliente);
                    $('#celcliente').val(data.celcliente);
                    $('#equipo').val(data.equipo);
                    $('#marca').val(data.marca);
                    $('#modelo').val(data.modelo);
                    $('#serial').val(data.serial);
                    $('#cargador').val(data.cargador);
                    $('#bateria').val(data.bateria);
                    $('#otros').val(data.otros);
                    $('#notacliente').val(data.notacliente);
                    $('#observaciones').val(data.observaciones);
                    $('#notatecnico').val(data.notatecnico);
                    $('#valor').val(data.valor);
                    $('#fechafin').val(fechaFormateada);
                    // Cargar la imagen si existe
                    if (data.product_image) {
                        $('#imagenE').attr('src', `/storage/${data.product_image}`).show();
                        $('#noImageMessage').hide(); // Oculta el mensaje si hay imagen
                    } else {
                        $('#imagenE').hide();
                        $('#noImageMessage').text('No hay imagen disponible').show(); // Mostrar mensaje
                    }


                    // Establecer la acción del formulario
                    $('#editForm').attr('action', `/admin/orden/edit/finalizadas/${ordenId}`);
                    $('#editOrderModal').modal('show'); // Mostrar el modal
                }
            });
        });

        $('#editForm').on('submit', function(e) {
            e.preventDefault(); // Evitar la recarga de la página
            var formData = new FormData(this); // Serializar los datos del formulario
            var ordenId = $(this).attr('action').split('/').pop(); // Obtener el ID de la orden desde la URL

            $.ajax({
                type: "POST",
                url: "/admin/orden/edit/finalizadas/" +
                    ordenId, // Generar correctamente la URL
                data: formData,
                processData: false, // Impedir que jQuery procese los datos
                contentType: false, // Impedir que jQuery establezca el contentType
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Actualizado',
                            'La orden ha sido actualizada correctamente.',
                            'success'
                        );
                        $('#editOrderModal').modal('hide'); // Cerrar modal
                        $('#ordenes-table').DataTable().ajax.reload();
                    }
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
    <script>
        // Handle Delete button click
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
    </script>
@stop
