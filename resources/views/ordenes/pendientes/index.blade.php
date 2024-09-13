@extends('adminlte::page')

@section('plugins.Select2', true)

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
                            <i class="fa fa-plus-circle"></i> Agregar orden
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
                                <th>Listo</th>
                                <th>Configuraciones</th>
                                <th class="none">Modelo</th>
                                <th class="none">Nota Cliente</th>
                                <th class="none">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            @foreach ($OrdenPen as $orden)
                                <tr>
                                    <td>{{ $orden->codigo }}</td>
                                    <td>{{ $orden->nomcliente }}</td>
                                    <td>{{ $orden->marca }}</td>
                                    <td>{{ $orden->fecha }}</td>
                                    <td>{{ $orden->celcliente }}</td>
                                    <td>{{ $orden->tecnico }}</td>
                                    <td>{{ $orden->valor }}</td>
                                    <td>
                                        {{-- <input type="checkbox" class="toggle-reparado" data-codigo="{{ $orden->codigo }}"
                                            {{ $orden->reparado == 'reparado' ? 'checked' : '' }}> --}}
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
                                </tr>
                                {{-- modal finalizar --}}
                                @include('ordenes.pendientes.finalizar-modal')
                                {{-- modal edit --}}
                                @include('ordenes.pendientes.edit-modal')
                                <!-- Modal de Confirmación de Eliminación -->
                                @include('ordenes.pendientes.delete-modal')
                            @endforeach
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
        #scanner-container {
            width: 100%;
            max-width: 640px;
            /* Limitar el ancho */
            height: 350px;
            position: relative;
            border: 1px solid #ddd;
        }

        #scanner-container canvas,
        #scanner-container video {
            width: 100% !important;
            height: auto !important;
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
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
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
        $('form[id^="editForm-"]').on('submit', function(e) {
            e.preventDefault(); // Evitar la recarga de la página
            var appId = this.id.split('-')[1]; // Obtener el ID de la aplicación
            var formData = $(this).serialize(); // Serializar los datos del formulario

            $.ajax({
                type: "POST",
                url: "{{ route('ordenes.update', '') }}/" + appId, // Generar correctamente la URL
                data: formData,
                success: function(response) {
                    alert("Orden actualizada con éxito");
                    location.reload(); // Opcional: recargar la página o actualizar la vista
                },
                error: function(error) {
                    console.log(error);
                    alert("Error al actualizar la orden");
                }
            });
        });
    </script>
    {{-- Finalizar --}}
    <script>
        $('form[id^="finalizarForm-"]').on('submit', function(e) {
            e.preventDefault(); // Evitar la recarga de la página
            var appId = this.id.split('-')[1]; // Obtener el ID de la aplicación
            var formData = $(this).serialize(); // Serializar los datos del formulario

            $.ajax({
                type: "POST",
                url: "{{ route('ordenes.finalizar', '') }}/" + appId, // Generar correctamente la URL
                data: formData,
                success: function(response) {
                    alert("Orden finalizada con éxito");
                    location.reload(); // Opcional: recargar la página o actualizar la vista
                },
                error: function(error) {
                    console.log(error);
                    alert("Error al finalizar la orden");
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Usar delegated event para asegurar que siempre se capture el evento, incluso en elementos dinámicos
            $(document).on('click', '.deleteApp', function() {
                var ordenCodigo = $(this).data('appid'); // Obtén el código de la orden
                console.log("Código de la orden a eliminar: " + ordenCodigo); // Verifica en la consola
                $('#delete-btn').data('appid', ordenCodigo); // Asigna el código al botón de confirmación
            });

            // Confirmar la eliminación al hacer clic en el botón del modal
            $('#delete-btn').click(function() {
                var ordenCodigo = $(this).data('appid'); // Obtiene el código de la orden
                if (ordenCodigo) {
                    $.ajax({
                        url: "{{ route('ordenes.update', '') }}/" +
                            ordenCodigo, // Asegúrate de ajustar esta URL según tu enrutamiento
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // Token CSRF
                        },
                        success: function(response) {
                            alert("Orden eliminada con éxito");
                            location.reload(); // Recargar la página
                        },
                        error: function(error) {
                            console.log(error);
                            alert("Error al eliminar la orden");
                        }
                    });
                } else {
                    console.log("Código de la orden no definido");
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
                        alert("Orden creada con éxito"); // Mensaje de éxito
                        location.reload(); // Recargar la página o actualizar los datos
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
    <script>
        $(document).ready(function() {
            $('#btnCreateOrder').click(function() {
                // Hacer la petición AJAX al abrir el modal
                $.ajax({
                    url: "{{ route('getLatestOrderId') }}",
                    type: "GET",
                    success: function(data) {
                        // Actualizar el campo del código de orden con el nuevo ID
                        $('#nuevoCodigoInput').val(data
                            .nuevoCodigo); // Aquí pones el valor en el input
                    },
                    error: function() {
                        alert('Error al obtener el nuevo código de orden');
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
    <script>
        document.getElementById('start-scan').addEventListener('click', function() {
            // Mostrar el contenedor de la cámara solo cuando comience el escaneo
            document.getElementById('scanner-container').style.display = 'block';

            Quagga.init({
                inputStream: {
                    type: "LiveStream",
                    target: document.querySelector('#scanner-container'),
                    constraints: {
                        width: 640,
                        height: 480,
                        facingMode: "environment"
                    }
                },
                decoder: {
                    readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader"]
                }
            }, function(err) {
                if (err) {
                    console.log(err);
                    return;
                }
                console.log("Iniciando Quagga");
                Quagga.start(); // Inicia el escáner
                document.getElementById('stop-scan').style.display = 'inline';
            });

            Quagga.onDetected(function(result) {
                var code = result.codeResult.code;
                document.getElementById('serial').value = code; // Poner el código de barras en el input
                Quagga.stop(); // Detener el escáner cuando se detecta un código

                // Ocultar el contenedor del escáner después de la detección
                document.getElementById('scanner-container').style.display = 'none';
                document.getElementById('stop-scan').style.display = 'none';
                document.getElementById('scanner-container').innerHTML = ''; // Limpiar la cámara
            });
        });

        // Botón para detener la cámara manualmente
        document.getElementById('stop-scan').addEventListener('click', function() {
            Quagga.stop();
            document.getElementById('scanner-container').style.display = 'none';
            document.getElementById('scanner-container').innerHTML = ''; // Limpiar el contenedor del video
            this.style.display = 'none';
        });
    </script>
@stop
