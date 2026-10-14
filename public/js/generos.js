// Validaciones del campo "Género" (casillas de selección múltiple)

// Obliga a elegir al menos un género al enviar el formulario
function validarGeneros(form) {
    var marcados = form.querySelectorAll('input[name="genero[]"]:checked');
    if (marcados.length === 0) {
        alert("Seleccione al menos un género");
        return false;
    }
    return true;
}

// Permite elegir como máximo 3 géneros
document.addEventListener("change", function (e) {
    if (e.target.name === "genero[]") {
        var marcados = e.target.form.querySelectorAll('input[name="genero[]"]:checked');
        if (marcados.length > 3) {
            e.target.checked = false;
            alert("Puede elegir máximo 3 géneros");
        }
    }
});
