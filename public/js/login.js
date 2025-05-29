// JavaScript para validaciones y efectos del formulario de login
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');
    
    // Elementos del formulario
    const correoInput = document.getElementById('correo');
    const passwordInput = document.getElementById('password');
    
    // Configurar validaciones en tiempo real
    setupRealTimeValidation();
    
    // Configurar envío del formulario
    setupFormSubmission();
    
    // Auto-hide de mensajes
    autoHideMessages();

    function setupRealTimeValidation() {
        // Validación del correo
        correoInput.addEventListener('blur', function() {
            validateField(this, validateEmail);
        });

        correoInput.addEventListener('input', function() {
            clearError(this);
        });

        // Validación de contraseña
        passwordInput.addEventListener('blur', function() {
            validateField(this, validatePassword);
        });

        passwordInput.addEventListener('input', function() {
            clearError(this);
        });

        // Agregar efecto focus
        [correoInput, passwordInput].forEach(input => {
            input.addEventListener('focus', function() {
                this.parentNode.classList.add('ring-2', 'ring-indigo-500');
            });

            input.addEventListener('blur', function() {
                this.parentNode.classList.remove('ring-2', 'ring-indigo-500');
            });
        });
    }

    function setupFormSubmission() {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateForm()) {
                showLoading();
                // Simular pequeño retraso para mostrar loading
                setTimeout(() => {
                    this.submit();
                }, 500);
            }
        });
    }

    function validateForm() {
        let isValid = true;
        
        // Validar todos los campos
        if (!validateField(correoInput, validateEmail)) isValid = false;
        if (!validateField(passwordInput, validatePassword)) isValid = false;
        
        return isValid;
    }

    function validateField(field, validationFunction) {
        const error = validationFunction(field.value);
        if (error) {
            showFieldError(field, error);
            return false;
        } else {
            clearError(field);
            return true;
        }
    }

    // Funciones de validación específicas
    function validateEmail(value) {
        if (!value.trim()) return 'El correo es obligatorio';
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) return 'Ingresa un correo válido';
        return null;
    }

    function validatePassword(value) {
        if (!value) return 'La contraseña es obligatoria';
        return null;
    }

    function showFieldError(field, message) {
        // Agregar clase de error al campo
        field.classList.add('border-red-500', 'ring-red-500');
        field.classList.remove('border-gray-300');
        
        // Mostrar mensaje de error
        const errorElement = field.parentNode.querySelector('.error-message') || 
                           field.parentNode.parentNode.querySelector('.error-message');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }
        
        // Agregar animación de shake
        field.classList.add('animate-shake');
        setTimeout(() => {
            field.classList.remove('animate-shake');
        }, 600);
    }

    function clearError(field) {
        // Remover clases de error
        field.classList.remove('border-red-500', 'ring-red-500');
        field.classList.add('border-gray-300');
        
        // Ocultar mensaje de error
        const errorElement = field.parentNode.querySelector('.error-message') || 
                           field.parentNode.parentNode.querySelector('.error-message');
        if (errorElement) {
            errorElement.classList.add('hidden');
        }
    }

    function showLoading() {
        submitBtn.disabled = true;
        btnText.classList.add('hidden');
        btnLoader.classList.remove('hidden');
    }

    function autoHideMessages() {
        // Auto-ocultar mensajes de éxito después de 5 segundos
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    successMessage.remove();
                }, 300);
            }, 5000);
        }

        // Auto-ocultar mensajes de error después de 8 segundos
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.opacity = '0';
                setTimeout(() => {
                    errorMessage.remove();
                }, 300);
            }, 8000);
        }
    }
});

// Función para alternar visibilidad de contraseña
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
    field.setAttribute('type', type);
    
    // Cambiar icono
    const button = field.nextElementSibling;
    const icon = button.querySelector('svg');
    
    if (type === 'text') {
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
        `;
    } else {
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
    }
}
