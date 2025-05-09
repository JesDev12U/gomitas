<div class="login-container">
  <div class="row w-75 mx-auto align-items-center">
    <!-- Imagen Lado Izquierdo -->
    <div class="col-md-6 d-flex justify-content-center align-items-center mb-4 mb-md-0">
      <img src="img/login_wallpaper.png" alt="Login Wallpaper" title="Login Wallpaper" id="img-checkpoint" />
    </div>

    <!-- Formulario Lado Derecho -->
    <div class="col-md-6 login-box shadow">
      <h2 class="text-center mb-4" id="title-login">Inicio de sesión</h2>
      <!-- Formulario -->
      <form id="form-login" data-url="<?php echo SITE_URL ?>">
        <!-- Campo Usuario -->
        <div class="mb-3">
          <label for="input-email" class="form-label"><i class="fa-solid fa-envelope"></i>&nbsp;Correo electrónico</label>
          <input id="input-email" type="email" class="form-control" name="email" placeholder="Ingresa tu correo electrónico" required autocomplete="username">
          <span id="error-email" class="span-errors hidden">Correo electrónico inválido</span>
        </div>

        <!-- Campo Contraseña -->
        <div class="mb-3">
          <label for="password" class="form-label"><i class="fa-solid fa-lock"></i>&nbsp;Contraseña</label>
          <div class="input-group">
            <input id="password" type="password" class="form-control" name="password" placeholder="Ingresa tu contraseña" required autocomplete="current-password">
            <button class="btn btn-outline-secondary" id="toggle-password" type="button" tabindex="-1">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span id="error-password" class="span-errors hidden">La contraseña no puede ser vacía</span>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me" checked>
          <label class="form-check-label" for="remember_me">
            Recuérdame
          </label>
        </div>
        <div class="d-grid gap-3" style="margin-bottom: 20px;">
          <button id="btn-iniciar-sesion" class="btn btn-practical" disabled>Iniciar sesión</button>
        </div>
        <div class="mb-3 text-end login-links">
          <a href="<?php echo SITE_URL . RUTA_CREAR_CUENTA ?>"><i class="fa-solid fa-user-plus"></i> ¿No tienes cuenta? Crea una</a>
        </div>
        <div class="mb-3 text-end login-links">
          <a href="<?php echo SITE_URL ?>recuperar-password"><i class="fa-solid fa-key"></i> ¿Haz olvidado la contraseña?</a>
        </div>
      </form>
    </div>
  </div>
</div>