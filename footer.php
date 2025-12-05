<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.4.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var alert = document.getElementById('customAlert');
        var btnClose = alert.querySelector('.btn-close');

        // Función para cerrar la alerta
        function cerrarAlerta() {
            alert.classList.remove('show');
        }

        // Cerrar la alerta al hacer clic en el botón de cierre
        btnClose.addEventListener('click', cerrarAlerta);

        // Mostrar la alerta al cargar la página
        alert.classList.add('show');

        // También puedes agregar un botón en el menú para mostrar/ocultar la alerta
        // Ejemplo:
        // var btnToggle = document.getElementById('btnToggle');
        // btnToggle.addEventListener('click', function() {
        //     alert.classList.toggle('show');
        // });
    });
</script>