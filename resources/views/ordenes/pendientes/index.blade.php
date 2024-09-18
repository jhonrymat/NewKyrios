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
                                <th>Listo</th>
                                <th>Configuraciones</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            {{-- <tr>
                                    <td>{{ $orden->codigo }}</td>
                                    <td>{{ $orden->nomcliente }}</td>
                                    <td>{{ $orden->marca }}</td>
                                    <td>{{ $orden->fecha }}</td>
                                    <td>{{ $orden->celcliente }}</td>
                                    <td>{{ $orden->tecnico }}</td>
                                    <td>{{ $orden->valor }}</td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input toggleReparado"
                                                id="switchReparado{{ $orden->codigo }}" data-codigo="{{ $orden->codigo }}"
                                                {{ $orden->reparado == 'reparado' ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="switchReparado{{ $orden->codigo }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('ordenes.pdf.pendientes', $orden->codigo) }}" target="_blank"
                                            class="btn btn-warning btn-sm mb-2">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        <a data-toggle="modal" data-target="#modal-finalizar-{{ $orden->codigo }}"
                                            class="btn btn-success btn-sm mb-2" title="Finalizar">
                                            <i class="fa fa-check"></i>
                                        </a>

                                        <a data-toggle="modal" data-target="#modal-edit-{{ $orden->codigo }}"
                                            class="btn btn-primary btn-sm mb-2" title="Editar">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm mb-2 deleteApp"
                                            data-appid="{{ $orden->codigo }}" data-toggle="modal"
                                            data-target="#deleteConfirmationModal">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </td>
                                    <td>{{ $orden->modelo }}</td>
                                    <td>{{ $orden->notacliente }}</td>
                                    <td>{{ $orden->observaciones }}</td>
                                </tr> --}}
                            {{-- modal finalizar --}}
                            @include('ordenes.pendientes.finalizar-modal')
                            {{-- modal edit --}}
                            @include('ordenes.pendientes.edit-modal')
                            <!-- Modal de Confirmación de Eliminación -->
                            @include('ordenes.pendientes.delete-modal')
                            {{-- modal create --}}
                            @include('ordenes.pendientes.create-modal')
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
                    $('#notatecnicoE').val(data.notatecnico);
                    $('#valorE').val(data.valor);
                    $('#fechafinE').val(fechaFormateada);

                    // Establecer la acción del formulario
                    $('#editForm').attr('action', `/admin/orden/${ordenId}`);
                    $('#editOrderModal').modal('show'); // Mostrar el modal
                }
            });
        });
        $('#editForm').on('submit', function(e) {
            e.preventDefault(); // Evitar la recarga de la página
            var formData = $(this).serialize(); // Serializar los datos del formulario
            var ordenId = $(this).attr('action').split('/').pop(); // Obtener el ID de la orden desde la URL

            $.ajax({
                type: "POST",
                url: "{{ route('ordenes.update', '') }}/" + ordenId, // Generar correctamente la URL
                data: formData,
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
                url: "/admin/orden/finalizar/" +
                    ordenId, // Generar correctamente la URL
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Actualizado',
                            'La orden ha sido finalizada correctamente.',
                            'success'
                        );
                        $('#finalizarOrderModal').modal('hide'); // Cerrar modal
                        $('#ordenes-table').DataTable().ajax.reload();
                        document.getElementById('finalizarForm').reset();
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert("Error al finalizar la orden");
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
                var formData = $(this).serialize(); // Serializa los datos del formulario

                $.ajax({
                    type: "POST",
                    url: "{{ route('ordenes.store') }}", // Asegúrate de que esta es la ruta correcta
                    data: formData,
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Estado de reparación actualizado correctamente',
                            timer: 1500
                        });
                    }
                    $('#ordenes-table').DataTable().ajax.reload();
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
@stop
