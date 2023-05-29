// TODO, Lógica global

// * Referencia
function refModal() {
    const modal = document.querySelector("#modal1");
    if (!modal) {
        return;
    }

    M.Modal.init(modal);
}
document.addEventListener("DOMContentLoaded", refModal);

// * Limpiar modal
function limpiarModal() {
    const mensaje = document.getElementById("mensajeModal");
    if (!mensaje) {
        alert("No se pudo encontrar la referencia del mensaje");
        return;
    }

    mensaje.value = "";
}

// * AL enviar el email
document.addEventListener("click", function (event) {
    // * Modal
    if (event.target.matches(".modal-trigger")) {
        // Limpiamos
        limpiarModal();

        // Obtenemos y convertimos en JSON
        const usuario = JSON.parse(event.target.getAttribute("datos-usuario"));

        // ? Existe email
        if (!usuario.email) {
            alert("No se pudo encontrar el email del usuario");
            return;
        }

        // Nombre
        const nombre = `${usuario.nombre ?? "???"} ${
            usuario.apellido_paterno ?? "???"
        } ${usuario.apellido_materno ?? "???"}`;

        // Ponemos los datos
        document.getElementById("emailDestino").value = usuario.email;
        document.getElementById("destinatario").value = nombre;
    }
});
