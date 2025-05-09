<?php
require_once __DIR__ . "/../controller/renderProductosPrincipal.php";
?>

<nav class="navbar navbar-expand-lg gomitas-navbar mb-4 sticky-top">
  <div class="container">
    <div style="display: flex; width:100%; height: 100%;">
      <!-- Barra de búsqueda -->
      <div class="container mb-4">
        <div class="row justify-content-center">
          <div class="col-12 col-md-8">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Buscar productos..." id="mainSearchBar" readonly style="cursor:pointer;">
              <button class="btn btn-outline-success" type="button" id="openSearchModalBtn">
                <i class="fa-solid fa-magnifying-glass"></i> Buscar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Modal de búsqueda -->
<div class="modal fade gomitas-modal" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchModalLabel">Buscar productos</h5>
        <!-- Botón de cerrar personalizado para modal Minecraft -->
        <button type="button" class="btn-close minecraft-close" data-bs-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true" style="font-family: 'Press Start 2P', monospace; font-size: 1.2rem;">✖</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Escribe para buscar..." id="modalSearchInput" autofocus>
          <button class="btn btn-success" type="button" id="modalSearchBtn" data-url="<?php echo SITE_URL ?>">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </div>
        <div id="searchResults" class="row g-4">
          <!-- Aquí se mostrarán los productos encontrados -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Sección de Productos -->
<div class="container my-5">
  <h2 class="text-center mb-4">¡Disfruta de nuestras gomitas!</h2>
  <div class="row g-4">
    <?php
    renderProductosPrincipal($this->datos);
    ?>
  </div>
</div>