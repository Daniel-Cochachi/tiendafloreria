<?php $contactHeroImg = 'https://images.unsplash.com/photo-1563241527-3004b7be0ffd?q=80&w=1000&auto=format&fit=crop'; ?>
<!-- HERO -->
<section class="relative bg-blush-50 overflow-hidden">
    <div class="max-w-7xl mx-auto flex-safe min-h-[420px]">
        <div class="w-1-2-safe flex flex-col justify-center px-8 md:px-16 py-20 relative z-10" id="contact-hero-content">
            <div class="relative z-10">
                <span class="font-script text-coral text-3xl mb-2">Hablemos</span>
                <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-6 leading-tight">
                    Estamos aquí para <span class="italic">Ayudarte</span>
                </h1>
                <p class="text-charcoal-light text-sm mb-8 max-w-md leading-relaxed">
                    ¿Tienes alguna duda sobre un pedido o quieres un arreglo floral personalizado? Nuestro equipo está listo para atenderte.
                </p>
            </div>
        </div>
        <div class="w-1-2-safe relative min-h-[350px] mobile-hide">
            <img src="<?php echo $contactHeroImg; ?>" alt="Contacto" class="absolute inset-0 w-full h-full object-cover">
        </div>
    </div>
</section>

<style>
    @media (max-width: 767px) {
        #contact-hero-content {
            background-image: linear-gradient(rgba(255, 245, 240, 0.85), rgba(255, 245, 240, 0.85)), url('<?php echo $contactHeroImg; ?>');
            background-size: cover;
            background-position: center;
        }
    }
</style>

<!-- CONTACT CONTENT -->
<section class="max-w-7xl mx-auto px-6 py-20">
    <div class="flex-safe gap-16">
        
        <!-- LEFT: Info -->
        <div class="w-1-3-safe">
            <h2 class="font-serif text-2xl text-charcoal mb-8">Información de Contacto</h2>
            
            <div class="space-y-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blush-50 rounded-full flex items-center justify-center shrink-0 text-coral">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-charcoal text-sm mb-1">Nuestra Tienda</h4>
                        <p class="text-charcoal-light text-sm leading-relaxed">Av. Las Flores 1234, Distrito Botánico<br>Lima, Perú</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blush-50 rounded-full flex items-center justify-center shrink-0 text-coral">
                        <i data-lucide="phone" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-charcoal text-sm mb-1">Llámanos</h4>
                        <p class="text-charcoal-light text-sm leading-relaxed">
                            <a href="tel:+5119999999" class="hover:text-coral transition-colors">(01) 999 9999</a><br>
                            <a href="https://wa.me/51999999999" class="hover:text-coral transition-colors">+51 999 999 999</a>
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blush-50 rounded-full flex items-center justify-center shrink-0 text-coral">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-charcoal text-sm mb-1">Escríbenos</h4>
                        <p class="text-charcoal-light text-sm leading-relaxed">
                            <a href="mailto:info@floreriartesanal.com" class="hover:text-coral transition-colors">info@floreriartesanal.com</a><br>
                            <a href="mailto:ventas@floreriartesanal.com" class="hover:text-coral transition-colors">ventas@floreriartesanal.com</a>
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blush-50 rounded-full flex items-center justify-center shrink-0 text-coral">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-charcoal text-sm mb-1">Horario de Atención</h4>
                        <p class="text-charcoal-light text-sm leading-relaxed">Lunes a Sábado: 8:00 AM - 8:00 PM<br>Domingos: 9:00 AM - 2:00 PM</p>
                    </div>
                </div>
            </div>

            <div class="mt-10">
                <h4 class="font-bold text-charcoal text-sm mb-4">Síguenos</h4>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 bg-blush-50 flex items-center justify-center text-coral hover:bg-coral hover:text-white transition-all rounded-full">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-blush-50 flex items-center justify-center text-coral hover:bg-coral hover:text-white transition-all rounded-full">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-blush-50 flex items-center justify-center text-coral hover:bg-coral hover:text-white transition-all rounded-full">
                        <i data-lucide="twitter" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- RIGHT: Form -->
        <div class="w-2-3-safe">
            <div class="bg-white p-8 md:p-12 shadow-card border border-gray-50">
                <h2 class="font-serif text-2xl text-charcoal mb-2">Envíanos un mensaje</h2>
                <p class="text-charcoal-light text-sm mb-8">Completá el formulario y te responderemos a la brevedad posible.</p>
                
                <form action="<?php echo e(app_url('contact/send')); ?>" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Nombre Completo</label>
                            <input type="text" name="name" required class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:border-coral outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Email</label>
                            <input type="email" name="email" required class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:border-coral outline-none transition-all">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Asunto</label>
                        <select name="subject" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:border-coral outline-none transition-all">
                            <option value="consulta">Consulta General</option>
                            <option value="pedido">Duda sobre mi pedido</option>
                            <option value="personalizado">Arreglo Personalizado</option>
                            <option value="eventos">Flores para Eventos/Bodas</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Mensaje</label>
                        <textarea name="message" rows="5" required class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm focus:border-coral outline-none transition-all"></textarea>
                    </div>
                    
                    <button type="submit" class="bg-coral hover:bg-coral-hover text-white px-8 py-4 text-xs font-bold uppercase tracking-widest transition-colors w-full flex items-center justify-center gap-2">
                        Enviar Mensaje <i data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- MAP -->
<section class="h-96 w-full bg-gray-100">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d124864.04163914449!2d-77.10090264150537!3d-12.043187195886985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c5f619ee3ec7%3A0x14206cb9cc452e4a!2sLima!5e0!3m2!1sen!2spe!4v1689280000000!5m2!1sen!2spe" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>
