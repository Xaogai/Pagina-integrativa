document.addEventListener('DOMContentLoaded', function () {
    const btnEditar = document.getElementById('btn-editar');
    const btnAceptar = document.getElementById('btn-aceptar-dialog');
    const editableInput = document.getElementById('editable-input');

    if (btnEditar) {
        btnEditar.addEventListener('click', function () {
            editableInput.value = '1';
            document.forms[0].submit();
        });
    }

    if (btnAceptar) {
        btnAceptar.addEventListener('click', function () {
            const mensaje = `<i class="fa-solid fa-circle-info"></i> ¿Deseas guardar los cambios?`;
            showCustomDialog(mensaje, "info", function () {
                const form = document.querySelector('form');

                    // Input oculto para que se envíe como si fuera un submit real
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'accion';
                    hiddenInput.value = 'aceptar';
                    form.appendChild(hiddenInput);

                    form.submit();
            });
        });
    } 
});