<?php

/**
 * Renderiza las gomitas para la página principal de forma dinámica.
 * @param array $productos Array de gomitas a mostrar.
 */

function renderProductosPrincipal($productos)
{
  $count = 0;
  if (empty($productos)) {
    echo '<div class="alert alert-info gomita-alert">¡No hay gomitas para mostrar!</div>';
    return;
  }
?>
  <div class="row gomitas-row">
    <?php foreach ($productos as $gomita): ?>
      <?php if ($gomita["estado"]): ?>
        <?php $count++ ?>
        <div class="col-12 col-sm-8 col-md-6 col-lg-4 mb-4">
          <div class="card gomita-card h-100 shadow-sm">
            <img src="<?php echo htmlspecialchars($gomita["foto_path"]) ?>" class="card-img-top gomita-img" alt="Gomita: <?php echo htmlspecialchars($gomita["nombre"]) ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title gomita-title"><?php echo htmlspecialchars($gomita["nombre"]) ?></h5>
              <div class="mt-auto" style="display: flex; flex-direction: column; justify-content: space-between; align-items:center">
                <span class="fw-bold gomita-precio">$ <?php echo htmlspecialchars($gomita["precio"]) ?></span>
                <button class="btn gomita-btn btn-sm btn-addcart" data-url="<?php echo SITE_URL ?>" data-url_login="<?= RUTA_LOGIN ?>" data-id_producto="<?php echo $gomita["id_producto"] ?>">
                  <i class="fa-solid fa-cart-shopping"></i>&nbsp;Añadir al carrito
                </button>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <?php
  if ($count === 0)
    echo '<div class="alert alert-info gomita-alert">¡No hay gomitas para mostrar!</div>';
  ?>
<?php
}
?>