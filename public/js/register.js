// JavaScript para validaciones y efectos del formulario de registro
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');
    
    // Elementos del formulario
    const nombreInput = document.getElementById('nombre');
    const correoInput = document.getElementById('correo');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const tipoUsuarioSelect = document.getElementById('tipo_usuario');
    
    // Configurar validaciones en tiempo real
    setupRealTimeValidation();
    
    // Configurar indicador de fortaleza de contraseña
    setupPasswordStrength();
    
    // Configurar envío del formulario
    setupFormSubmission();
    
    // Auto-hide de mensajes
    autoHideMessages();

    function setupRealTimeValidation() {
        // Validación del nombre
        nombreInput.addEventListener('blur', function() {
            validateField(this, validateNombre);
        });

        nombreInput.addEventListener('input', function() {
            clearError(this);
        });

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
            updatePasswordStrength(this.value);
        });

        // Validación de confirmación de contraseña
        confirmPasswordInput.addEventListener('blur', function() {
            validateField(this, validateConfirmPassword);
        });

        confirmPasswordInput.addEventListener('input', function() {
            clearError(this);
        });

        // Validación del tipo de usuario
        tipoUsuarioSelect.addEventListener('change', function() {
            validateField(this, validateTipoUsuario);
        });
    }

    function setupPasswordStrength() {
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');

        function updatePasswordStrength(password) {
            const strength = calculatePasswordStrength(password);
            
            // Actualizar barra de progreso
            strengthBar.style.width = strength.percentage + '%';
            strengthBar.className = `h-2 rounded-full transition-all duration-300 ${strength.colorClass}`;
            
            // Actualizar texto
            strengthText.textContent = strength.text;
            strengthText.className = `text-xs mt-1 ${strength.textClass}`;
        }

        window.updatePasswordStrength = updatePasswordStrength;
    }

    function calculatePasswordStrength(password) {
        if (password.length === 0) {
            return {
                percentage: 0,
                colorClass: 'bg-gray-300',
                textClass: 'text-gray-500',
                text: 'Ingresa una contraseña'
            };
        }

        let score = 0;
        const checks = {
            length: password.length >= 8,
            lowercase: /[a-z]/.test(password),
            uppercase: /[A-Z]/.test(password),
            numbers: /\d/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        // Calcular puntuación
        if (checks.length) score += 20;
        if (checks.lowercase) score += 20;
        if (checks.uppercase) score += 20;
        if (checks.numbers) score += 20;
        if (checks.special) score += 20;

        // Determinar nivel de fortaleza
        if (score < 40) {
            return {
                percentage: score,
                colorClass: 'bg-red-500',
                textClass: 'text-red-500',
                text: 'Muy débil'
            };
        } else if (score < 60) {
            return {
                percentage: score,
                colorClass: 'bg-orange-500',
                textClass: 'text-orange-500',
                text: 'Débil'
            };
        } else if (score < 80) {
            return {
                percentage: score,
                colorClass: 'bg-yellow-500',
                textClass: 'text-yellow-500',
                text: 'Regular'
            };
        } else if (score < 100) {
            return {
                percentage: score,
                colorClass: 'bg-blue-500',
                textClass: 'text-blue-500',
                text: 'Fuerte'
            };
        } else {
            return {
                percentage: 100,
                colorClass: 'bg-green-500',
                textClass: 'text-green-500',
                text: 'Muy fuerte'
            };
        }
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
        if (!validateField(nombreInput, validateNombre)) isValid = false;
        if (!validateField(correoInput, validateEmail)) isValid = false;
        if (!validateField(passwordInput, validatePassword)) isValid = false;
        if (!validateField(confirmPasswordInput, validateConfirmPassword)) isValid = false;
        if (!validateField(tipoUsuarioSelect, validateTipoUsuario)) isValid = false;
        
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
    function validateNombre(value) {
        if (!value.trim()) return 'El nombre es obligatorio';
        if (value.trim().length < 2) return 'El nombre debe tener al menos 2 caracteres';
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value)) return 'El nombre solo puede contener letras y espacios';
        return null;
    }

    function validateEmail(value) {
        if (!value.trim()) return 'El correo es obligatorio';
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) return 'Ingresa un correo válido';
        return null;
    }

    function validatePassword(value) {
        if (!value) return 'La contraseña es obligatoria';
        if (value.length < 6) return 'La contraseña debe tener al menos 6 caracteres';
        return null;
    }

    function validateConfirmPassword(value) {
        if (!value) return 'Confirma tu contraseña';
        if (value !== passwordInput.value) return 'Las contraseñas no coinciden';
        return null;
    }

    function validateTipoUsuario(value) {
        if (!value) return 'Selecciona un tipo de usuario';
        if (!['admin', 'usuario'].includes(value)) return 'Tipo de usuario no válido';
        return null;
    }

    function showFieldError(field, message) {
        // Agregar clase de error al campo
        field.classList.add('border-red-500', 'ring-red-500');
        field.classList.remove('border-gray-300');
        
        // Mostrar mensaje de error
        const errorElement = field.parentNode.querySelector('.error-message');
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
        const errorElement = field.parentNode.querySelector('.error-message');
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
