function validaciones(objInputs, idButton) {
  //objInputs: [{ id, type, spanError }] Array de Objetos
  //Longitudes obtenidas directamente de la base de datos
  const lengthInputs = [
    { input: "phone", longitud: 10 },
    { input: "password", longitud: 16 },
    { input: "password-modify", longitud: 16 },
    { input: "nombre", longitud: 50 },
    { input: "email", longitud: 80 },
    { input: "apellido", longitud: 50 },
    { input: "zip_code", longitud: 5 },
    { input: "calle", longitud: 30 },
    { input: "numero_exterior", longitud: 10 },
    { input: "numero_interior", longitud: 10 },
  ];
  objInputs.forEach((obj) => {
    let $input = document.getElementById(obj.id);
    let $spanError = document.getElementById(obj.spanError);
    let isValidInput = false;
    $input.addEventListener("input", function () {
      for (const { input, longitud } of lengthInputs)
        if (obj.type === input) this.value = this.value.slice(0, longitud);

      isValidInput = checkValidInput(obj.type, this);
      if (isValidInput && $spanError) $spanError.classList.add("hidden");
      else if ($spanError) $spanError.classList.remove("hidden");

      // --- NUEVO: Si es password, revalida confirm-password ---
      if (obj.type === "password" || obj.type === "password-modify") {
        const confirmInput = document.getElementById("confirm-password");
        if (confirmInput) {
          confirmInput.dispatchEvent(new Event("input", { bubbles: true }));
        }
      }

      checkAllValid();
    });
  });

  function checkValidInput(type, input) {
    switch (type) {
      case "email":
        input.value = input.value
          .replace(/[^a-zA-Z0-9@.\-_]/g, "")
          .replace(/\.{2,}/g, ".") // Elimina puntos consecutivos
          .toLowerCase()
          .trim();
        return validator.isEmail(input.value);
      case "password": {
        input.value = input.value.replace(/\s+/g, "");
        // Solo valida longitud y que no esté vacío
        return input.value.length > 0 && input.value.length <= 16;
      }
      case "password-modify": {
        input.value = input.value.replace(/\s+/g, "");
        // Solo valida longitud (puede estar vacío si no es obligatorio)
        return input.value.length <= 16;
      }
      case "nombre":
        input.value = input.value
          .replace(/\s+/g, " ")
          .replace(/[^a-zA-ZñáéíóúÁÉÍÓÚ´\s]/g, "");
        return input.value.length !== 0;
      case "nombre-alfanumerico":
        input.value = input.value
          .replace(/\s+/g, " ")
          .replace(/[^a-zA-Z0-9ñáéíóúÁÉÍÓÚ´\s]/g, "");
        return input.value.length !== 0;
      case "apellido":
        input.value = input.value
          .replace(/\s+/g, " ")
          .replace(/[^a-zA-ZñáéíóúÁÉÍÓÚ´\s]/g, "");
        return input.value.length !== 0;
      case "phone":
        input.value = input.value.trim().replace(/\D/g, "");
        return (
          input.value.length > 0 &&
          input.value.length <= 10 &&
          validator.isMobilePhone(input.value, ["es-MX"])
        );
      case "text":
        return input.value.length !== 0;
      case "fecha":
        return validator.isDate(input.value, { format: "YYYY-MM-DD" });
      case "hora":
        return validator.isTime(input.value);
      case "zip_code":
        input.value = input.value.trim().replace(/\D/g, "");
        return input.value.length === 5;
      case "calle":
        input.value = input.value
          .replace(/\s+/g, " ")
          .replace(/[^a-zA-ZñáéíóúÁÉÍÓÚ´\s]/g, "");
        return input.value.length !== 0;
      case "numero_exterior":
        input.value = input.value
          .replace(/[^a-zA-Z0-9\s/]/g, "") // Quita caracteres no deseados
          .replace(/\s+/g, " ") // Unifica espacios múltiples
          .toUpperCase()
          .trim();
        // Acepta "S/N", "123", "123A", "45 B", "12/3"
        return (
          input.value.length !== 0 &&
          /^[A-Z]+[0-9]+$|^[0-9]+[A-Z]+$|^[0-9]+$|^S\/?N$/.test(input.value)
        );
      case "numero_interior":
        input.value = input.value
          .replace(/[^a-zA-Z0-9\s/]/g, "") // Quita caracteres no deseados
          .replace(/\s+/g, " ") // Unifica espacios múltiples
          .toUpperCase()
          .trim();
        return true;
      case "unidades":
        input.value = input.value.trim().replace(/\D/g, "");
        return input.value > 0 && input.value <= 9999999;

      case "unidades_flotantes": {
        // Guarda la posición del cursor
        const { selectionStart } = input;
        let val = input.value;
        // Elimina caracteres no numéricos ni punto
        val = val.replace(/[^0-9.]/g, "");
        // Permite solo un punto decimal (el primero)
        const firstDot = val.indexOf(".");
        if (firstDot !== -1) {
          // Solo deja el primer punto, elimina los demás
          val =
            val.slice(0, firstDot + 1) +
            val.slice(firstDot + 1).replace(/\./g, "");
        }
        // Solo actualiza el valor si cambió
        if (input.value !== val) {
          input.value = val;
          // Calcula nueva posición del cursor
          let newPos = selectionStart - (input.value.length - val.length);
          if (newPos < 0) newPos = 0;
          input.setSelectionRange(newPos, newPos);
        }
        let floatValue = parseFloat(input.value);
        return !isNaN(floatValue) && floatValue > 0 && floatValue <= 9999999;
      }

      case "confirm-password": {
        // Busca el input de password original (puede ser "password" o "password-modify")
        let passwordInput =
          document.getElementById("password") ||
          document.getElementById("password-modify");
        if (!passwordInput) return false;
        // Limpia espacios y limita longitud
        input.value = input.value.replace(/\s+/g, "").slice(0, 16);
        // Compara valores
        return (
          input.value.length > 0 &&
          input.value === passwordInput.value &&
          passwordInput.value.length > 0
        );
      }

      default:
        return true;
    }
  }

  function checkAllValid() {
    let allValid = objInputs.every((obj) => {
      let $input = document.getElementById(obj.id);
      return checkValidInput(obj.type, $input);
    });
    let $button = document.getElementById(idButton);
    $button.disabled = !allValid;
  }

  checkAllValid();
}
