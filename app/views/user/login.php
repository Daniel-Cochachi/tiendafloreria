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
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(210, 108, 97, 0.2); }
        50% { box-shadow: 0 0 0 8px rgba(210, 108, 97, 0); }
    }
    .form-container { animation: slideIn 0.6s ease-out; }
    .input-focus:focus { box-shadow: 0 0 0 3px rgba(210, 108, 97, 0.1); }
</style>

<div class="min-h-screen flex items-center justify-center py-20 px-6 bg-gradient-to-br from-[#FDF9F8] to-[#F5EFEC]">
    <div class="max-w-md w-full form-container">
        <!-- Decoración superior -->
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-coral opacity-5 rounded-full blur-3xl"></div>
        
        <div class="bg-white rounded-2xl shadow-2xl border-2 p-10 md:p-12 relative overflow-hidden" style="border-color: #F2E8E6;">
            <!-- Línea decorativa -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-coral via-pink-300 to-coral"></div>
            
            <div class="text-center mb-10">
                <div class="inline-block mb-4 p-3 bg-coral/10 rounded-full">
                    <i data-lucide="flower-2" class="w-6 h-6 text-coral"></i>
                </div>
                <span class="font-script text-coral text-4xl block mb-2">Bienvenido</span>
                <h1 class="text-3xl font-serif text-charcoal">Inicia Sesión</h1>
                <p class="text-charcoal-light text-xs mt-3">Accede a tu cuenta para continuar</p>
            </div>

            <form method="POST" class="space-y-5">
                <div class="relative">
                    <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2.5">Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-4 w-5 h-5 text-gray-400 pointer-events-none"></i>
                        <input type="email" name="email" autocomplete="email" required 
                               class="w-full bg-gradient-to-r from-gray-50 to-gray-50 border-2 border-gray-200 py-3.5 pl-12 pr-5 text-sm outline-none input-focus transition-all rounded-xl" 
                               placeholder="tu@email.com">
                    </div>
                </div>

                <div class="relative">
                    <div class="flex justify-between items-center mb-2.5">
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider">Contraseña</label>
                        <a href="#" class="text-[11px] font-bold text-coral uppercase tracking-widest hover:text-coral/80 transition-colors">¿Olvidaste?</a>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-4 w-5 h-5 text-gray-400 pointer-events-none"></i>
                        <input type="password" name="password" autocomplete="current-password" required 
                               class="w-full bg-gradient-to-r from-gray-50 to-gray-50 border-2 border-gray-200 py-3.5 pl-12 pr-5 text-sm outline-none input-focus transition-all rounded-xl" 
                               placeholder="••••••••">
                    </div>
                </div>

                <label class="flex items-center gap-3 mt-6 cursor-pointer group">
                    <input type="checkbox" class="w-5 h-5 rounded border-2 border-gray-300 text-coral cursor-pointer accent-coral">
                    <span class="text-xs text-charcoal-light group-hover:text-charcoal transition-colors">Recuérdame en este dispositivo</span>
                </label>

                <button class="w-full bg-gradient-to-r from-charcoal to-charcoal hover:from-coral hover:to-coral-dark text-white py-4 rounded-xl text-sm font-bold uppercase tracking-widest transition-all shadow-lg mt-6 hover:shadow-xl transform hover:-translate-y-0.5" type="submit">
                    <span class="flex items-center justify-center gap-2">
                        Entrar 
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </span>
                </button>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t-2 border-gray-100"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 bg-white text-gray-500">O</span>
                    </div>
                </div>

                <p class="text-center text-xs text-charcoal-light mt-8">
                    ¿No tienes cuenta? 
                    <a href="<?php echo e(app_url('user/register')); ?>" class="text-coral font-bold uppercase tracking-widest hover:text-coral/80 transition-colors ml-1 inline-block">Regístrate</a>
                </p>
            </form>
        </div>
        
        <div class="mt-8 text-center">
            <a href="<?php echo e(app_url()); ?>" class="text-xs font-bold text-gray-400 hover:text-coral uppercase tracking-widest transition-colors inline-flex items-center gap-2 group">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 group-hover:-translate-x-1 transition-transform"></i> 
                <span>Volver a la tienda</span>
            </a>
        </div>
    </div>
</div>
