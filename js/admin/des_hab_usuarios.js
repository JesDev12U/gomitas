function cargarDesHab() {
  const $btnDeshabilitar = document.querySelectorAll("#btn-deshabilitar");
  const $btnHabilitar = document.querySelectorAll("#btn-habilitar");

  $btnDeshabilitar.forEach(($btn) => {
    $btn.addEventListener("click", function () {
      const formData = new FormData();
      formData.append("id", this.dataset.id);
      formData.append("usuario", this.dataset.usuario);
      formData.append("operacion", "deshabilitar");
      asyncConfirmProcess(
        formData,
        `${this.dataset.url}controller/admin/AsyncDesHabUsuarios.php`,
        "Advertencia",
        this.dataset.usuario === "empleado"
          ? "¿Está seguro de deshabilitar este empleado?"
          : this.dataset.usuario === "cliente"
          ? "¿Está seguro de deshabilitar este cliente?"
          : this.dataset.usuario === "producto"
          ? "¿Está seguro de deshabilitar este producto?"
          : "¿Está seguro de deshabilitar este administrador?",
        this.dataset.usuario === "empleado"
          ? "¡Hecho! El empleado ha sido deshabilitado"
          : this.dataset.usuario === "cliente"
          ? "¡Hecho! El cliente ha sido deshabilitado"
          : this.dataset.usuario === "producto"
          ? "¡Hecho! El producto ha sido deshabilitado"
          : "¡Hecho! El administrador ha sido deshabilitado",
        () => {
          $btn.outerHTML = `<button class="btn btn-success" id="btn-habilitar" data-url="${$btn.dataset.url}" data-usuario="${$btn.dataset.usuario}" data-id="${$btn.dataset.id}">
                <i class="fa-solid fa-check"></i>
                  Habilitar
                </button>`;
          cargarDesHab();
        }
      );
    });
  });

  $btnHabilitar.forEach(($btn) => {
    $btn.addEventListener("click", function () {
      const formData = new FormData();
      formData.append("id", this.dataset.id);
      formData.append("usuario", this.dataset.usuario);
      formData.append("operacion", "habilitar");
      asyncConfirmProcess(
        formData,
        `${this.dataset.url}controller/admin/AsyncDesHabUsuarios.php`,
        "Advertencia",
        this.dataset.usuario === "empleado"
          ? "¿Está seguro de habilitar este empleado?"
          : this.dataset.usuario === "cliente"
          ? "¿Está seguro de habilitar este cliente?"
          : this.dataset.usuario === "producto"
          ? "¿Está seguro de habilitar este producto?"
          : "¿Está seguro de habilitar este administrador?",
        this.dataset.usuario === "empleado"
          ? "¡Hecho! El empleado ha sido habilitado"
          : this.dataset.usuario === "cliente"
          ? "¡Hecho! El cliente ha sido habilitado"
          : this.dataset.usuario === "producto"
          ? "¡Hecho! El producto ha sido habilitado"
          : "¡Hecho! El administrador ha sido habilitado",
        () => {
          $btn.outerHTML = `<button class="btn btn-danger" id="btn-deshabilitar" data-url="${$btn.dataset.url}" data-usuario="${$btn.dataset.usuario}" data-id="${$btn.dataset.id}">
                  <i class="fa-solid fa-ban"></i>
                  Deshabilitar
                </button>`;
          cargarDesHab();
        }
      );
    });
  });
}

cargarDesHab();
