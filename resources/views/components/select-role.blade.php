<div class="relative">
    <select 
        class="px-4 bg-[#F8F8F8] w-full p-2 border rounded border-[#DDD] focus:ring focus:ring-blue-300 hover:border-[#923534] transition-all duration-200"
        id="role_id" 
        wire:model="role_id"
        multiple
        size="10">
        @foreach ($this->getRoles() as $role)
            <option value="{{ $role->role_id }}">
                {{ ucfirst(str_replace('_', ' ', $role->role_name)) }}
            </option>
        @endforeach
    </select>
    <div class="text-sm text-gray-500 mt-1">
        Hold <span class="font-bold">Ctrl (Windows)</span> or <span class="font-bold">Cmd (Mac)</span> to select multiple roles.
    </div>
</div>
