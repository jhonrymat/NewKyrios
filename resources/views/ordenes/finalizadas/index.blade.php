@extends('adminlte::page')

@section('plugins.Select2', true)

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
                                <th>Configuraciones</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css">
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
                        data: 'codigo',
                        name: 'codigo',
                        render: function(data, type, row) {
                            return `
                                <a href="/admin/orden/${data}/finalizados" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <a data-toggle="modal" data-target="#modal-edit-${data}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm deleteApp" data-appid="${data}" data-toggle="modal" data-target="#deleteConfirmationModal">
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
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>
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
@stop
