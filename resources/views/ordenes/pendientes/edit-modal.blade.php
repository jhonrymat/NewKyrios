<div class="modal fade" id="modal-edit-{{ $orden->codigo }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="editForm-{{ $orden->codigo }}">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Editar Orden N° {{ $orden->codigo }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Mostrar errores aquí -->
                    <div class="errors"></div>

                    <div class="form-group">
                        <label for="tecnico">Técnico</label>
                        <input type="text" name="tecnico" class="form-control" value="{{ $orden->tecnico }}"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="text" name="fecha" class="form-control" value="{{ $orden->fecha }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="horainicio">Hora de Inicio</label>
                        <input type="text" name="horainicio" class="form-control" value="{{ $orden->horainicio }}"
                            readonly>
                    </div>

                    <!-- Resto de los campos editables -->
                    <div class="form-group">
                        <label for="nomcliente">Nombre del Cliente</label>
                        <input type="text" name="nomcliente" class="form-control" value="{{ $orden->nomcliente }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="celcliente">Celular</label>
                        <input type="tel" name="celcliente" class="form-control" value="{{ $orden->celcliente }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="equipo">Equipo</label>
                        <input type="text" name="equipo" class="form-control" value="{{ $orden->equipo }}" required>
                    </div>

                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <input type="text" name="marca" class="form-control" value="{{ $orden->marca }}" required>
                    </div>

                    <div class="form-group">
                        <label for="modelo">Modelo</label>
                        <input type="text" name="modelo" class="form-control" value="{{ $orden->modelo }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="serial">Serial</label>
                        <input type="text" name="serial" class="form-control" value="{{ $orden->serial }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="cargador">Cargador</label>
                        <input type="text" name="cargador" class="form-control" value="{{ $orden->cargador }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="bateria">Batería</label>
                        <input type="text" name="bateria" class="form-control" value="{{ $orden->bateria }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="otros">Otros</label>
                        <input type="text" name="otros" class="form-control" value="{{ $orden->otros }}" required>
                    </div>

                    <div class="form-group">
                        <label for="notacliente">Nota del Cliente</label>
                        <textarea name="notacliente" class="form-control" rows="4">{{ $orden->notacliente }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="4">{{ $orden->observaciones }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="valor">Valor</label>
                        <input type="text" name="valor" class="form-control" value="{{ $orden->valor }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Orden</button>
                </div>
            </form>
        </div>
    </div>
</div>
