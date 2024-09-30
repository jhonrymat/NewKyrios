<div class="modal fade" id="finalizarOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="finalizarForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Finalizar Orden N°
                        <span id="ordenCodigo"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Mostrar errores aquí -->
                    <div class="errors"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tecnico">Técnico</label>
                                <input type="text" name="tecnico" id="tecnico" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="text" name="fecha" id="fecha" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="horainicio">Hora de Inicio</label>
                                <input type="text" name="horainicio" id="horainicio" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomclienteFin">Nombre del Cliente</label>
                                <input type="text" name="nomclienteFin" id="nomclienteFin" class="form-control"
                                    required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="celcliente">Celular</label>
                                <input type="tel" name="celcliente" id="celcliente" class="form-control" required
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="equipoFin">Equipo</label>
                                <input type="text" name="equipoFin" id="equipoFin" class="form-control" required
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="marcaFin">Marca</label>
                                <input type="text" name="marcaFin" id="marcaFin" class="form-control" required
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="modeloFin">Modelo</label>
                                <input type="text" name="modeloFin" id="modeloFin" class="form-control" required
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="serial">Serial</label>
                                <input type="text" name="serial" id="serial" class="form-control" required
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cargador">Cargador</label>
                                <input type="text" name="cargador" id="cargador" class="form-control" required
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bateria">Batería</label>
                                <input type="text" name="bateria" id="bateria" class="form-control" required
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="otros">Otros</label>
                                <input type="text" name="otros" id="otros" class="form-control" required
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="notacliente">Nota del Cliente</label>
                                <textarea name="notacliente" id="notacliente" class="form-control" rows="4" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control" rows="4" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="notatecnico">Nota del tecnico</label>
                                <textarea name="notatecnico" id="notatecnico" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="valor">Valor Final</label>
                                <input type="number" name="valor" id="valor" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="fechafin">Fecha Fin</label>
                                <input type="text" name="fechafin" id="fechafin" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Finalizar Orden</button>
                </div>
            </form>
        </div>
    </div>
</div>
