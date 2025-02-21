<div>
    <div class="min-h-screen bg-gray-50 p-3 md:p-8">
        <div class="mx-auto max-w-7xl space-y-6 md:space-y-8">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <h1 class="text-xl md:text-3xl font-semibold font-TT">My Profile</h1>
                </div>
                <button 
                    wire:click="saveChanges"
                    class="inline-flex items-center justify-center size-12 bg-[#923534] hover:bg-[#923534]/90 text-white rounded-md"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16a2 2 0 002 2h12a2 2 0 002-2V8.342a2 2 0 00-.602-1.43l-4.44-4.342A2 2 0 0013.56 2H6a2 2 0 00-2 2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16V10" />
                    </svg>
                </button>
            </div>

            {{-- Profile Content --}}
            <div class="grid gap-6 md:gap-12 md:grid-cols-[300px_1fr]">
                {{-- Left Column - Profile Picture --}}
                <div class="space-y-4 md:space-y-6">
                    <div class="relative mx-auto w-40 h-40 md:w-60 md:h-60 md:mx-0 group">
                        @if($newProfilePicture)
                            <img 
                                src="{{ $newProfilePicture->temporaryUrl() }}"
                                alt="New profile picture"
                                class="rounded-full w-full h-full object-cover"
                            />
                        @else
                            <img 
                                src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : '/placeholder.jpg' }}"
                                alt="Profile picture"
                                class="rounded-full w-full h-full object-cover"
                            />
                        @endif

                        <label 
                            for="profile-picture-upload"
                            class="absolute inset-0 flex items-center justify-center rounded-full bg-black/50 text-white opacity-0 group-hover:opacity-100 cursor-pointer"
                        >
                            <input
                                type="file"
                                id="profile-picture-upload"
                                wire:model="newProfilePicture"
                                class="hidden"
                                accept="image/*"
                            />
                            <svg class="w-8 h-8 md:w-12 md:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </label>
                    </div>
                    
                    <div class="text-center md:text-left">
                        <h2 class="text-xl md:text-2xl font-medium font-TT">{{ $name }}</h2>
                        <p class="text-base md:text-lg text-gray-500 font-TT">{{ $role?->role_name }}</p>
                    </div>
                </div>

                {{-- Right Column - Non-Editable Fields --}}
                <div class="space-y-6 md:space-y-8">
                    <div class="grid gap-4 md:gap-6 sm:grid-cols-2">
                        <div class="space-y-2">
                            <label class="block text-base md:text-lg font-medium text-gray-700 font-TT">Name</label>
                            <div class="w-full px-3 md:px-4 py-2 md:py-3 rounded-md bg-gray-100 text-base md:text-lg font-TT">
                                {{ $name }}
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-base md:text-lg font-medium text-gray-700 font-TT">Email</label>
                            <div class="w-full px-3 md:px-4 py-2 md:py-3 rounded-md bg-gray-100 text-base md:text-lg font-TT">
                                {{ $email }}
                            </div>
                        </div>
                    </div>

                    {{-- Password Change Section --}}
                        <div class="space-y-4 bg-white p-4 md:p-6 rounded-lg shadow-sm">
                            <h3 class="text-lg md:text-xl font-medium font-TT">Change Password</h3>
                            <div class="space-y-2">
                                <label for="password" class="block text-base md:text-lg font-medium text-gray-700 font-TT">New Password</label>
                                <div class="flex gap-2 md:gap-4">
                                    <input
                                        type="password"
                                        id="password"
                                        wire:model="password"
                                        class="flex-1 px-3 md:px-4 py-2 md:py-3 text-base md:text-lg rounded-md border-gray-300 shadow-sm focus:border-[#923534] focus:ring-[#923534] font-TT"
                                        placeholder="Enter new password"
                                    />
                                    <button 
                                        wire:click="updatePassword"
                                        type="button"
                                        class="px-4 md:px-6 py-2 md:py-3 bg-[#923534] text-white rounded-md hover:bg-[#923534]/90 text-base md:text-lg whitespace-nowrap font-TT"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Success Message for Profile Update --}}
                        @if (session()->has('message'))
                            <div class="rounded-md bg-green-50 p-4 md:p-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 md:h-6 md:w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-base md:text-lg font-medium text-green-800 font-TT">
                                            {{ session('message') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Success Message for Password Change --}}
                        @if (session()->has('password_message'))
                            <div class="rounded-md bg-green-50 p-4 md:p-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 md:h-6 md:w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-base md:text-lg font-medium text-green-800 font-TT">
                                            {{ session('password_message') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    
                    {{-- Save Message --}}
                    @if ($showSaveMessage)
                        <div class="rounded-md bg-yellow-50 p-4 md:p-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 md:h-6 md:w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-base md:text-lg font-medium text-yellow-800 font-TT">
                                        Photo uploaded successfully. Click save to apply changes.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>