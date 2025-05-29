<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Iniciar Sesión'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'shake': 'shake 0.6s cubic-bezier(.36,.07,.19,.97) both'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        shake: {
                            '10%, 90%': { transform: 'translate3d(-1px, 0, 0)' },
                            '20%, 80%': { transform: 'translate3d(2px, 0, 0)' },
                            '30%, 50%, 70%': { transform: 'translate3d(-4px, 0, 0)' },
                            '40%, 60%': { transform: 'translate3d(4px, 0, 0)' }
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <header class="bg-white shadow-lg">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-indigo-600">Sistema de Registro</h1>
                <div class="space-x-4">
                    <a href="?route=register" class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">Registro</a>
                    <a href="?route=login" class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">Iniciar Sesión</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-8">
        <section class="max-w-md mx-auto">
            <div class="bg-white rounded-xl shadow-2xl p-8 animate-fade-in">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Iniciar Sesión</h2>
                    <p class="text-gray-600">Accede a tu cuenta</p>
                </div>

                <!-- Mensajes de éxito -->
                <?php if (!empty($success)): ?>
                    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 animate-slide-up">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Mensajes de error -->
                <?php if (!empty($errors)): ?>
                    <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 animate-shake">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">Error:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="?route=login-process" method="POST" id="loginForm" class="space-y-6">
                    <!-- Campo Correo -->
                    <div class="form-group">
                        <label for="correo" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo Electrónico <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="correo" 
                            name="correo" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                            placeholder="ejemplo@correo.com"
                            required
                        >
                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="form-group">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="Tu contraseña"
                                required
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <!-- Botón Submit -->
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span id="btnText">Iniciar Sesión</span>
                        <span id="btnLoader" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Iniciando sesión...
                        </span>
                    </button>
                </form>

                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        ¿No tienes una cuenta? 
                        <a href="?route=register" class="text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
                            Regístrate aquí
                        </a>
                    </p>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white border-t mt-12">
        <div class="container mx-auto px-6 py-4">
            <p class="text-center text-gray-600">© 2025 Sistema de Registro. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="public/js/login.js"></script>
</body>
</html>
