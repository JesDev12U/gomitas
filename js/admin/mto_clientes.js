const $inputPassword = document.getElementById("password");

let objInputs = [
  {
    id: "usuario",
    type: "nombre-alfanumerico",
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
    `${this.dataset.url}controller/admin/gestor_clientes/AsyncMtoClientes.php`,
    "Confirmación",
    this.dataset.usuario === "cliente"
      ? "¿Está seguro de modificar sus datos?"
      : this.dataset.peticion === "UPDATE"
      ? "¿Está seguro de modificar los datos de este cliente?"
      : "¿Está seguro de que desea hacer el registro de este cliente?",
    this.dataset.usuario === "cliente" || this.dataset.peticion === "UPDATE"
      ? "¡Datos modificados correctamente!"
      : "¡Cliente registrado correctamente!",
    (json) => {
      if (json.usuario === "cliente") {
        document.querySelector(".account p").textContent =
          json.nuevos_datos.usuario;
        setTimeout(() => (location.href = this.dataset.url), 2000);
      } else {
        setTimeout(
          () =>
            (location.href = `${this.dataset.url}${this.dataset.url_admin}${this.dataset.url_gestor_clientes}`),
          2000
        );
      }
    }
  );
});
