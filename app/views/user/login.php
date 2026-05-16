<div class="py-16 md:py-28 px-4 bg-gradient-to-b from-white to-[#FDF9F8]">
    <div class="max-w-md mx-auto">
        <!-- Tarjeta Minimalista -->
        <div class="bg-white rounded-[2rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-gray-100 p-8 md:p-12 relative overflow-hidden">
            
            <!-- Encabezado Centrado -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-coral/5 rounded-full mb-5">
                    <i data-lucide="user" class="w-6 h-6 text-coral"></i>
                </div>
                <h2 class="text-3xl font-serif text-charcoal">Bienvenido</h2>
                <p class="text-gray-400 text-sm mt-2">Ingresa a tu cuenta floral</p>
            </div>

            <!-- Formulario Minimalista -->
            <form method="POST" class="space-y-6">
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Email</label>
                    <input type="email" name="email" autocomplete="email" required 
                           class="w-full px-5 py-3.5 bg-gray-50 border border-gray-100 focus:border-coral/30 focus:bg-white focus:ring-0 rounded-xl text-sm transition-all outline-none" 
                           placeholder="tu@correo.com">
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center ml-1">
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest">Contraseña</label>
                        <a href="#" class="text-[10px] font-bold text-coral/60 hover:text-coral transition-colors uppercase tracking-wider">¿Olvidaste?</a>
                    </div>
                    <input type="password" name="password" autocomplete="current-password" required 
                           class="w-full px-5 py-3.5 bg-gray-50 border border-gray-100 focus:border-coral/30 focus:bg-white focus:ring-0 rounded-xl text-sm transition-all outline-none" 
                           placeholder="••••••••">
                </div>

                <div class="flex items-center gap-3 ml-1">
                    <input type="checkbox" id="remember" class="w-4 h-4 rounded border-gray-200 text-coral focus:ring-coral/20 cursor-pointer">
                    <label for="remember" class="text-xs text-gray-500 cursor-pointer select-none">Recordarme</label>
                </div>

                <button type="submit" class="w-full bg-charcoal hover:bg-coral text-white font-bold py-4 rounded-xl text-xs uppercase tracking-[0.2em] transition-all transform active:scale-[0.98]">
                    Iniciar Sesión
                </button>
            </form>

            <!-- Separador -->
            <div class="relative my-10">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-100"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-4 bg-white text-[10px] font-bold text-gray-300 uppercase tracking-widest">O</span>
                </div>
            </div>

            <!-- Link Registro -->
            <p class="text-center text-sm text-gray-500">
                ¿No tienes cuenta? 
                <a href="<?php echo e(app_url('user/register')); ?>" class="text-coral font-bold hover:text-coral-dark transition-colors border-b border-coral/10 hover:border-coral ml-1">Crea una aquí</a>
            </p>
        </div>

        <!-- Volver -->
        <div class="mt-10 text-center">
            <a href="<?php echo e(app_url()); ?>" class="inline-flex items-center gap-2 text-[10px] font-bold text-gray-400 hover:text-charcoal transition-all uppercase tracking-widest group">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 group-hover:-translate-x-1 transition-transform"></i> 
                Volver a la tienda
            </a>
        </div>
    </div>
</div>



