document.addEventListener("DOMContentLoaded", function() {
    // Confirmar eliminación de imágenes
    const deleteButtons = document.querySelectorAll('.delete-form button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            const confirmed = confirm('¿Estás seguro de que deseas eliminar esta imagen?');
            if (!confirmed) {
                event.preventDefault();
            }
        });
    });

    // Validación de formulario de registro e inicio de sesión
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            const username = form.querySelector('#username');
            const password = form.querySelector('#password');

            if (username && password) {
                if (username.value.trim() === '' || password.value.trim() === '') {
                    alert('Todos los campos son obligatorios.');
                    event.preventDefault();
                }
            }
        });
    });

    // Validación de subida de imagen
    const uploadForm = document.querySelector('form[action="upload.php"]');
    
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(event) {
            const imageInput = uploadForm.querySelector('#image');
            if (imageInput.files.length === 0) {
                alert('Debe seleccionar una imagen para subir.');
                event.preventDefault();
            }
        });
    }
});
