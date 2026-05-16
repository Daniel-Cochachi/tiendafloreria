<div class="min-h-screen flex items-center justify-center py-20 px-6 bg-[#FDF9F8]">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-card border p-10 md:p-12" style="border-color: #F2E8E6;">
            <div class="text-center mb-10">
                <span class="font-script text-coral text-3xl block mb-2">Bienvenido</span>
                <h1 class="text-3xl font-serif text-charcoal">Inicia Sesión</h1>
            </div>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Email</label>
                    <input type="email" name="email" autocomplete="email" required class="w-full bg-gray-50 border py-4 px-5 text-sm outline-none focus:border-coral transition-colors rounded-xl" style="border-color: #E5E7EB;" placeholder="tu@email.com">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider">Contraseña</label>
                        <a href="#" class="text-[10px] font-bold text-coral uppercase tracking-widest hover:underline">¿Olvidaste?</a>
                    </div>
                    <input type="password" name="password" autocomplete="current-password" required class="w-full bg-gray-50 border py-4 px-5 text-sm outline-none focus:border-coral transition-colors rounded-xl" style="border-color: #E5E7EB;" placeholder="••••••••">
                </div>

                <button class="w-full bg-charcoal hover:bg-coral text-white py-4 rounded-xl text-sm font-bold uppercase tracking-widest transition-all shadow-lg mt-4" type="submit">
                    Entrar <i data-lucide="log-in" class="w-4 h-4 inline ml-2"></i>
                </button>

                <p class="text-center text-xs text-charcoal-light mt-8 pt-8 border-t border-gray-100">
                    ¿No tienes cuenta? 
                    <a href="<?php echo e(app_url('user/register')); ?>" class="text-coral font-bold uppercase tracking-widest hover:underline ml-1">Regístrate aquí</a>
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
