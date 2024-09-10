<!-- Edit Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Editar Orden</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Dynamically populated fields go here -->
                    <div class="form-group">
                        <label for="tecnico">Técnico</label>
                        <input type="text" name="tecnico" id="tecnico" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="text" name="fecha" id="fecha" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="horainicio">Hora de Inicio</label>
                        <input type="text" name="horainicio" id="horainicio" class="form-control" readonly>
                    </div>

                    <!-- Resto de los campos editables -->
                    <div class="form-group">
                        <label for="nomcliente">Nombre del Cliente</label>
                        <input type="text" name="nomcliente" id="nomcliente" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="celcliente">Celular</label>
                        <input type="tel" name="celcliente" id="celcliente" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="equipo">Equipo</label>
                        <input type="text" name="equipo" id="equipo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <input type="text" name="marca" id="marca" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="modelo">Modelo</label>
                        <input type="text" name="modelo" id="modelo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="serial">Serial</label>
                        <input type="text" name="serial" id="serial" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="cargador">Cargador</label>
                        <input type="text" name="cargador" id="cargador" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="bateria">Batería</label>
                        <input type="text" name="bateria" id="bateria" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="otros">Otros</label>
                        <input type="text" name="otros" id="otros" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="notacliente">Nota del Cliente</label>
                        <textarea name="notacliente" class="form-control" id="notacliente" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="notatecnico">Nota tecnico</label>
                        <textarea name="notatecnico" id="notatecnico" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="fechafin">Fecha fin</label>
                        <input type="date" name="fechafin" id="fechafin" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="valor">Valor</label>
                        <input type="text" name="valor" id="valor" class="form-control">
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
