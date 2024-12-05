  // JavaScript para cambiar el fondo del navbar cuando se hace scroll
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar-custom');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled'); // Aplica la clase cuando se hace scroll
    } else {
        navbar.classList.remove('scrolled'); // Elimina la clase cuando se vuelve a la parte superior
    }
});



// Mostrar boton de limpiar filtros
document.addEventListener("DOMContentLoaded", function() {
    const queryInput = document.getElementById('query');
    const categoriaSelect = document.getElementById('categoria');
    const ordenarSelect = document.getElementById('ordenar_por');
    const btnLimpiar = document.getElementById('btnLimpiar');

    // Función para verificar si hay datos en los filtros
    function verificarFiltros() {
        const queryValue = queryInput.value.trim();
        const categoriaValue = categoriaSelect.value.trim();
        const ordenarValue = ordenarSelect.value.trim();

        if (queryValue || categoriaValue || ordenarValue) {
            btnLimpiar.classList.remove('d-none'); // Mostrar el botón
        } else {
            btnLimpiar.classList.add('d-none'); // Ocultar el botón
        }
    }

    // Llamar a la función al cargar la página
    verificarFiltros();

    // Detectar cambios en los campos
    queryInput.addEventListener('input', verificarFiltros);
    categoriaSelect.addEventListener('change', verificarFiltros);
    ordenarSelect.addEventListener('change', verificarFiltros);
});