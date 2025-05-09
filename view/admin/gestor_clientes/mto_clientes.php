<div class="container">
  <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_GESTOR_CLIENTES ?>" class="btn btn-primary">
    <i class="fa-solid fa-arrow-left"></i>
  </a>
  <h1><?php echo $_SESSION["usuario"] === "cliente" ? "Configuración de la cuenta" : "Mantenimiento de clientes" ?></h1>
  <div id="formSection" class="mt-5">
    <div class="row">
      <!-- Formulario -->
      <div class="col">
        <h5 class="text-center mb-4">Información Personal</h5>
        <form id="form-datos">
          <input type="hidden" name="peticion" value="<?php echo $this->peticion ?>">
          <?php if (!is_null($this->id_cliente)) echo '<input type="hidden" name="id_cliente" value="' . $this->id_cliente . '" />' ?>
          <div class="mb-3">
            <label for="usuario" class="form-label"><i class="fa-solid fa-font"></i>&nbsp;Usuario</label>
            <input
              type="text"
              class="form-control"
              id="usuario"
              name="usuario"
              value="<?php echo is_null($this->id_cliente) ? "" : $this->usuario ?>"
              placeholder="<?php echo $_SESSION["usuario"] === "administrador" ? "Ingresa aquí el nombre del cliente" : "Ingresa aquí tu nombre" ?>"
              required />
            <span id="error-usuario" class="span-errors hidden">Usuario inválido</span>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label"><i class="fa-solid fa-envelope"></i>&nbsp;Correo electrónico</label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              value="<?php echo is_null($this->id_cliente) ? "" : $this->email ?>"
              placeholder="<?php echo $_SESSION["usuario"] === "administrador" ? "Ingresa aquí el correo electrónico del cliente" : "Ingresa aquí tu correo electrónico" ?>"
              required />
            <span id="error-email" class="span-errors hidden">Correo electrónico inválido</span>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label"><i class="fa-solid fa-lock"></i>&nbsp;Contraseña</label>
            <div class="input-group">
              <input
                data-valor="<?php echo is_null($this->id_cliente) ?>"
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="<?php echo $_SESSION["usuario"] === "administrador" ? "Ingresa aquí una contraseña para el cliente" : "Ingresa aquí una nueva contraseña si la deseas cambiar" ?>"
                <?php echo is_null($this->id_cliente) || $_SESSION["usuario"] === "cliente" ? "" : "disabled" ?> />
              <button class="btn btn-outline-secondary" id="toggle-password" type="button">
                <i class="fa-solid fa-eye"></i>
              </button>
            </div>
            <span id="error-password" class="span-errors hidden">Contraseña inválida</span>
          </div>
        </form>
      </div>
      <div class="container" style="margin-bottom: 50px;">
        <button
          type="submit"
          class="btn btn-success"
          id="btn-send"
          data-peticion="<?php echo $this->peticion ?>"
          data-url="<?php echo SITE_URL; ?>"
          data-usuario="<?php echo $_SESSION["usuario"] ?>"
          data-url_admin="<?php echo RUTA_ADMINISTRADOR ?>"
          data-url_gestor_clientes="<?php echo RUTA_GESTOR_CLIENTES ?>">
          <i class="fa-solid fa-check"></i>
          <?php echo is_null($this->id_cliente) ? "Registrar" : "Actualizar" ?>
        </button>
      </div>
    </div>
  </div>
</div>