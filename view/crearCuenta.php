<div class="container py-10" id="container-form-cuenta">
  <a href="<?php echo SITE_URL ?>" class="btn btn-outline-primary mb-4 rounded-pill shadow-sm">
    <i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar a la página principal
  </a>
  <div class="row justify-content-center">
    <div class="col-lg-15">
      <div class="card border-0 shadow-lg rounded-4">
        <div class="row g-0">
          <!-- Formulario -->
          <div class="col-lg-8 col-md-7 p-5">
            <h1 class="mb-4 fw-bold text-secondary">Crear tu cuenta</h1>
            <form id="form-datos" autocomplete="off">
              <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Usuario</label>
                <input type="text" class="form-control rounded-pill" id="usuario" name="usuario" placeholder="Usuario" required autocomplete="off" />
                <span id="error-usuario" class="span-errors hidden">Usuario inválido</span>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control rounded-pill" id="email" name="email" placeholder="Correo electrónico" required autocomplete="off" />
                <span id="error-email" class="span-errors hidden">Correo electrónico inválido</span>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="password" class="form-label">Contraseña</label>
                  <div class="input-group">
                    <input type="password" class="form-control rounded-pill rounded-end" id="password" name="password" placeholder="Contraseña" required>
                    <button class="btn btn-outline-secondary rounded-pill rounded-start" id="toggle-password" type="button" tabindex="-1">
                      <i class="fa-solid fa-eye"></i>
                    </button>
                  </div>
                  <span id="error-password" class="span-errors hidden">Contraseña inválida</span>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="confirm-password" class="form-label">Confirmar contraseña</label>
                  <div class="input-group">
                    <input type="password" class="form-control rounded-pill rounded-end" id="confirm-password" name="confirm-password" placeholder="Repite tu contraseña" required>
                    <button class="btn btn-outline-secondary rounded-pill rounded-start" id="toggle-confirm-password" type="button" tabindex="-1">
                      <i class="fa-solid fa-eye"></i>
                    </button>
                  </div>
                  <span id="error-confirm-password" class="span-errors hidden">Las contraseñas no coinciden</span>
                </div>
              </div>
              <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-success px-5 py-2 rounded-pill shadow" id="btn-send" data-url="<?php echo SITE_URL; ?>" data-url_login="<?php echo RUTA_LOGIN ?>">
                  <i class="fa-solid fa-check"></i>
                  Crear cuenta
                </button>
              </div>
            </form>
          </div>
          <!-- Fin Formulario -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Rediseño del contenedor de código de verificación -->
<div class="hidden d-flex align-items-center justify-content-center" id="input-codigo-container" style="z-index: 1050;">
  <div class="card shadow-lg border-0 rounded-4 p-4">
    <a href="#" id="btn-regresar-formulario" class="btn btn-outline-primary mb-4 rounded-pill shadow-sm w-auto">
      <i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar al formulario
    </a>
    <div class="text-center">
      <img src="<?php echo SITE_URL . 'img/email-verification.gif' ?>" alt="Verificación" style="width: 80px; margin-bottom: 1rem;">
      <h2 class="mb-2 fw-bold text-secondary">Verifica tu correo</h2>
      <p class="mb-4 text-muted small">
        Ingresa el código de 5 dígitos que enviamos a tu correo electrónico.
      </p>
      <form id="securityCodeForm" autocomplete="off">
        <input type="hidden" name="operacion" value="comprobar_codigo">
        <input type="hidden" name="url" value="<?php echo SITE_URL ?>">
        <div class="d-flex justify-content-center gap-2 mb-3">
          <input type="text" maxlength="1" class="form-control code-input text-center fs-3 rounded-3 border-2 shadow-sm" id="digit1" oninput="handleInput(this, 'digit2')" style="width: 48px; height: 56px;" autofocus />
          <input type="text" maxlength="1" class="form-control code-input text-center fs-3 rounded-3 border-2 shadow-sm" id="digit2" oninput="handleInput(this, 'digit3')" style="width: 48px; height: 56px;" />
          <input type="text" maxlength="1" class="form-control code-input text-center fs-3 rounded-3 border-2 shadow-sm" id="digit3" oninput="handleInput(this, 'digit4')" style="width: 48px; height: 56px;" />
          <input type="text" maxlength="1" class="form-control code-input text-center fs-3 rounded-3 border-2 shadow-sm" id="digit4" oninput="handleInput(this, 'digit5')" style="width: 48px; height: 56px;" />
          <input type="text" maxlength="1" class="form-control code-input text-center fs-3 rounded-3 border-2 shadow-sm" id="digit5" oninput="handleInput(this, '')" style="width: 48px; height: 56px;" />
        </div>
        <div id="error-codigo" class="text-danger small mb-2 d-none">Código incorrecto. Intenta de nuevo.</div>
        <button type="submit" id="submitButtonSecurityCodeForm" class="btn btn-success w-100 py-2 rounded-pill shadow" disabled>
          <i class="fa-solid fa-check"></i> Verificar Código
        </button>
        <div class="mt-3">
          <button type="button" class="btn btn-link text-decoration-none small" id="resend-code-btn">
            ¿No recibiste el código? <span class="fw-bold text-primary">Reenviar</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  #input-codigo-container {
    background: rgba(0, 0, 0, 0.35);
    /* Fondo oscuro semitransparente */
    transition: opacity 0.3s;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100vw;
    height: 100vh;
    z-index: 1050;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
  }

  #input-codigo-container .card {
    background: #fff;
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
    max-width: 350px;
    width: 100%;
    margin: 0 auto;
    position: relative;
    z-index: 2;
  }

  #input-codigo-container .code-input:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
  }

  #input-codigo-container .code-input::placeholder {
    color: #ccc;
  }
</style>