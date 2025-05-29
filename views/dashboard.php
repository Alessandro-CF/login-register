<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Dashboard'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-indigo-600">Dashboard</h1>
                    <span class="text-gray-600">|</span>
                    <span class="text-gray-700">Bienvenido, <span class="font-semibold text-indigo-600"><?php echo htmlspecialchars($userName); ?></span></span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Badge de tipo de usuario -->
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        <?php echo $userType === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'; ?>">
                        <?php echo $userType === 'admin' ? 'Administrador' : 'Usuario'; ?>
                    </span>
                    
                    <!-- Botón de logout -->
                    <a href="?route=logout" 
                       onclick="return confirm('¿Estás seguro de que quieres cerrar sesión?')"
                       class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Cerrar Sesión</span>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-8">
        <!-- Cards de estadísticas -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total de usuarios -->
            <div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total de Usuarios</p>
                        <p class="text-3xl font-bold text-indigo-600"><?php echo $stats['total_users']; ?></p>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-green-500 text-sm font-medium">
                        +<?php echo $stats['today_users']; ?> hoy
                    </span>
                </div>
            </div>

            <!-- Usuarios regulares -->
            <div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in hover:shadow-xl transition-shadow duration-300" style="animation-delay: 0.1s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Usuarios Regulares</p>
                        <p class="text-3xl font-bold text-blue-600">
                            <?php 
                            $regularUsers = 0;
                            foreach($stats['user_types'] as $type) {
                                if($type['tipo_usuario'] === 'usuario') {
                                    $regularUsers = $type['count'];
                                    break;
                                }
                            }
                            echo $regularUsers;
                            ?>
                        </p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo $stats['total_users'] > 0 ? ($regularUsers / $stats['total_users']) * 100 : 0; ?>%"></div>
                    </div>
                </div>
            </div>

            <!-- Administradores -->
            <div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in hover:shadow-xl transition-shadow duration-300" style="animation-delay: 0.2s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Administradores</p>
                        <p class="text-3xl font-bold text-purple-600">
                            <?php 
                            $adminUsers = 0;
                            foreach($stats['user_types'] as $type) {
                                if($type['tipo_usuario'] === 'admin') {
                                    $adminUsers = $type['count'];
                                    break;
                                }
                            }
                            echo $adminUsers;
                            ?>
                        </p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: <?php echo $stats['total_users'] > 0 ? ($adminUsers / $stats['total_users']) * 100 : 0; ?>%"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gráfico y acciones rápidas -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Gráfico de distribución -->
            <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-up">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribución de Usuarios</h3>
                <div class="relative h-64">
                    <canvas id="userChart"></canvas>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-up" style="animation-delay: 0.1s">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Acciones Rápidas</h3>
                <div class="space-y-4">
                    <a href="?route=register" class="flex items-center p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors duration-200 group">
                        <div class="bg-indigo-500 p-2 rounded-lg group-hover:bg-indigo-600 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-800">Registrar Nuevo Usuario</p>
                            <p class="text-sm text-gray-600">Crear una nueva cuenta de usuario</p>
                        </div>
                    </a>

                    <div class="flex items-center p-4 bg-green-50 rounded-lg">
                        <div class="bg-green-500 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-800">Perfil Verificado</p>
                            <p class="text-sm text-gray-600">Tu cuenta está activa y verificada</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-yellow-50 rounded-lg">
                        <div class="bg-yellow-500 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-800">Información</p>
                            <p class="text-sm text-gray-600">Este es un sistema de demostración</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>        <!-- Información del usuario actual -->
        <section class="bg-white rounded-xl shadow-lg p-6 animate-fade-in">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tu Información</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="bg-indigo-100 p-2 rounded-full">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nombre</p>
                            <p class="font-medium text-gray-800"><?php echo htmlspecialchars($userName); ?></p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="bg-purple-100 p-2 rounded-full">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tipo de Usuario</p>
                            <p class="font-medium text-gray-800 capitalize"><?php echo $userType === 'admin' ? 'Administrador' : 'Usuario'; ?></p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="bg-green-100 p-2 rounded-full">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Última Conexión</p>
                            <p class="font-medium text-gray-800"><?php echo date('d/m/Y H:i'); ?></p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Estado</p>
                            <p class="font-medium text-green-600">Activo</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Lista de usuarios (solo para administradores) -->
        <?php if ($userType === 'admin' && !empty($allUsers)): ?>
        <section class="bg-white rounded-xl shadow-lg p-6 animate-fade-in mt-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Lista de Usuarios Registrados</h3>
                <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                    <?php echo count($allUsers); ?> usuarios
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">ID</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Nombre</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Correo</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Tipo</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Fecha de Registro</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($allUsers as $user): ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-3 px-4 text-sm text-gray-600">#<?php echo $user['id']; ?></td>
                            <td class="py-3 px-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <span class="text-indigo-600 font-semibold text-sm">
                                            <?php echo strtoupper(substr($user['nombre'], 0, 1)); ?>
                                        </span>
                                    </div>
                                    <span class="font-medium text-gray-800"><?php echo htmlspecialchars($user['nombre']); ?></span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600"><?php echo htmlspecialchars($user['correo']); ?></td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo $user['tipo_usuario'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'; ?>">
                                    <?php echo $user['tipo_usuario'] === 'admin' ? 'Administrador' : 'Usuario'; ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600">
                                <?php echo date('d/m/Y H:i', strtotime($user['fecha_creacion'])); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <footer class="bg-white border-t mt-12">
        <div class="container mx-auto px-6 py-4">
            <p class="text-center text-gray-600">© 2025 Sistema de Registro. Panel de administración.</p>
        </div>
    </footer>

    <script>
        // Configurar gráfico de distribución de usuarios
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('userChart').getContext('2d');
            
            const adminUsers = <?php echo $adminUsers; ?>;
            const regularUsers = <?php echo $regularUsers; ?>;
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Usuarios Regulares', 'Administradores'],
                    datasets: [{
                        data: [regularUsers, adminUsers],
                        backgroundColor: [
                            '#3B82F6', // Blue
                            '#8B5CF6'  // Purple
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        });
    </script>
</body>
</html>
