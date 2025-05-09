async function actualizarCantidad(
  nuevaCantidad,
  id_producto,
  url,
  cbActualizarFrontend
) {
  try {
    aparecerLoader();
    const res = await fetch(
      `${url}/controller/cliente/carrito/AsyncActualizarCantidad.php`,
      {
        method: "POST",
        body: JSON.stringify({
          nuevaCantidad,
          id_producto,
        }),
      }
    );
    if (!res.ok) {
      throw new Error("Error para actualizar la cantidad del producto");
    }
    const json = await res.json();
    if (json.result !== 1) {
      desaparecerLoader();
      Swal.fire({
        icon: "error",
        title: "Error",
        text: json.msg,
      });
    } else {
      // Actualizar frontend
      cbActualizarFrontend(json);
      const $totalCompra = document.getElementById("total-compra");
      $totalCompra.textContent = formatearMXN(json.total);
      desaparecerLoader();
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

document.querySelectorAll(".btn-menos").forEach((btn) => {
  btn.addEventListener("click", () => {
    const $inputCantidad = document.getElementById(
      `input-cantidad${btn.dataset.id_producto}`
    );
    const $subtotal = document.getElementById(
      `subtotal${btn.dataset.id_producto}`
    );
    let nuevaCantidad = Number($inputCantidad.value) - 1;
    if (nuevaCantidad <= 0) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Cantidad inválida",
      });
      return;
    }
    actualizarCantidad(
      nuevaCantidad,
      btn.dataset.id_producto,
      btn.dataset.url,
      (json) => {
        $inputCantidad.value = json.producto.cantidad;
        $subtotal.textContent = formatearMXN(json.producto.total);
      }
    );
  });
});

document.querySelectorAll(".btn-mas").forEach((btn) => {
  btn.addEventListener("click", () => {
    const $inputCantidad = document.getElementById(
      `input-cantidad${btn.dataset.id_producto}`
    );
    const $subtotal = document.getElementById(
      `subtotal${btn.dataset.id_producto}`
    );
    let nuevaCantidad = Number($inputCantidad.value) + 1;
    if (nuevaCantidad <= 0) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Cantidad inválida",
      });
      return;
    }
    actualizarCantidad(
      nuevaCantidad,
      btn.dataset.id_producto,
      btn.dataset.url,
      (json) => {
        $inputCantidad.value = json.producto.cantidad;
        $subtotal.textContent = formatearMXN(json.producto.total);
      }
    );
  });
});

document.querySelectorAll(".btn-eliminar").forEach((btn) => {
  btn.addEventListener("click", async () => {
    asyncConfirmProcess(
      JSON.stringify({ id_producto: btn.dataset.id_producto }),
      `${btn.dataset.url}/controller/cliente/carrito/AsyncEliminarProducto.php`,
      "Eliminar producto",
      "¿Desea eliminar este producto de su carrito?",
      "¡Producto eliminado del carrito correctamente!",
      (json) => {
        if (!json.total) {
          document.querySelector(
            ".row"
          ).innerHTML = `<div class="alert alert-info">No hay productos para mostrar.</div>`;
        } else {
          tblDatos.row(btn.dataset.ordinal).remove().draw();
          const $totalCompra = document.getElementById("total-compra");
          $totalCompra.textContent = formatearMXN(json.total);
        }
      }
    );
  });
});

document
  .getElementById("btn-comprar")
  .addEventListener("click", async function (e) {
    e.preventDefault();
    asyncConfirmProcess(
      null,
      `${this.dataset.url}/controller/cliente/carrito/AsyncCompra.php`,
      "Advertencia",
      "¿Está seguro de hacer la compra?",
      "¡Hecho!",
      (_) => {
        setTimeout(() => (location.href = this.dataset.url), 2000);
      }
    );
  });
