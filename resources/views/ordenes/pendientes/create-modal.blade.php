<div class="modal fade" id="createOrderModal" tabindex="-1" role="dialog" aria-labelledby="createOrderTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('ordenes.store') }}" method="POST" id="createOrderForm">
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
                    @php
                        $config = [
                            'placeholder' => 'Seleccione una opción...',
                            'allowClear' => true,
                            'tags' => true, // Permite crear nuevas opciones
                        ];
                    @endphp
                    <div class="form-group">
                        <label for="codigo">Orden N°</label>
                        <input type="text" id="nuevoCodigoInput" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="tecnico">Técnico</label>
                        <input type="text" name="tecnico" class="form-control" value="{{ Auth::user()->name }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="text" name="fecha" class="form-control" value="{{ now() }}" readonly>
                    </div>

                    <div class="form-group">
                        <x-adminlte-select2 class="nomcliente" id="nomcliente" name="nomcliente" label="Cliente"
                            igroup-size="sm" :config="$config" multiple required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-red">
                                    <i class="fas fa-users"></i>
                                </div>
                            </x-slot>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente }}">{{ $cliente }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="form-group">
                        <x-adminlte-select2 class="celcliente" id="celcliente" name="celcliente" label="Celular"
                            igroup-size="sm" :config="$config" multiple required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-red">
                                    <i class="fas fa-phone-square-alt"></i>
                                </div>
                            </x-slot>
                            @foreach ($telefonos as $telefono)
                                <option value="{{ $telefono }}">{{ $telefono }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="form-group">
                        <x-adminlte-select2 class="equipo" id="equipo" name="equipo" label="Equipo" igroup-size="sm"
                            :config="$config" multiple>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-red">
                                    <i class="fas fa-desktop"></i>
                                </div>
                            </x-slot>
                            @foreach ($equipos as $equipo)
                                <option value="{{ $equipo }}">{{ $equipo }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="form-group">
                        <x-adminlte-select2 class="marca" id="marca" name="marca" label="Marca" igroup-size="sm"
                            :config="$config" multiple required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-red">
                                    <i class="fas fa-copyright"></i>
                                </div>
                            </x-slot>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca }}">{{ $marca }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="form-group">
                        <x-adminlte-select2 class="modelo" id="modelo" name="modelo" label="Modelo" igroup-size="sm"
                            :config="$config" multiple required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-red">
                                    <i class="fas fa-code"></i>
                                </div>
                            </x-slot>
                            @foreach ($modelos as $modelo)
                                <option value="{{ $modelo }}">{{ $modelo }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="form-group">
                        <label for="serial">Serial</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-danger">
                                    <i class="fas fa-barcode"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="serial" name="serial" placeholder="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cargador">Cargador</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-danger">
                                    <i class="fas fa-plug"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="cargador" name="cargador" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bateria">bateria</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-danger">
                                    <i class="fas fa-car-battery"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="bateria" name="bateria" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="otros">Otros</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-danger">
                                    <i class="fas fa-pencil-alt"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="otros" name="otros" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <x-adminlte-textarea name="notacliente" label="Nota del Cliente" rows=4 igroup-size="sm"
                            placeholder="Escriba una descripción..." required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-red">
                                    <i class="fas fa-lg fa-file-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-textarea>
                    </div>
                    <div class="form-group">
                        <x-adminlte-textarea name="observaciones" label="Observaciones" rows=4 igroup-size="sm"
                            placeholder="Escriba una observación...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-red">
                                    <i class="fas fa-lg fa-file-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-textarea>
                    </div>

                    <div class="form-group">
                        <label for="valor">Valor negociado</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-danger">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="valor" name="valor" placeholder="">
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
