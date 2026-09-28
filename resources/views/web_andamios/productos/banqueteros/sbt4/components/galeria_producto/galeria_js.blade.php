<script>
    function changeImage(src, thumb) {
        // Cambia la imagen principal
        document.getElementById('main-image').src = src;
        
        // Remover la clase "selected" de todas las miniaturas
        let thumbs = document.querySelectorAll('.gallery__thumb img');
        thumbs.forEach(t => t.classList.remove('selected'));

        // Agregar la clase "selected" a la miniatura activa
        thumb.classList.add('selected');
    }
</script>