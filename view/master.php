<!DOCTYPE html>
<html lang="es">

<head>
  <base href="<?= SITE_URL ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GomiBike | <?= $ctrl->title ?></title>
  <!-- Bootstrap CSS -->
  <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables Core CSS -->
  <link href="node_modules/datatables.net-dt/css/dataTables.dataTables.min.css" rel="stylesheet" type="text/css">
  <!-- DataTables Bootstrap CSS -->
  <link rel="stylesheet" href="node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css" type="text/css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css" />
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css" />
  <!-- CSS principal -->
  <link rel="stylesheet" href="css/master.css" />
  <!-- CSS de cada menú de los usuarios (administradores) -->
  <link rel="stylesheet" href="css/menu.css">
  <!-- CSS de cada controlador -->
  <style>
    <?= $ctrl->renderCSS(); ?>
  </style>
</head>

<body>
  <div class="loader-container hidden" id="loader">
    <l-tail-chase
      size="40"
      speed="1.75"
      color="black"></l-tail-chase>
    <h3>Cargando, espere un momento...</h3>
  </div>
  <?php if (!isset($_COOKIE['cookie_consent'])): ?>
    <div id="cookie-consent-banner">
      <span>
        Este sitio utiliza cookies para mejorar su experiencia.
      </span>
      <div>
        <button id="accept-cookies">Aceptar</button>
        <button id="reject-cookies">Rechazar</button>
      </div>
    </div>
    <script>
      document.getElementById('accept-cookies').onclick = function() {
        document.cookie = "cookie_consent=1; path=/; max-age=" + (60 * 60 * 24 * 365);
        document.getElementById('cookie-consent-banner').style.display = 'none';
      };
      document.getElementById('reject-cookies').onclick = function() {
        document.cookie = "cookie_consent=0; path=/; max-age=" + (60 * 60 * 24 * 365);
        document.getElementById('cookie-consent-banner').style.display = 'none';
      };
    </script>
  <?php endif; ?>
  <nav class="navbar navbar-expand-lg shadow-sm fixed-top py-0 sticky-top">
    <div class="container-fluid">
      <a href="/" style="text-decoration: none;">
        <h4 id="title-main">GomiBike</h4>
      </a>
      <!-- Botón hamburguesa -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Contenido colapsable -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Opciones de navegación -->
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
          <?php if (is_array($ctrl->opciones) && count($ctrl->opciones) > 0): ?>
            <?php foreach ($ctrl->opciones as $opcion): ?>
              <?php
              $sesionIniciada = isset($_SESSION) && count($_SESSION) !== 0;
              // Mostrar todas las opciones excepto "login" si hay sesión iniciada
              // Mostrar solo "login" si NO hay sesión iniciada
              if (($sesionIniciada && $opcion['id'] !== "login") ||
                (!$sesionIniciada && $opcion['id'] === "login")
              ):
              ?>
                <li class="nav-item">
                  <a id='<?php echo $opcion['id'] ?>' class="nav-link px-3" <?php echo 'href="' . $opcion['href'] . '"' ?>>
                    <?php echo $opcion['nombre'] ?>
                  </a>
                </li>
              <?php endif ?>
            <?php endforeach ?>
          <?php endif ?>
        </ul>
        <!-- Usuario -->
        <div class="d-flex align-items-center ms-lg-4 mt-3 mt-lg-0">
          <?php
          if (isset($_SESSION) && (!isset($_SESSION['codigo']) && !isset($_SESSION['email'])) && count($_SESSION) !== 0) {
          ?>
            <div class="account ms-2 d-none d-md-block">
              <p class="fw-semibold" style="font-size:2em;"><?php echo $_SESSION["datos"]["usuario"] ?></p>
            </div>
            <!-- Botón de logout (opcional) -->
            <form action="<?php echo RUTA_CERRAR_SESION ?>" method="post" class="ms-3 mb-0 d-inline">
              <button type="submit" class="btn btn-outline-danger btn-sm" title="Cerrar sesión">
                <i class="fa-solid fa-right-from-bracket"></i>
              </button>
            </form>
          <?php } ?>
        </div>
      </div>
      <!-- <div class="d-flex">
        <a href="" class="btn btn-primary me-2"><i class="fas fa-shopping-cart"></i> Ver carrito</a>
        <a href="" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
      </div> -->
    </div>
  </nav>
  <div id="container-principal" class="container-fluid">
    <!-- Contenido de cada controlador -->
    <?= $ctrl->renderContent(); ?>
  </div>
  <!-- jQuery -->
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables Core JS -->
  <script src="node_modules/datatables.net/js/dataTables.min.js"></script>
  <!-- DataTables Buttons JS -->
  <script src="node_modules/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <!-- DataTables Buttons HTML5 JS -->
  <script src="node_modules/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <!-- DataTables Buttons Print JS -->
  <script src="node_modules/datatables.net-buttons/js/buttons.print.min.js"></script>
  <!-- DataTables Bootstrap JS -->
  <script src="node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
  <!-- SweetAlert JS -->
  <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
  <!-- Fontawesome JS -->
  <script src="node_modules/@fortawesome/fontawesome-free/js/all.min.js"></script>
  <!-- LDRS UiBall JS -->
  <script type="module" src="node_modules/ldrs/dist/auto/tailChase.js"></script>
  <!-- Validator JS -->
  <script src="node_modules/validator/validator.min.js"></script>
  <!-- JS del master -->
  <script src="js/master.js"></script>
  <!-- Validaciones -->
  <script src="js/validaciones.js"></script>
  <!-- Confirmación de procesos -->
  <script src="js/confirmacionProcesos.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      verificarIndex(`<?php echo SITE_URL ?>`);
      sesion(
        `<?php echo json_encode(["sesion" => $_SESSION]) ?>`,
        `<?php echo SITE_URL ?>`
      );
      return;
    });
  </script>
  <!-- JS para DataTable -->
  <script>
    var tblDatos = new DataTable(".tblDatos", {
      scrollY: 400,
      scrollX: true,
      scrollCollapse: true,
      paging: false,
      autoFill: true,
      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      },
      responsive: true,
    });
  </script>
  <!-- JS del controlador -->
  <script>
    <?php $ctrl->renderJS() ?>
  </script>
</body>

</html>