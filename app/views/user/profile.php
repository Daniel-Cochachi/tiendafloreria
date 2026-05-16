<?php /** @var array $data */ ?>
<?php $user = $data['user']; ?>

<div class="min-h-screen" style="background-color: #FDF9F8;">
    <!-- Page Header -->
    <section class="py-16 px-6 text-center border-b" style="background-color: #FFF5F0; border-color: #FDECE8;">
        <div class="max-w-4xl mx-auto">
            <span class="font-script text-coral text-3xl block mb-2">Cuenta</span>
            <h1 class="text-4xl md:text-5xl font-serif text-charcoal mb-6">Mi Perfil</h1>
            <div class="flex justify-center gap-4 mt-8">
                <a class="bg-white border text-coral px-6 py-2 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm transition-colors" style="border-color: #F2E8E6; cursor: default;">Mi Perfil</a>
                <a href="<?php echo e(app_url('orders')); ?>" class="bg-transparent border border-transparent text-charcoal-light hover:text-coral px-6 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-colors">Mis Pedidos</a>
                <a href="<?php echo e(app_url('favorites')); ?>" class="bg-transparent border border-transparent text-charcoal-light hover:text-coral px-6 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-colors">Favoritos</a>
            </div>
        </div>
    </section>

    <!-- Profile Content -->
    <div class="max-w-6xl mx-auto px-6 py-14 flex-safe gap-10">
        
        <!-- Left Column: Personal Info & Password -->
        <div class="w-2-3-safe space-y-8">
            <!-- Personal Info Card -->
            <div class="bg-white rounded-2xl shadow-sm border p-8" style="border-color: #F2E8E6;">
                <h2 class="font-serif text-2xl text-charcoal mb-6 border-b pb-4" style="border-color: #F2E8E6;">Información Personal</h2>
                <form method="POST" action="<?php echo e(app_url('user/updateProfile')); ?>" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Nombre *</label>
                            <input type="text" name="nombre" value="<?php echo e($user['nombre']); ?>" required class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Apellido *</label>
                            <input type="text" name="apellido" value="<?php echo e($user['apellido']); ?>" required class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Email</label>
                        <input type="email" value="<?php echo e($user['email']); ?>" disabled class="w-full bg-gray-100 border py-3 px-4 text-sm outline-none text-gray-500 rounded-lg cursor-not-allowed" style="border-color: #E5E7EB;">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Teléfono</label>
                            <input type="tel" name="telefono" value="<?php echo e($user['telefono']); ?>" class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Género</label>
                            <select name="genero" class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg appearance-none" style="border-color: #E5E7EB;">
                                <option value="">Selecciona</option>
                                <option value="masculino" <?php echo ($user['genero'] === 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                                <option value="femenino" <?php echo ($user['genero'] === 'femenino') ? 'selected' : ''; ?>>Femenino</option>
                                <option value="otro" <?php echo ($user['genero'] === 'otro') ? 'selected' : ''; ?>>Otro</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Tipo Doc.</label>
                            <select name="documento_tipo" class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg appearance-none" style="border-color: #E5E7EB;">
                                <option value="">Selecciona</option>
                                <?php foreach (['DNI', 'RUC', 'CE'] as $doc): ?>
                                    <option value="<?php echo e($doc); ?>" <?php echo ($user['documento_tipo'] === $doc) ? 'selected' : ''; ?>><?php echo e($doc); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Número Doc.</label>
                            <input type="text" name="documento_numero" value="<?php echo e($user['documento_numero']); ?>" class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                        </div>
                    </div>

                    <div class="pt-4 text-right">
                        <button type="submit" class="bg-charcoal hover:bg-coral text-white px-8 py-3 text-xs font-bold uppercase tracking-widest transition-colors rounded-full shadow-sm">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Card -->
            <div class="bg-white rounded-2xl shadow-sm border p-8" style="border-color: #F2E8E6;">
                <details class="group">
                    <summary class="font-serif text-xl text-charcoal cursor-pointer flex justify-between items-center list-none" style="list-style: none;">
                        Cambiar Contraseña
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <div class="pt-6 mt-6 border-t" style="border-color: #F2E8E6;">
                        <form method="POST" action="<?php echo e(app_url('user/changePassword')); ?>" class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Contraseña Actual *</label>
                                <input type="password" name="password_actual" required class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Nueva *</label>
                                    <input type="password" name="password_nueva" required minlength="6" class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-charcoal uppercase tracking-wider mb-2">Confirmar *</label>
                                    <input type="password" name="password_confirmar" required minlength="6" class="w-full bg-gray-50 border py-3 px-4 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                                </div>
                            </div>
                            <div class="pt-2 text-right">
                                <button type="submit" class="bg-gray-200 hover:bg-charcoal text-charcoal hover:text-white px-8 py-3 text-xs font-bold uppercase tracking-widest transition-colors rounded-full">
                                    Actualizar
                                </button>
                            </div>
                        </form>
                    </div>
                </details>
            </div>
        </div>

        <!-- Right Column: Addresses -->
        <div class="w-1-3-safe space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border p-8" style="border-color: #F2E8E6;">
                <h2 class="font-serif text-2xl text-charcoal mb-6 border-b pb-4" style="border-color: #F2E8E6;">Mis Direcciones</h2>

                <div class="space-y-4 mb-8">
                    <?php foreach ($data['addresses'] as $addr): ?>
                        <div class="border rounded-xl p-5 relative overflow-hidden transition-colors <?php echo $addr['es_principal'] ? 'border-coral bg-[#FDF5F3]' : 'border-gray-200 hover:border-gray-300'; ?>">
                            <?php if ($addr['es_principal']): ?>
                                <span class="absolute top-0 right-0 bg-coral text-white text-[9px] font-bold uppercase tracking-widest px-3 py-1 rounded-bl-lg">Principal</span>
                            <?php endif; ?>
                            
                            <h3 class="text-sm font-bold text-charcoal mb-1 pr-16"><?php echo e($addr['calle'] . ' ' . $addr['numero']); ?></h3>
                            <p class="text-xs text-charcoal-light mb-2"><?php echo e($addr['distrito'] . ', ' . $addr['provincia'] . ', ' . $addr['departamento_prov']); ?></p>
                            
                            <?php if (!empty($addr['referencia'])): ?>
                                <p class="text-[11px] text-gray-500 italic mb-4"><i data-lucide="map-pin" class="w-3 h-3 inline"></i> Ref: <?php echo e($addr['referencia']); ?></p>
                            <?php endif; ?>
                            
                            <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-100">
                                <?php if (!$addr['es_principal']): ?>
                                    <a href="<?php echo e(app_url('user/setPrimaryAddress/' . $addr['id'])); ?>" class="text-[10px] font-bold uppercase tracking-wider text-charcoal hover:text-coral transition-colors">Hacer Principal</a>
                                <?php endif; ?>
                                <a href="<?php echo e(app_url('user/deleteAddress/' . $addr['id'])); ?>" onclick="return confirm('¿Eliminar esta dirección?')" class="text-[10px] font-bold uppercase tracking-wider text-red-500 hover:text-red-700 transition-colors ml-auto">Eliminar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if (!$data['addresses']): ?>
                        <div class="text-center py-8">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3" style="background-color: #FDF5F3;">
                                <i data-lucide="map" class="w-5 h-5 text-coral"></i>
                            </div>
                            <p class="text-sm text-charcoal-light">No tienes direcciones registradas.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <details class="group">
                    <summary class="bg-[#FDF9F8] text-coral border border-coral/20 hover:bg-[#FDF5F3] hover:border-coral px-6 py-3 text-xs font-bold uppercase tracking-widest transition-colors rounded-full cursor-pointer text-center list-none flex justify-center items-center gap-2" style="list-style:none;">
                        <i data-lucide="plus" class="w-4 h-4"></i> Agregar Dirección
                    </summary>
                    <div class="pt-6 mt-6 border-t" style="border-color: #F2E8E6;">
                        <form method="POST" action="<?php echo e(app_url('user/addAddress')); ?>" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-bold text-charcoal uppercase tracking-wider mb-1">Calle *</label>
                                    <input type="text" name="calle" required class="w-full bg-gray-50 border py-2.5 px-3 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-charcoal uppercase tracking-wider mb-1">Número *</label>
                                    <input type="text" name="numero" required class="w-full bg-gray-50 border py-2.5 px-3 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-charcoal uppercase tracking-wider mb-1">Dpto/Int</label>
                                    <input type="text" name="departamento" class="w-full bg-gray-50 border py-2.5 px-3 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-bold text-charcoal uppercase tracking-wider mb-1">Distrito *</label>
                                    <input type="text" name="distrito" required class="w-full bg-gray-50 border py-2.5 px-3 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-charcoal uppercase tracking-wider mb-1">Provincia *</label>
                                    <input type="text" name="provincia" value="Lima" required class="w-full bg-gray-50 border py-2.5 px-3 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-charcoal uppercase tracking-wider mb-1">Departamento *</label>
                                    <input type="text" name="departamento_prov" value="Lima" required class="w-full bg-gray-50 border py-2.5 px-3 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-bold text-charcoal uppercase tracking-wider mb-1">Referencia</label>
                                    <textarea name="referencia" rows="2" class="w-full bg-gray-50 border py-2.5 px-3 text-sm outline-none focus:border-coral transition-colors rounded-lg" style="border-color: #E5E7EB;"></textarea>
                                </div>
                            </div>
                            <label class="flex items-center gap-2 cursor-pointer mt-2 mb-4">
                                <input type="checkbox" name="principal" class="w-4 h-4 text-coral focus:ring-coral border-gray-300 rounded">
                                <span class="text-xs text-charcoal font-medium">Establecer como dirección principal</span>
                            </label>
                            <button type="submit" class="w-full bg-coral hover:bg-[#D93838] text-white py-3 text-xs font-bold uppercase tracking-widest transition-colors rounded-lg shadow-sm">
                                Guardar Dirección
                            </button>
                        </form>
                    </div>
                </details>
            </div>
        </div>
    </div>
</div>
