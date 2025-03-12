<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Gestionar Permisos por Rol</h2>
    <!-- Notificación -->
    @if ($message)
        <div class="p-2 mb-4 text-green-700 bg-green-100 border border-green-400 rounded-md">
            {{ $message }}
        </div>
    @endif
    <!-- Select de Roles -->
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Selecciona un Rol:</label>
        <select wire:model="selectedRole" class="w-1/3 p-2 border rounded-md shadow-sm">
            <option value="">-- Selecciona un Rol --</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
    <!-- Grupo de Checkboxes de Permisos -->
    <div class="mt-4">
        <div class="max-h-80 overflow-y-auto p-4 border rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Permisos</h3>
            @foreach ($permissionsGrouped as $category => $permissions)
                <div class="mb-4">
                    <h4 class="text-md font-semibold text-gray-700">{{ 'Grupo de Permisos de: ' . ucfirst($category) }}
                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" wire:click="togglePermission({{ $permission['id'] }})"
                                    @if (in_array($permission['id'], $selectedPermissions)) checked @endif class="sr-only peer">
                                <div
                                    class="w-10 h-5 bg-gray-300 rounded-full peer-checked:bg-blue-600 relative transition duration-300">
                                    <div
                                        class="absolute left-1 top-1 w-3.5 h-3.5 bg-white rounded-full transition duration-300 peer-checked:translate-x-5">
                                    </div>
                                </div>
                                <span class="ml-2">{{ $permission['name'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
