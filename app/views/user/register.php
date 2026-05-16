<div class="min-h-screen flex items-center justify-center py-20 px-6 bg-[#FDF9F8]">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-card border p-10 md:p-12" style="border-color: #F2E8E6;">
            <div class="text-center mb-10">
                <span class="font-script text-coral text-3xl block mb-2">Únete a nosotros</span>
                <h1 class="text-3xl font-serif text-charcoal">Crea tu Cuenta</h1>
                <p class="text-charcoal-light text-sm mt-2">Disfruta de beneficios exclusivos y seguimiento de pedidos.</p>
            </div>

            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Nombre *</label>
                        <input type="text" name="nombre" required class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-xl" style="border-color: #E5E7EB;">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Apellido</label>
                        <input type="text" name="apellido" class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-xl" style="border-color: #E5E7EB;">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Email *</label>
                    <input type="email" name="email" autocomplete="email" required class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-xl" style="border-color: #E5E7EB;">
                </div>

                <div>
                    <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Contraseña *</label>
                    <input type="password" name="password" autocomplete="new-password" required class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-xl" style="border-color: #E5E7EB;" placeholder="Mínimo 6 caracteres">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Teléfono</label>
                        <input type="tel" name="telefono" class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-xl" style="border-color: #E5E7EB;">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Tipo Doc.</label>
                        <select name="documento_tipo" class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-xl appearance-none" style="border-color: #E5E7EB;">
                            <option value="">Selecciona</option>
                            <option value="DNI">DNI</option>
                            <option value="RUC">RUC</option>
                            <option value="CE">CE</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Número de Documento</label>
                    <input type="text" name="documento_numero" class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-xl" style="border-color: #E5E7EB;">
                </div>

                <button class="w-full bg-charcoal hover:bg-coral text-white py-4 rounded-xl text-sm font-bold uppercase tracking-widest transition-all shadow-lg mt-4" type="submit">
                    Registrarme <i data-lucide="user-plus" class="w-4 h-4 inline ml-2"></i>
                </button>

                <p class="text-center text-xs text-charcoal-light mt-8 pt-8 border-t border-gray-100">
                    ¿Ya tienes cuenta? 
                    <a href="<?php echo e(app_url('user/login')); ?>" class="text-coral font-bold uppercase tracking-widest hover:underline ml-1">Inicia sesión</a>
                </p>
            </form>
        </div>
        
        <div class="mt-8 text-center">
            <a href="<?php echo e(app_url()); ?>" class="text-xs font-bold text-gray-400 hover:text-coral uppercase tracking-widest transition-colors inline-flex items-center gap-2">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Volver a la tienda
            </a>
        </div>
    </div>
</div>
