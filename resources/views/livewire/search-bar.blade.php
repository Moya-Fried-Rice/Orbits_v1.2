<div class="relative group w-full sm:w-[250px]">
    <input 
        class="px-5 py-2 pr-20 border border-[#DDD] rounded appearance-none w-full transition-all duration-200 group-hover:border-[#923534]" 
        wire:model.live="search" 
        placeholder="Search..." 
    />
    <div class="absolute right-5 top-1/2 transform -translate-y-1/2 hover:text-blue-500 transition-colors duration-200">
        <img class="w-4 h-4 group-hover:transform group-hover:-translate-x-1 transition-transform duration-200" src="{{ asset('assets/icons/search.svg') }}" alt="Search">
    </div>
</div>