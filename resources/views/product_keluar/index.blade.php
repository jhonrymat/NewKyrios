@extends('adminlte::page')


@section('content')
    <div class="box box-success">

        <div class="box-header">
            <h3 class="box-title">Lista saliente</h3>
        </div>

        <div class="box-header">
            <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus"></i> Agregar nuevo producto saliente</a>
            <a href="{{ route('exportPDF.productKeluarAll') }}" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Exportar
                PDF</a>
            <a href="{{ route('exportExcel.productKeluarAll') }}" class="btn btn-primary"><i class="fa fa-file-excel-o"></i>
                Exportar Excel</a>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <table id="products-out-table" class="dt-container dt-empty-footer">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cliente</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>



    <div class="box box-success col-md-6">

        <div class="box-header">
            <h3 class="box-title">Exportar factura</h3>
        </div>

        {{-- <div class="box-header"> --}}
        {{-- <a onclick="addForm()" class="btn btn-primary" >Add Products Out</a> --}}
        {{-- <a href="{{ route('exportPDF.productKeluarAll') }}" class="btn btn-danger">Export PDF</a> --}}
        {{-- <a href="{{ route('exportExcel.productKeluarAll') }}" class="btn btn-success">Export Excel</a> --}}
        {{-- </div> --}}

        <!-- /.box-header -->
        <div class="box-body">
            <table id="invoice" class="dt-container dt-empty-footer">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cliente</th>
                        <th>Qty.</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice_data as $i)
                    <tr>
                        <td>{{ $i->id }}</td>
                        <td>{{ $i->product->nama }}</td>
                        <td>{{ $i->customer->nama }}</td>
                        <td>{{ $i->qty }}</td>
                        <td>{{ $i->tanggal }}</td>
                        <td>
                            <a href="{{ route('exportPDF.productKeluar', ['id' => $i->id]) }}" class="btn btn-sm btn-danger">Exportar Factura</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <!-- /.box-body -->
    </div>

    @include('product_keluar.form')
@endsection
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css">
    <!-- Log on to codeastro.com for more projects! -->
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection
@section('js')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>

    <!-- Log on to codeastro.com for more projects! -->
    <!-- InputMask -->
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- bootstrap color picker -->
    </script>
    <!-- bootstrap time picker -->
    <script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>

    <script>
        $(function() {
            $('#invoice').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                'processing': true,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                responsive: true,
            });
        });
    </script>

    <script>
        $(function() {

            //Date picker
            $('#tanggal').datepicker({
                autoclose: true,
                // dateFormat: 'yyyy-mm-dd'
            })


            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            })
        })
    </script>

    <script type="text/javascript">
        var table = $('#products-out-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('api.productsOut') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'products_name',
                    name: 'products_name'
                },
                {
                    data: 'customer_name',
                    name: 'customer_name'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
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

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Add Outgoing Products');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('admin/productsOut') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit Products');

                    $('#id').val(data.id);
                    $('#product_id').val(data.product_id);
                    $('#customer_id').val(data.customer_id);
                    $('#qty').val(data.qty);
                    $('#tanggal').val(data.tanggal);
                },
                error: function() {
                    alert("Nothing Data");
                }
            });
        }

        function deleteData(id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Estas seguro?',
                text: "No podrás revertir esto!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Sí, elimínalo!'
            }).then(function() {
                $.ajax({
                    url: "{{ url('admin/productsOut') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function(data) {
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error: function() {
                        swal({
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
                    if (save_method == 'add') url = "{{ url('admin/productsOut') }}";
                    else url = "{{ url('admin/productsOut') . '/' }}" + id;

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
                            swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error: function(data) {
                            swal({
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
@endsection
