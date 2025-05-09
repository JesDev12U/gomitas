let objInputs = [
  {
    id: "nombre",
    type: "nombre-alfanumerico",
    spanError: "error-nombre",
  },
  {
    id: "precio",
    type: "unidades_flotantes",
    spanError: "error-precio",
  },
  {
    id: "cantidad",
    type: "unidades",
    spanError: "error-cantidad",
  },
];

validaciones(objInputs, "btn-send");

const $fotoProducto = document.getElementById("foto-producto");
const $formDataFoto = new FormData();
const $btnSend = document.getElementById("btn-send");
const $fotoFile = document.getElementById("foto-file");

$fotoFile.addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (file) {
    const urlTemporal = URL.createObjectURL(file);
    $fotoProducto.src = urlTemporal;

    // Limpieza de la URL temporal cuando ya no se necesite
    $fotoFile.onload = () => URL.revokeObjectURL(urlTemporal);
    $formDataFoto.append("foto_path", file, file.name);
  }
});

$btnSend.addEventListener("click", function (e) {
  e.preventDefault();
  const formDataDatos = new FormData(document.getElementById("form-datos"));
  for (let [key, value] of $formDataFoto.entries()) {
    formDataDatos.append(key, value);
  }

  if (
    formDataDatos.getAll("foto_path").length !== 0 ||
    this.dataset.peticion === "UPDATE"
  ) {
    asyncConfirmProcess(
      formDataDatos,
      `${this.dataset.url}controller/admin/gestor_productos/AsyncMtoProductos.php`,
      "Confirmación",
      this.dataset.peticion === "UPDATE"
        ? "¿Está seguro de modificar los datos de este producto?"
        : "¿Está seguro de que desea hacer el registro de este producto?",
      this.dataset.peticion === "UPDATE"
        ? "¡Datos modificados correctamente!"
        : "¡Producto registrado correctamente!",
      (json) => {
        setTimeout(
          () =>
            (location.href = `${this.dataset.url}${this.dataset.url_administrador}${this.dataset.url_gestor_productos}`),
          2000
        );
      }
    );
  } else {
    Swal.fire({
      icon: "error",
      title: "¡Error!",
      text: "Tienes que subir una foto para seguir con el registro",
    });
  }
});
