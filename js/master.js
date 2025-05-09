const $loader = document.getElementById("loader");

function aparecerLoader() {
  $loader.classList.remove("hidden");
  document.body.style.overflowY = "hidden";
}

function desaparecerLoader() {
  $loader.classList.add("hidden");
  document.body.style.overflowY = "visible";
}

const verificarIndex = (site_url) =>
  location.href === `${site_url}index.php`
    ? (location.href = `${site_url}`)
    : location.href;

function sesion(json, site_url) {
  let jsonParsed = JSON.parse(json);
  if (jsonParsed.sesion.length !== 0) {
    const usuario = jsonParsed.sesion.usuario;
    const loggeado = jsonParsed.sesion.loggeado;
    const currentUrl = location.href;

    if (loggeado) {
      if (usuario !== "cliente") {
        // Para empleados o administradores, redirigir a su dashboard si no están en él
        if (!currentUrl.includes(`${site_url}${usuario}`)) {
          location.href = `${site_url}${usuario}`;
        }
      } else {
        // Para cliente, solo permitir site_url y site_url + "cliente/..."
        const isHome = currentUrl === site_url;
        const isClientePage = currentUrl.startsWith(`${site_url}cliente/`);
        if (!isHome && !isClientePage) {
          location.href = site_url;
        }
      }
    }
  } else {
    // Si no hay sesión, redirigir a site_url si está en rutas protegidas
    if (
      location.href.includes("empleado") ||
      location.href.includes("administrador") ||
      location.href.includes("cliente")
    ) {
      location.href = site_url;
    }
  }
}

const $password = document.getElementById("password");
const $togglePassword = document.getElementById("toggle-password");

if ($togglePassword) {
  $togglePassword.addEventListener("click", function () {
    const type = $password.type === "password" ? "text" : "password";
    $password.type = type;

    switch (type) {
      case "password":
        this.innerHTML = `<i class="fa-solid fa-eye"></i>`;
        break;
      case "text":
        this.innerHTML = `<i class="fa-solid fa-eye-slash"></i>`;
    }
  });
}

const $confirmPassword = document.getElementById("confirm-password");
const $toggleConfirmPassword = document.getElementById(
  "toggle-confirm-password"
);

if ($toggleConfirmPassword) {
  $toggleConfirmPassword.addEventListener("click", function () {
    const type = $confirmPassword.type === "password" ? "text" : "password";
    $confirmPassword.type = type;

    switch (type) {
      case "password":
        this.innerHTML = `<i class="fa-solid fa-eye"></i>`;
        break;
      case "text":
        this.innerHTML = `<i class="fa-solid fa-eye-slash"></i>`;
    }
  });
}

function formatearMXN(cantidad) {
  let numero = Number(cantidad);
  if (isNaN(numero)) return "$0.00 MXN";
  return (
    numero.toLocaleString("es-MX", {
      style: "currency",
      currency: "MXN",
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    }) + " MXN"
  );
}

function loadFormatearMXN() {
  document.querySelectorAll(".monetario").forEach(function (el) {
    // Obtener el valor numérico (puede estar como texto o atributo data-valor)
    let valor = el.dataset.valor || el.textContent;
    el.textContent = formatearMXN(valor);
  });
}

loadFormatearMXN();
