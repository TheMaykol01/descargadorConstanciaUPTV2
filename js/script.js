document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formDescarga");
  const btnDescargar = document.getElementById("btnDescargarPDF");
  const infoUsuario = document.getElementById("infoUsuario");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const nac = document.getElementById("nacionalidad").value;
    const ced = document.getElementById("cedula").value;

    infoUsuario.innerHTML = "Verificando...";
    infoUsuario.className = "mensaje-espera";
    btnDescargar.disabled = true;

    try {
      const respuesta = await fetch(
        `php/buscar_usuario.php?nacionalidad=${nac}&cedula=${ced}`,
      );
      const datos = await respuesta.json();

      if (datos.existe) {
        infoUsuario.innerHTML = `<strong>Persona encontrada:</strong> ${datos.nombre}`;
        infoUsuario.className = "alerta-exito";

        btnDescargar.disabled = false;
      } else {
        infoUsuario.innerHTML =
          "No se encontró ningún registro con esa cédula.";
        infoUsuario.className = "alerta-error";
        btnDescargar.disabled = true;
      }
    } catch (error) {
      console.error("Error en la petición:", error);
      infoUsuario.innerHTML = "Hubo un problema al conectar con el servidor.";
      infoUsuario.className = "alerta-error";
    }
  });
});
