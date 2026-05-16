<!-- Page Header -->
<section class="bg-blush-50 py-16 px-6 text-center border-b border-gray-100 relative">
    <div class="max-w-4xl mx-auto">
        <span class="font-script text-coral text-4xl block mb-2">Ayuda</span>
        <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-4">Preguntas Frecuentes</h1>
        <p class="text-charcoal-light max-w-lg mx-auto">Todo lo que necesitas saber sobre tus pedidos, envíos, pagos y el cuidado de tus flores.</p>
    </div>
</section>

<!-- FAQ Content -->
<section class="max-w-4xl mx-auto px-6 py-20">
    <div class="space-y-12">
        
        <!-- Category: Entregas y Envíos -->
        <div>
            <h2 class="font-serif text-2xl text-charcoal mb-6 flex items-center gap-3">
                <i data-lucide="truck" class="text-coral"></i> Entregas y Envíos
            </h2>
            <div class="space-y-4">
                <details class="group bg-white border border-gray-100 rounded-lg shadow-sm">
                    <summary class="flex items-center justify-between p-5 cursor-pointer list-none">
                        <span class="text-sm font-bold text-charcoal uppercase tracking-wider">¿Cuál es el costo de envío?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-coral transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-sm text-charcoal-light leading-relaxed border-t border-gray-50 pt-4">
                        El envío es gratuito para pedidos superiores a S/ 150.00 dentro de Lima Metropolitana. Para pedidos menores o zonas fuera del área metropolitana, el costo se calcula según la ubicación y se muestra antes de confirmar el pedido.
                    </div>
                </details>
                
                <details class="group bg-white border border-gray-100 rounded-lg shadow-sm">
                    <summary class="flex items-center justify-between p-5 cursor-pointer list-none">
                        <span class="text-sm font-bold text-charcoal uppercase tracking-wider">¿Cuánto tiempo tarda la entrega?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-coral transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-sm text-charcoal-light leading-relaxed border-t border-gray-50 pt-4">
                        Las entregas en Lima Metropolitana se realizan en un plazo de 24 a 48 horas hábiles. También ofrecemos entrega programada para que elijas la fecha exacta y rango horario.
                    </div>
                </details>
            </div>
        </div>

        <!-- Category: Métodos de Pago -->
        <div>
            <h2 class="font-serif text-2xl text-charcoal mb-6 flex items-center gap-3">
                <i data-lucide="credit-card" class="text-coral"></i> Métodos de Pago
            </h2>
            <div class="space-y-4">
                <details class="group bg-white border border-gray-100 rounded-lg shadow-sm">
                    <summary class="flex items-center justify-between p-5 cursor-pointer list-none">
                        <span class="text-sm font-bold text-charcoal uppercase tracking-wider">¿Qué métodos de pago aceptan?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-coral transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-sm text-charcoal-light leading-relaxed border-t border-gray-50 pt-4">
                        Aceptamos tarjetas de crédito y débito (Visa, Mastercard, American Express), transferencia bancaria, Yape y Plin. Todos nuestros procesos son 100% seguros.
                    </div>
                </details>
            </div>
        </div>

        <!-- Category: Cuidado de Flores -->
        <div>
            <h2 class="font-serif text-2xl text-charcoal mb-6 flex items-center gap-3">
                <i data-lucide="heart" class="text-coral"></i> Cuidado de Flores
            </h2>
            <div class="space-y-4">
                <details class="group bg-white border border-gray-100 rounded-lg shadow-sm">
                    <summary class="flex items-center justify-between p-5 cursor-pointer list-none">
                        <span class="text-sm font-bold text-charcoal uppercase tracking-wider">¿Cómo mantener mis flores frescas por más tiempo?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-coral transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-sm text-charcoal-light leading-relaxed border-t border-gray-50 pt-4">
                        Corta los tallos en diagonal cada dos días, cambia el agua diariamente, retira las hojas que queden sumergidas y coloca las flores en un lugar fresco lejos de la luz solar directa.
                    </div>
                </details>
            </div>
        </div>
        
    </div>
</section>

<!-- Call to Action -->
<section class="bg-blush-50 py-16">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="font-serif text-3xl text-charcoal mb-4">¿Aún tienes dudas?</h2>
        <p class="text-charcoal-light mb-8">Nuestro equipo de atención al cliente está disponible para ayudarte en lo que necesites.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="<?php echo e(app_url('contact')); ?>" class="bg-coral hover:bg-coral-hover text-white px-8 py-3 text-xs font-bold uppercase tracking-widest transition-colors inline-flex items-center gap-2">
                <i data-lucide="mail" class="w-4 h-4"></i> Contáctanos
            </a>
            <a href="https://wa.me/51999999999" class="bg-white border border-gray-200 text-charcoal hover:bg-gray-50 px-8 py-3 text-xs font-bold uppercase tracking-widest transition-colors inline-flex items-center gap-2">
                <i data-lucide="phone" class="w-4 h-4"></i> WhatsApp
            </a>
        </div>
    </div>
</section>
