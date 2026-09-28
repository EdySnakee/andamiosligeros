<script>
    function rastrearPaquete(event) {
        // Prevenir el comportamiento por defecto del formulario (no recargar la página)
        event.preventDefault();

        // Obtener el número de rastreo del input
        const numeroRastreo = document.querySelector('.rastreo-input').value;

        // Obtener el elemento <a> con la clase 'rastreo-btn'
        const enlaceRastreo = document.querySelector('.rastreo-btn');

        // Actualizar el atributo href con el número de rastreo
        if (numeroRastreo) {
            enlaceRastreo.href = `https://www.paquetexpress.com.mx/rastreo/${numeroRastreo}`;
            // Abrir el enlace en una nueva ventana
            window.open(enlaceRastreo.href, '_blank');
        } else {
            alert('Por favor, ingresa un número de rastreo válido.');
        }
    }
</script>
