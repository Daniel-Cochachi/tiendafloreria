<?php /** @var array $campaigns */ ?>
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <p class="text-sm font-semibold text-forest-600 uppercase tracking-wider mb-1">Configuración</p>
        <h1 class="text-3xl font-serif font-bold text-gray-900">Campañas del Home</h1>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100">Lista de Campañas</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 border-y border-gray-100">
                    <tr>
                        <th class="py-3 px-4 font-semibold text-gray-700">Campaña</th>
                        <th class="py-3 px-4 font-semibold text-gray-700">Estado</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($campaigns as $c): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4 font-medium text-gray-900">
                                <?php echo e($c['campaign_name']); ?><br>
                                <span class="text-xs text-gray-400 font-normal"><?php echo e($c['hero_title']); ?></span>
                            </td>
                            <td class="py-4 px-4">
                                <?php if ($c['is_active']): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Activa</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactiva</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 text-right flex justify-end gap-2">
                                <?php if (!$c['is_active']): ?>
                                    <a href="<?php echo e(app_url('admin/activateSetting/' . $c['id'])); ?>" class="text-forest-600 hover:text-forest-800 text-xs font-medium bg-forest-50 px-3 py-1.5 rounded-md transition-colors border border-forest-200">Activar</a>
                                <?php endif; ?>
                                <button type="button" class="text-gray-600 hover:text-gray-900 text-xs font-medium bg-gray-50 px-3 py-1.5 rounded-md transition-colors border border-gray-200" onclick="editCampaign(<?php echo htmlspecialchars(json_encode($c)); ?>)">Editar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 self-start">
        <h3 id="form-title" class="text-lg font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100">Nueva Campaña</h3>
        <form action="<?php echo e(app_url('admin/saveSetting')); ?>" method="POST" class="space-y-4">
            <input type="hidden" name="id" id="campaign_id" value="">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de Campaña (Ej. San Valentín)</label>
                <input type="text" name="campaign_name" id="campaign_name" required class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-forest-500 focus:border-forest-500 sm:text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Título Principal (Hero Title)</label>
                <input type="text" name="hero_title" id="hero_title" required class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-forest-500 focus:border-forest-500 sm:text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtítulo</label>
                <input type="text" name="hero_subtitle" id="hero_subtitle" required class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-forest-500 focus:border-forest-500 sm:text-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Texto del Botón</label>
                    <input type="text" name="hero_button_text" id="hero_button_text" value="Shop Now" required class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-forest-500 focus:border-forest-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Color de Fondo Hero</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="hero_bg_color" id="hero_bg_color" value="#F5E6EB" class="h-9 w-12 border-0 p-0 bg-transparent cursor-pointer rounded overflow-hidden" oninput="document.getElementById('hero_bg_color_hex').value = this.value">
                        <input type="text" id="hero_bg_color_hex" value="#F5E6EB" class="flex-1 border border-gray-300 rounded-md shadow-sm py-1.5 px-3 focus:outline-none focus:ring-forest-500 focus:border-forest-500 text-xs" oninput="document.getElementById('hero_bg_color').value = this.value">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">URL Imagen</label>
                <input type="text" name="hero_image_url" id="hero_image_url" required class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-forest-500 focus:border-forest-500 sm:text-sm" placeholder="https://...">
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 mt-6">
                <button type="button" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors" onclick="resetForm()">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-forest-700 text-white rounded-md shadow-sm text-sm font-medium hover:bg-forest-800 transition-colors">Guardar Campaña</button>
            </div>
        </form>
    </div>
</div>

<script>
function editCampaign(c) {
    document.getElementById('form-title').innerText = 'Editar Campaña';
    document.getElementById('campaign_id').value = c.id;
    document.getElementById('campaign_name').value = c.campaign_name;
    document.getElementById('hero_title').value = c.hero_title;
    document.getElementById('hero_subtitle').value = c.hero_subtitle;
    document.getElementById('hero_button_text').value = c.hero_button_text;
    document.getElementById('hero_image_url').value = c.hero_image_url;
    document.getElementById('hero_bg_color').value = c.hero_bg_color || '#F5E6EB';
    document.getElementById('hero_bg_color_hex').value = c.hero_bg_color || '#F5E6EB';
}

function resetForm() {
    document.getElementById('form-title').innerText = 'Nueva Campaña';
    document.getElementById('campaign_id').value = '';
    document.getElementById('campaign_name').value = '';
    document.getElementById('hero_title').value = '';
    document.getElementById('hero_subtitle').value = '';
    document.getElementById('hero_button_text').value = 'Shop Now';
    document.getElementById('hero_image_url').value = '';
}
</script>
