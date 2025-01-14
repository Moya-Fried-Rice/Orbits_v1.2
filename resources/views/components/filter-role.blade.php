<div class="relative group w-full sm:w-[250px]">
    <select wire:model.live="selectedRole"
    class="text-gray-400 px-5 py-2 pr-20 border border-[#DDD] rounded appearance-none w-full bg-[#F8F8F8] transition-all duration-200 group-hover:border-[#923534]">
        <option value=""><p class="text-slate-200">Filter Role...</p></option>
            <option class="text-[#666]" value="4">Admin</option>
            <option class="text-[#666]" value="1">Student</option>
            <option class="text-[#666]" value="2">Faculty</option>
            <option class="text-[#666]" value="3">Program Chair</option>
    </select>
    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer hover:text-blue-500 transition-colors duration-200">
        <img class="w-6 h-6 group-hover:transform group-hover:-translate-x-1 transition-transform duration-200" src="{{ asset('assets/icons/arrow1.svg') }}" alt="Arrow">
    </div>
</div>