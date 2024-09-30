<div class="modal fade" id="createOrderModal" tabindex="-1" role="dialog" aria-labelledby="createOrderTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('ordenes.store') }}" method="POST" id="createOrderForm" enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crear Nueva Orden</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <!-- Mostrar errores aquí -->
                    <div class="errors"></div>

                    <!-- canfiguración AdminLTE Select2 -->
                    {{-- @php
                        $config = [
                            'placeholder' => 'Seleccione una opción...',
                            'allowClear' => true,
                            'tags' => true, // Permite crear nuevas opciones
                        ];
                    @endphp --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tecnico">Técnico</label>
                                <input type="text" name="tecnico" class="form-control"
                                    value="{{ Auth::user()->name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="text" name="fecha" class="form-control" value="{{ now() }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-adminlte-select2 id="nomcliente" name="nomcliente" label="Cliente" igroup-size="sm"
                                    required multiple>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-gradient-red">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="celcliente">Celular cliente</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-danger">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input type="number" class="form-control" id="celcliente" name="celcliente"
                                        placeholder="" required>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-adminlte-select2 id="equipo" name="equipo" label="Equipo" igroup-size="sm"
                                    multiple>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-gradient-red">
                                            <i class="fas fa-desktop"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-adminlte-select2 id="marca" name="marca" label="Marca" igroup-size="sm"
                                    required multiple>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-gradient-red">
                                            <i class="fas fa-copyright"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-adminlte-select2 id="modelo" name="modelo" label="Modelo" igroup-size="sm"
                                    required multiple>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-gradient-red">
                                            <i class="fas fa-code"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-select2>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serial">Serial</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-danger">
                                    <i class="fas fa-barcode"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="serial" name="serial" placeholder=""
                                required>
                        </div>
                    </div>

                    <!-- Ocultar inicialmente el contenedor del escáner -->
                    <div id="scanner-container" style="display:none;"></div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cargador">Cargador</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-danger">
                                            <i class="fas fa-plug"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="cargador" name="cargador"
                                        placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bateria">bateria</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-danger">
                                            <i class="fas fa-car-battery"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="bateria" name="bateria"
                                        placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="otros">Otros</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-danger">
                                            <i class="fas fa-pencil-alt"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="otros" name="otros"
                                        placeholder="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="product_image">Imagen del Producto</label>
                                <input type="file" name="product_image" class="form-control" accept="image/*" capture="camera">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-adminlte-textarea name="notacliente" label="Nota del Cliente" rows=4
                                    igroup-size="sm" placeholder="Escriba una descripción..." required>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-gradient-red">
                                            <i class="fas fa-lg fa-file-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-adminlte-textarea name="observaciones" label="Observaciones" rows=4
                                    igroup-size="sm" placeholder="Escriba una observación..." required>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-gradient-red">
                                            <i class="fas fa-lg fa-file-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="valor">Valor negociado</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-danger">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <input type="number" class="form-control" id="valor" name="valor" placeholder=""
                                required>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Crear Orden</button>
                </div>
        </div>
    </div>
    </form>
</div>
</div>
</div>
