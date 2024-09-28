@extends('adminlte::page')

@section('title', 'List of Categories')


@section('content')
    <div class="box box-success">

        <div class="box-header">
            <h3 class="box-title">List of Categories</h3>
        </div>

        <div class="box-header">
            <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus"></i> Nueva categoria</a>
            <a href="{{ route('exportPDF.categoriesAll') }}" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Exportar
                PDF</a>
            <a href="{{ route('exportExcel.categoriesAll') }}" class="btn btn-primary"><i class="fa fa-file-excel-o"></i>
                Exportar Excel</a>
        </div>


        <!-- /.box-header -->
        <div class="box-body">
            <table id="categories-table" class="dt-container dt-empty-footer">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div><!-- Log on to codeastro.com for more projects! -->

    @include('categories.form')

@endsection

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css">
@stop
@section('js')
    {{-- <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} ">
    </script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} ">
    </script> --}}
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>

    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>

    {{-- <script> --}}
    {{-- $(function () { --}}
    {{-- $('#items-table').DataTable() --}}
    {{-- $('#example2').DataTable({ --}}
    {{-- 'paging'      : true, --}}
    {{-- 'lengthChange': false, --}}
    {{-- 'searching'   : false, --}}
    {{-- 'ordering'    : true, --}}
    {{-- 'info'        : true, --}}
    {{-- 'autoWidth'   : false --}}
    {{-- }) --}}
    {{-- }) --}}
    {{-- </script> --}}
    <script type="text/javascript">
        var table;
        $(document).ready(function() {
            table = $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('api.categories') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                responsive: true,
            });
        });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Add Categories');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('admin/categories') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Editar Categoria');

                    $('#id').val(data.id);
                    $('#name').val(data.name);
                },
                error: function() {
                    alert("No hay datos");
                }
            });
        }

        function deleteData(id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Sí, elimínalo!'
            }).then(function() {
                $.ajax({
                    url: "{{ url('admin/categories') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function(data) {
                        table.ajax.reload();
                        swal.fire({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error: function() {
                        swal.fire({
                            title: 'Oops...',
                            text: data.message,
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            });
        }

        $(function() {
            $('#modal-form form').validator().on('submit', function(e) {
                if (!e.isDefaultPrevented()) {
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('admin/categories') }}";
                    else url = "{{ url('admin/categories') . '/' }}" + id;

                    $.ajax({
                        url: url,
                        type: "POST",
                        //hanya untuk input data tanpa dokumen
                        //                      data : $('#modal-form form').serialize(),
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal.fire({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error: function(data) {
                            swal.fire({
                                title: 'Oops...',
                                text: data.message,
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@stop
