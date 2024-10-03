<!-- Modal para mostrar la imagen ampliada -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Imagen del Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" style="max-width: 100%; cursor: zoom-in;">
            </div>
            <div class="modal-footer">
                <!-- Botón para descargar la imagen -->
                <a id="downloadImage" href="#" download="product_image.jpg" class="btn btn-primary">Descargar Imagen</a>

                <!-- Botón para compartir la imagen -->
                <button id="shareImage" class="btn btn-secondary">Compartir Imagen</button>
            </div>
        </div>
    </div>
</div>
