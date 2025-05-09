const $inputPassword = document.getElementById("password");

let objInputs = [
  {
    id: "usuario",
    type: "nombre",
    spanError: "error-usuario",
  },
  {
    id: "email",
    type: "email",
    spanError: "error-email",
  },
  {
    id: "password",
    type: $inputPassword.dataset.valor === "1" ? "password" : "password-modify",
    spanError: "error-password",
  },
];

validaciones(objInputs, "btn-send");

const $btnSend = document.getElementById("btn-send");

$btnSend.addEventListener("click", function (e) {
  e.preventDefault();
  const formDataDatos = new FormData(document.getElementById("form-datos"));
  asyncConfirmProcess(
    formDataDatos,
    `${this.dataset.url}controller/admin/gestor_administradores/AsyncMtoAdministradores.php`,
    "Confirmación",
    !this.dataset.mantenimiento
      ? "¿Está seguro de modificar sus datos?"
      : this.dataset.peticion === "UPDATE"
      ? "¿Está seguro de modificar los datos de este administrador?"
      : "¿Está seguro de que desea hacer el registro de este administrador?",
    !this.dataset.mantenimiento || this.dataset.peticion === "UPDATE"
      ? "¡Datos modificados correctamente!"
      : "¡Administrador registrado correctamente!",
    (json) => {
      if (!$btnSend.dataset.mantenimiento) {
        if (json.nuevos_datos) {
          document.querySelector(".account p").textContent =
            json.nuevos_datos.usuario;
        }
      }
      if ($btnSend.dataset.mantenimiento === "1") {
        setTimeout(
          () =>
            (location.href = `${this.dataset.url}${this.dataset.url_admin}${this.dataset.url_gestor_administradores}`),
          2000
        );
      } else {
        setTimeout(
          () =>
            (location.href = `${this.dataset.url}${this.dataset.url_admin}`),
          2000
        );
      }
    }
  );
});
