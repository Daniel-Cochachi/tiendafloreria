<div class="py-16 md:py-24 px-4 bg-gradient-to-br from-[#FDF9F8] via-white to-[#F5EFEC]">
    <div class="max-w-3xl mx-auto">
        <!-- Tarjeta principal -->
        <div class="bg-white rounded-[2rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-gray-100 p-8 md:p-12 relative overflow-hidden">
            <!-- Elementos decorativos -->
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-coral/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-coral/5 rounded-full blur-3xl"></div>
            
            <!-- Encabezado -->
            <div class="text-center mb-12 relative">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-coral/10 rounded-full mb-6">
                    <i data-lucide="flower" class="w-8 h-8 text-coral"></i>
                </div>
                <h1 class="text-4xl font-serif text-charcoal mb-4">Crea tu Cuenta</h1>
                <p class="text-gray-500 text-sm max-w-md mx-auto">Únete a nuestra comunidad floral y disfruta de beneficios exclusivos y seguimiento de pedidos.</p>
            </div>

            <form method="POST" class="space-y-8 relative">
                <!-- Sección: Información Personal -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-2">
                        <span class="w-7 h-7 bg-charcoal text-white text-[10px] font-bold rounded-full flex items-center justify-center">01</span>
                        <h3 class="text-xs font-bold text-charcoal uppercase tracking-widest">Información Personal</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-charcoal/60 uppercase tracking-wider ml-1">Nombre *</label>
                            <input type="text" name="nombre" required 
                                   class="w-full px-5 py-3.5 bg-gray-50 border-transparent focus:border-coral focus:bg-white focus:ring-0 rounded-2xl text-sm transition-all outline-none" 
                                   placeholder="Tu nombre">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-charcoal/60 uppercase tracking-wider ml-1">Apellido</label>
                            <input type="text" name="apellido" 
                                   class="w-full px-5 py-3.5 bg-gray-50 border-transparent focus:border-coral focus:bg-white focus:ring-0 rounded-2xl text-sm transition-all outline-none" 
                                   placeholder="Tu apellido">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-charcoal/60 uppercase tracking-wider ml-1">Email *</label>
                            <input type="email" name="email" autocomplete="email" required 
                                   class="w-full px-5 py-3.5 bg-gray-50 border-transparent focus:border-coral focus:bg-white focus:ring-0 rounded-2xl text-sm transition-all outline-none" 
                                   placeholder="tu@email.com">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-charcoal/60 uppercase tracking-wider ml-1">Teléfono</label>
                            <input type="tel" name="telefono" 
                                   class="w-full px-5 py-3.5 bg-gray-50 border-transparent focus:border-coral focus:bg-white focus:ring-0 rounded-2xl text-sm transition-all outline-none" 
                                   placeholder="+51 900 000 000">
                        </div>
                    </div>
                </div>

                <!-- Sección: Identificación -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-2">
                        <span class="w-7 h-7 bg-charcoal text-white text-[10px] font-bold rounded-full flex items-center justify-center">02</span>
                        <h3 class="text-xs font-bold text-charcoal uppercase tracking-widest">Identificación</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-charcoal/60 uppercase tracking-wider ml-1">Tipo de Documento</label>
                            <select name="documento_tipo" class="w-full px-5 py-3.5 bg-gray-50 border-transparent focus:border-coral focus:bg-white focus:ring-0 rounded-2xl text-sm transition-all outline-none appearance-none cursor-pointer">
                                <option value="">Selecciona</option>
                                <option value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                                <option value="CE">Carné Extranjería</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-charcoal/60 uppercase tracking-wider ml-1">Número de Documento</label>
                            <input type="text" name="documento_numero" 
                                   class="w-full px-5 py-3.5 bg-gray-50 border-transparent focus:border-coral focus:bg-white focus:ring-0 rounded-2xl text-sm transition-all outline-none" 
                                   placeholder="Ej: 12345678">
                        </div>
                    </div>
                </div>

                <!-- Sección: Seguridad -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-2">
                        <span class="w-7 h-7 bg-charcoal text-white text-[10px] font-bold rounded-full flex items-center justify-center">03</span>
                        <h3 class="text-xs font-bold text-charcoal uppercase tracking-widest">Seguridad</h3>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-bold text-charcoal/60 uppercase tracking-wider ml-1">Contraseña *</label>
                        <input type="password" name="password" autocomplete="new-password" required 
                               class="w-full px-5 py-3.5 bg-gray-50 border-transparent focus:border-coral focus:bg-white focus:ring-0 rounded-2xl text-sm transition-all outline-none" 
                               placeholder="Mínimo 6 caracteres">
                    </div>
                </div>

                <!-- Términos -->
                <label class="flex items-start gap-4 cursor-pointer group pt-4">
                    <input type="checkbox" required class="w-5 h-5 mt-0.5 rounded-lg border-gray-200 text-coral focus:ring-coral/20 cursor-pointer transition-all">
                    <span class="text-xs text-gray-500 group-hover:text-charcoal transition-colors leading-relaxed">
                        Acepto los <a href="#" class="text-coral font-bold hover:underline">términos y condiciones</a> y la <a href="#" class="text-coral font-bold hover:underline">política de privacidad</a> de la tienda.
                    </span>
                </label>

                <!-- Botón de Registro -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-charcoal hover:bg-coral text-white font-bold py-4 rounded-xl text-xs uppercase tracking-[0.2em] transition-all transform active:scale-[0.98]">
                        Crear mi cuenta
                    </button>
                </div>

                <!-- Divisor -->
                <div class="relative py-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-100"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-white text-[10px] font-bold text-gray-400 uppercase tracking-widest">¿Ya eres parte?</span>
                    </div>
                </div>

                <!-- Link Login -->
                <p class="text-center text-sm font-medium text-gray-500">
                    <a href="<?php echo e(app_url('user/login')); ?>" class="text-coral font-bold hover:text-coral-dark transition-colors border-b border-coral/20 hover:border-coral">Inicia sesión aquí</a>
                </p>
            </form>
        </div>
        
        <!-- Volver a tienda -->
        <div class="mt-12 text-center">
            <a href="<?php echo e(app_url()); ?>" class="inline-flex items-center gap-2.5 text-[11px] font-bold text-gray-400 hover:text-charcoal transition-all uppercase tracking-[0.15em] group">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> 
                Volver a la tienda
            </a>
        </div>
    </div>
</div>


