<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .form-container { animation: slideIn 0.6s ease-out; }
    .input-focus:focus { box-shadow: 0 0 0 3px rgba(210, 108, 97, 0.1); }
    .form-step { animation: fadeIn 0.4s ease-out; }
    .progress-bar {
        height: 4px;
        background: linear-gradient(90deg, #D26C61 0%, #D26C61 var(--progress, 33%), #E5E7EB var(--progress, 33%), #E5E7EB 100%);
        border-radius: 2px;
        transition: --progress 0.3s ease;
    }
</style>

<div class="min-h-screen flex items-center justify-center py-20 px-6 bg-gradient-to-br from-[#FDF9F8] via-[#FCF6F4] to-[#F5EFEC]">
    <div class="max-w-2xl w-full form-container">
        <!-- Decoración superior -->
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-coral opacity-5 rounded-full blur-3xl"></div>
        
        <div class="bg-white rounded-3xl shadow-2xl border-2 p-10 md:p-14 relative overflow-hidden" style="border-color: #F2E8E6;">
            <!-- Línea decorativa superior -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-transparent via-coral to-transparent"></div>
            
            <div class="text-center mb-12">
                <div class="inline-block mb-5 p-3.5 bg-coral/10 rounded-full">
                    <i data-lucide="flower" class="w-7 h-7 text-coral"></i>
                </div>
                <span class="font-script text-coral text-4xl block mb-2">Únete a nosotros</span>
                <h1 class="text-4xl font-serif text-charcoal">Crea tu Cuenta</h1>
                <p class="text-charcoal-light text-sm mt-3.5">Disfruta de beneficios exclusivos, descuentos especiales y seguimiento de tus pedidos.</p>
            </div>

            <form method="POST" class="space-y-6">
                <!-- Fila 1: Nombre y Apellido -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-step">
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2.5 flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-coral"></i> Nombre *
                        </label>
                        <input type="text" name="nombre" required 
                               class="w-full bg-gradient-to-r from-gray-50 to-gray-50 border-2 border-gray-200 py-3.5 px-5 text-sm outline-none input-focus transition-all rounded-xl" 
                               placeholder="Tu nombre">
                    </div>
                    <div class="form-step">
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2.5">Apellido</label>
                        <input type="text" name="apellido" 
                               class="w-full bg-gradient-to-r from-gray-50 to-gray-50 border-2 border-gray-200 py-3.5 px-5 text-sm outline-none input-focus transition-all rounded-xl" 
                               placeholder="Tu apellido">
                    </div>
                </div>

                <!-- Email -->
                <div class="form-step">
                    <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2.5 flex items-center gap-2">
                        <i data-lucide="mail" class="w-4 h-4 text-coral"></i> Email *
                    </label>
                    <input type="email" name="email" autocomplete="email" required 
                           class="w-full bg-gradient-to-r from-gray-50 to-gray-50 border-2 border-gray-200 py-3.5 px-5 text-sm outline-none input-focus transition-all rounded-xl" 
                           placeholder="tu@email.com">
                </div>

                <!-- Contraseña -->
                <div class="form-step">
                    <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2.5 flex items-center gap-2">
                        <i data-lucide="lock" class="w-4 h-4 text-coral"></i> Contraseña *
                    </label>
                    <input type="password" name="password" autocomplete="new-password" required 
                           class="w-full bg-gradient-to-r from-gray-50 to-gray-50 border-2 border-gray-200 py-3.5 px-5 text-sm outline-none input-focus transition-all rounded-xl" 
                           placeholder="Mínimo 6 caracteres">
                    <p class="text-xs text-gray-400 mt-2 flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-green-500"></i>
                        Tu contraseña está protegida
                    </p>
                </div>

                <!-- Teléfono y Tipo de Documento -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-step">
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2.5 flex items-center gap-2">
                            <i data-lucide="phone" class="w-4 h-4 text-coral"></i> Teléfono
                        </label>
                        <input type="tel" name="telefono" 
                               class="w-full bg-gradient-to-r from-gray-50 to-gray-50 border-2 border-gray-200 py-3.5 px-5 text-sm outline-none input-focus transition-all rounded-xl" 
                               placeholder="+51 900 000 000">
                    </div>
                    <div class="form-step">
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2.5 flex items-center gap-2">
                            <i data-lucide="id-card" class="w-4 h-4 text-coral"></i> Tipo Doc.
                        </label>
                        <select name="documento_tipo" class="w-full bg-gradient-to-r from-gray-50 to-gray-50 border-2 border-gray-200 py-3.5 px-5 text-sm outline-none input-focus transition-all rounded-xl appearance-none cursor-pointer" 
                                style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'%23666\' height=\'24\' viewBox=\'0 0 24 24\' width=\'24\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>'); background-repeat: no-repeat; background-position: right 0.7em center; background-size: 1.5em 1.5em; padding-right: 2.5rem;">
                            <option value="">Selecciona</option>
                            <option value="DNI">DNI</option>
                            <option value="RUC">RUC</option>
                            <option value="CE">Carné Extranjería</option>
                            <option value="PAS">Pasaporte</option>
                        </select>
                    </div>
                </div>

                <!-- Número de Documento -->
                <div class="form-step">
                    <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2.5 flex items-center gap-2">
                        <i data-lucide="document" class="w-4 h-4 text-coral"></i> Número de Documento
                    </label>
                    <input type="text" name="documento_numero" 
                           class="w-full bg-gradient-to-r from-gray-50 to-gray-50 border-2 border-gray-200 py-3.5 px-5 text-sm outline-none input-focus transition-all rounded-xl" 
                           placeholder="Ej: 12345678">
                </div>

                <!-- Términos -->
                <label class="flex items-start gap-3 mt-8 cursor-pointer group">
                    <input type="checkbox" required class="w-5 h-5 mt-0.5 rounded border-2 border-gray-300 cursor-pointer accent-coral flex-shrink-0">
                    <span class="text-xs text-charcoal-light group-hover:text-charcoal transition-colors leading-relaxed">
                        Acepto los <a href="#" class="text-coral font-bold hover:underline">términos y condiciones</a> y la <a href="#" class="text-coral font-bold hover:underline">política de privacidad</a>
                    </span>
                </label>

                <!-- Botón de Registro -->
                <button class="w-full bg-gradient-to-r from-charcoal to-charcoal hover:from-coral hover:to-coral-dark text-white py-4 rounded-xl text-sm font-bold uppercase tracking-widest transition-all shadow-lg mt-8 hover:shadow-xl transform hover:-translate-y-0.5" type="submit">
                    <span class="flex items-center justify-center gap-2">
                        Crear Cuenta 
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </span>
                </button>

                <!-- Separador -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t-2 border-gray-100"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 bg-white text-gray-500">¿Ya tienes cuenta?</span>
                    </div>
                </div>

                <!-- Link Login -->
                <p class="text-center text-xs text-charcoal-light mt-6">
                    <a href="<?php echo e(app_url('user/login')); ?>" class="text-coral font-bold uppercase tracking-widest hover:text-coral/80 transition-colors inline-block">Inicia sesión aquí</a>
                </p>
            </form>
        </div>
        
        <!-- Volver a tienda -->
        <div class="mt-10 text-center">
            <a href="<?php echo e(app_url()); ?>" class="text-xs font-bold text-gray-400 hover:text-coral uppercase tracking-widest transition-colors inline-flex items-center gap-2 group">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 group-hover:-translate-x-1 transition-transform"></i> 
                <span>Volver a la tienda</span>
            </a>
        </div>
    </div>
</div>
