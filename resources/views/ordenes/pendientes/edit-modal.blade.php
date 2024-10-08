<div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Editar Orden N°
                        <span id="ordenCodigoE"></span>
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
                                <label for="tecnicoE">Técnico</label>
                                <input type="text" name="tecnicoE" id="tecnicoE" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fechaE">Fecha</label>
                                <input type="text" name="fechaE" id="fechaE" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="horainicioE">Hora de Inicio</label>
                                <input type="text" name="horainicioE" id="horainicioE" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomclienteE">Nombre del Cliente</label>
                                <input type="text" name="nomclienteE" id="nomclienteE" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="celclienteE">Celular</label>
                                <input type="tel" name="celclienteE" id="celclienteE" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="equipoE">Equipo</label>
                                <input type="text" name="equipoE" id="equipoE" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="marcaE">Marca</label>
                                <input type="text" name="marcaE" id="marcaE" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="modeloE">Modelo</label>
                                <input type="text" name="modeloE" id="modeloE" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="serialE">Serial</label>
                                <input type="text" name="serialE" id="serialE" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cargadorE">Cargador</label>
                                <input type="text" name="cargadorE" id="cargadorE" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bateriaE">Batería</label>
                                <input type="text" name="bateriaE" id="bateriaE" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="otrosE">Otros</label>
                                <input type="text" name="otrosE" id="otrosE" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="product_image">Actualizar Imágenes del Producto</label>
                                <input type="file" name="product_image[]" class="form-control" accept="image/*" multiple>
                            </div>
                        </div>
                    </div>

                    <!-- Muestra las imágenes existentes -->
                    <div class="row">
                        <div class="col-md-12">
                            <label>Imágenes existentes:</label>
                            <div id="existingImagesContainer" class="d-flex flex-wrap">
                                <!-- Aquí se mostrarán las imágenes existentes en miniatura -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="notaclienteE">Nota del Cliente</label>
                                <textarea name="notaclienteE" id="notaclienteE" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="observacionesE">Observaciones</label>
                                <textarea name="observacionesE" id="observacionesE" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estadoE">Pasar a bodega</label>
                                <select name="estadoE" class="form-control">
                                    <option value="PENDIENTE">PENDIENTE</option>
                                    <option value="EN BODEGA">BODEGA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="valorE">Valor negociado</label>
                                <input type="number" name="valorE" id="valorE" class="form-control" required>
                            </div>
                        </div>
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
