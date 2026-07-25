document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formDescarga");
  const btnDescargar = document.getElementById("btnDescargarPDF");
  const infoUsuario = document.getElementById("infoUsuario");
  const descargarHidden = document.getElementById("descargarHidden");

  btnDescargar.addEventListener("click", () => {
    if (!btnDescargar.disabled) {
      descargarHidden.value = "1";
      form.submit();
    }
  });

  form.addEventListener("submit", async (e) => {
    if (descargarHidden.value === "1") {
      return;
    }

    e.preventDefault();

    const nac = document.getElementById("nacionalidad").value;
    const ced = document.getElementById("cedula").value;

    infoUsuario.innerHTML = "Verificando...";
    infoUsuario.className = "contenedor-mensaje mensaje-espera";
    btnDescargar.disabled = true;

    const formData = new FormData();
    formData.append("nacionalidad", nac);
    formData.append("cedula", ced);

    try {
      const respuesta = await fetch(
        "app/ajax/buscar_usuario.php",
        {
          method: "POST",
          body: formData,
        },
      );
      const datos = await respuesta.json();

      if (datos.existe) {
        infoUsuario.innerHTML = `<strong>Persona encontrada:</strong> ${datos.nombre}`;
        infoUsuario.className = "contenedor-mensaje alerta-exito";
        btnDescargar.disabled = false;
      } else {
        infoUsuario.innerHTML =
          "No se encontró ningún registro con esa cédula.";
        infoUsuario.className = "contenedor-mensaje alerta-error";
        btnDescargar.disabled = true;
      }
    } catch (error) {
      console.error("Error en la petición:", error);
      infoUsuario.innerHTML = "Hubo un problema al conectar con el servidor.";
      infoUsuario.className = "contenedor-mensaje alerta-error";
    }
  });
});
