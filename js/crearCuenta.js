function handleInput(current, nextFieldId) {
  const submitButtonSecurityCodeForm = document.getElementById(
    "submitButtonSecurityCodeForm"
  );
  const inputs = document.querySelectorAll(".code-input");

  if (current.value.length === 1 && nextFieldId) {
    document.getElementById(nextFieldId).focus();
  }

  const allFilled = Array.from(inputs).every(
    (input) => input.value.trim() !== ""
  );

  submitButtonSecurityCodeForm.disabled = !allFilled;
}

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
    type: "password",
    spanError: "error-password",
  },
  {
    id: "confirm-password",
    type: "confirm-password",
    spanError: "error-confirm-password",
  },
];

validaciones(objInputs, "btn-send");

const $btnSend = document.getElementById("btn-send");

const $inputCodigoContainer = document.getElementById("input-codigo-container");
const $btnRegresarFormulario = document.getElementById(
  "btn-regresar-formulario"
);

async function sendCode(cb) {
  try {
    aparecerLoader();
    const formDataDatos = new FormData(document.getElementById("form-datos"));
    formDataDatos.append("operacion", "enviar_codigo");
    const response = await fetch(
      `${$btnSend.dataset.url}/controller/cliente/creacion_cuenta/AsyncCreacionCuenta.php`,
      {
        method: "POST",
        body: formDataDatos,
      }
    );

    if (!response.ok) {
      throw new Error("Hubo un problema para solicitar el código");
    }

    const json = await response.json();
    desaparecerLoader();
    if (json.result != 1) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: json.msg,
      });
    } else {
      cb();
    }
  } catch (err) {
    desaparecerLoader();
    console.error(err);
    Swal.fire({
      icon: "error",
      title: "Error",
      text: err,
    });
  }
}

$btnSend.addEventListener("click", function (e) {
  e.preventDefault();
  sendCode(() => {
    window.scroll(0, 0);
    setTimeout(() => {
      $inputCodigoContainer.classList.remove("hidden");
    }, 500);
  });
});

document
  .getElementById("resend-code-btn")
  .addEventListener("click", function (e) {
    e.preventDefault();
    sendCode(() => {
      Swal.fire({
        icon: "success",
        title: "Éxito",
        text: "Código reenviado correctamente",
      });
    });
  });

$btnRegresarFormulario.addEventListener("click", (e) => {
  e.preventDefault();
  $inputCodigoContainer.classList.add("hidden");
});

document
  .getElementById("submitButtonSecurityCodeForm")
  .addEventListener("click", (e) => {
    e.preventDefault();
    const code = Array.from(document.querySelectorAll(".code-input"))
      .map((input) => input.value)
      .join("");
    const formDataDatos = new FormData(document.getElementById("form-datos"));
    formDataDatos.append("operacion", "comprobar_codigo");
    formDataDatos.append("codigo", code);
    asyncConfirmProcess(
      formDataDatos,
      `${$btnSend.dataset.url}/controller/cliente/creacion_cuenta/AsyncCreacionCuenta.php`,
      "Advertencia",
      "¿Está seguro de crear su cuenta?",
      "Éxito",
      (_) => {
        setTimeout(
          () =>
            (location.href = `${$btnSend.dataset.url}${$btnSend.dataset.url_login}`),
          2000
        );
      }
    );
  });
