function validarFormulario(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        let isValid = true;
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderColor = 'red';
                alert(`El campo ${input.name} es obligatorio.`);
            } else {
                input.style.borderColor = '';
            }
        });

        const correo = form.querySelector('input[type="email"]');
        if (correo && correo.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(correo.value)) {
                isValid = false;
                correo.style.borderColor = 'red';
                alert('Por favor, ingrese un correo válido.');
            }
        }

        const cantidad = form.querySelector('input[type="number"]');
        if (cantidad && cantidad.value && cantidad.value <= 0) {
            isValid = false;
            cantidad.style.borderColor = 'red';
            alert('La cantidad debe ser mayor a 0.');
        }

        if (isValid) {
            form.submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const formularios = ['login-form', 'agregar-usuario-form', 'editar-usuario-form', 
                        'agregar-necesidad-form', 'editar-necesidad-form', 
                        'agregar-donacion-form', 'editar-donacion-form'];
    formularios.forEach(id => {
        if (document.getElementById(id)) {
            validarFormulario(id);
        }
    });
});