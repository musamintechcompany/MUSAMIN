<form wire:submit="updateProfileInformation">
    <div class="grid grid-cols-6 gap-6">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full size-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full size-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <div class="mt-2 flex gap-2">
                    <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select A New Photo') }}
                    </x-secondary-button>

                    @if ($this->user->profile_photo_path)
                        <x-secondary-button type="button" wire:click="deleteProfilePhoto">
                            {{ __('Remove Photo') }}
                        </x-secondary-button>
                    @endif
                    
                    <!-- Save Photo Button -->
                    <x-button wire:loading.attr="disabled" wire:target="photo" x-show="photoPreview" style="display: none;">
                        {{ __('Save Photo') }}
                    </x-button>
                </div>

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <div class="relative">
                <x-input id="name" type="text" class="mt-1 block w-full pr-16" wire:model="state.name" required autocomplete="name" readonly />
                <button type="button" id="editNameBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition-colors">
                    <i id="nameLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                    <span id="nameBtnText">Edit</span>
                </button>
            </div>
            <div id="nameMessage" class="mt-2 text-sm hidden"></div>
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="username" value="{{ __('Username') }}" />
            <div class="relative">
                <x-input id="username" type="text" class="mt-1 block w-full pr-16" value="{{ Auth::user()->username }}" readonly />
                <button type="button" id="editUsernameBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition-colors">
                    <i id="usernameLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                    <span id="usernameBtnText">Edit</span>
                </button>
            </div>
            <div id="usernameMessage" class="mt-2 text-sm hidden"></div>
            <x-input-error for="username" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <div class="relative">
                <x-input id="email" type="email" class="mt-1 block w-full pr-20" wire:model="state.email" required autocomplete="username" readonly />
                <button type="button" id="editEmailBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition-colors">
                    <i id="emailLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                    <span id="emailBtnText">Edit</span>
                </button>
            </div>
            <x-input-error for="email" class="mt-2" />

            <!-- Email Verification Section -->
            <div id="emailMessage" class="mt-2 text-sm hidden"></div>
            <div id="emailVerificationSection" class="mt-3 hidden">
                <div class="p-3 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md">
                    <p class="text-sm text-blue-800 dark:text-blue-200 mb-2">
                        📧 Verification code sent to your new email address
                    </p>
                    <div class="flex gap-2">
                        <input type="text" id="emailVerificationCode" placeholder="Enter 6-digit code" 
                               class="flex-1 px-3 py-2 text-center font-mono border border-blue-300 dark:border-blue-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-800 dark:text-white" 
                               maxlength="6">
                        <button type="button" id="verifyEmailBtn" class="px-4 py-2 bg-purple-600 text-white text-sm rounded hover:bg-purple-700 transition-colors">
                            <i id="emailVerifyLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                            <span id="emailVerifyBtnText">Verify</span>
                        </button>
                    </div>
                    <div id="emailCodeError" class="text-red-600 dark:text-red-400 text-sm mt-2 hidden"></div>
                </div>
            </div>



            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 text-yellow-600 dark:text-yellow-400">
                    {{ __('Your email address is unverified. Click on the Edit button to change it.') }}
                </p>
            @endif
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Message functions
        function showUsernameMessage(message, type) {
            const messageDiv = document.getElementById('usernameMessage');
            messageDiv.textContent = message;
            messageDiv.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
            messageDiv.classList.remove('hidden');
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        }

        function showNameMessage(message, type) {
            const messageDiv = document.getElementById('nameMessage');
            messageDiv.textContent = message;
            messageDiv.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
            messageDiv.classList.remove('hidden');
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        }

        function showEmailMessage(message, type) {
            const messageDiv = document.getElementById('emailMessage');
            messageDiv.textContent = message;
            messageDiv.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
            messageDiv.classList.remove('hidden');
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        }

        // Name field functionality
        const editNameBtn = document.getElementById('editNameBtn');
        const nameInput = document.getElementById('name');
        let isEditingName = false;
        let originalName = nameInput.value;

        editNameBtn.addEventListener('click', function() {
            if (!isEditingName) {
                // Enable editing
                nameInput.removeAttribute('readonly');
                nameInput.focus();
                document.getElementById('nameBtnText').textContent = 'Save';
                isEditingName = true;
            } else {
                // Save changes
                const newName = nameInput.value.trim();
                if (!newName) {
                    showNameMessage('Please enter a valid name', 'error');
                    return;
                }
                
                // Validate name format
                const nameRegex = /^[a-zA-Z0-9\s\'-\.]+$/;
                if (!nameRegex.test(newName)) {
                    showNameMessage('Name can only contain letters, numbers, spaces, apostrophes, hyphens, and dots', 'error');
                    return;
                }
                
                if (newName.length < 2) {
                    showNameMessage('Name must be at least 2 characters long', 'error');
                    return;
                }
                
                if (newName === originalName) {
                    // No changes made
                    nameInput.setAttribute('readonly', true);
                    document.getElementById('nameBtnText').textContent = 'Edit';
                    isEditingName = false;
                    return;
                }

                // Show loading
                document.getElementById('nameLoadingIcon').classList.remove('hidden');
                document.getElementById('nameBtnText').textContent = 'Saving...';
                editNameBtn.disabled = true;

                // Trigger Livewire update
                @this.set('state.name', newName);
                @this.call('updateProfileInformation').then(() => {
                    nameInput.setAttribute('readonly', true);
                    document.getElementById('nameBtnText').textContent = 'Edit';
                    isEditingName = false;
                    originalName = newName;
                    document.getElementById('nameLoadingIcon').classList.add('hidden');
                    editNameBtn.disabled = false;
                    showNameMessage('Name updated successfully!', 'success');
                }).catch(() => {
                    document.getElementById('nameLoadingIcon').classList.add('hidden');
                    editNameBtn.disabled = false;
                    showNameMessage('Error updating name', 'error');
                });
            }
        });

        // Username field functionality
        const editUsernameBtn = document.getElementById('editUsernameBtn');
        const usernameInput = document.getElementById('username');
        let isEditingUsername = false;
        let originalUsername = usernameInput.value;

        editUsernameBtn.addEventListener('click', function() {
            if (!isEditingUsername) {
                // Enable editing
                usernameInput.removeAttribute('readonly');
                usernameInput.focus();
                document.getElementById('usernameBtnText').textContent = 'Save';
                isEditingUsername = true;
            } else {
                // Save changes
                let newUsername = usernameInput.value.trim();
                if (!newUsername) {
                    showUsernameMessage('Please enter a valid username', 'error');
                    return;
                }
                
                // Add @ if not present
                if (!newUsername.startsWith('@')) {
                    newUsername = '@' + newUsername;
                    usernameInput.value = newUsername;
                }
                
                if (newUsername === originalUsername) {
                    // No changes made
                    usernameInput.setAttribute('readonly', true);
                    document.getElementById('usernameBtnText').textContent = 'Edit';
                    isEditingUsername = false;
                    return;
                }

                // Show loading
                document.getElementById('usernameLoadingIcon').classList.remove('hidden');
                document.getElementById('usernameBtnText').textContent = 'Saving...';
                editUsernameBtn.disabled = true;

                fetch('{{ route("username.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        username: newUsername
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        usernameInput.setAttribute('readonly', true);
                        document.getElementById('usernameBtnText').textContent = 'Edit';
                        isEditingUsername = false;
                        originalUsername = newUsername;
                        showUsernameMessage('Username updated successfully!', 'success');
                    } else {
                        showUsernameMessage(data.message || 'Error updating username', 'error');
                        usernameInput.value = originalUsername;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showUsernameMessage('Error updating username', 'error');
                    usernameInput.value = originalUsername;
                })
                .finally(() => {
                    // Hide loading
                    document.getElementById('usernameLoadingIcon').classList.add('hidden');
                    document.getElementById('usernameBtnText').textContent = 'Edit';
                    editUsernameBtn.disabled = false;
                    usernameInput.setAttribute('readonly', true);
                    isEditingUsername = false;
                });
            }
        });

        // Email field functionality
        const editEmailBtn = document.getElementById('editEmailBtn');
        const emailInput = document.getElementById('email');
        const verificationSection = document.getElementById('emailVerificationSection');
        const verifyBtn = document.getElementById('verifyEmailBtn');
        const codeInput = document.getElementById('emailVerificationCode');
        const errorDiv = document.getElementById('emailCodeError');
        let isEditingEmail = false;
        let originalEmail = emailInput.value;

        editEmailBtn.addEventListener('click', function() {
            if (!isEditingEmail) {
                // Enable editing
                emailInput.removeAttribute('readonly');
                emailInput.focus();
                document.getElementById('emailBtnText').textContent = 'Save';
                isEditingEmail = true;
            } else {
                // Save changes
                const newEmail = emailInput.value;
                if (!newEmail || !newEmail.includes('@')) {
                    alert('Please enter a valid email address');
                    return;
                }
                
                if (newEmail === originalEmail) {
                    // No changes made
                    emailInput.setAttribute('readonly', true);
                    document.getElementById('emailBtnText').textContent = 'Edit';
                    isEditingEmail = false;
                    return;
                }

                // Show loading
                document.getElementById('emailLoadingIcon').classList.remove('hidden');
                document.getElementById('emailBtnText').textContent = 'Saving...';
                editEmailBtn.disabled = true;

                fetch('{{ route("email.change") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email: newEmail
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.verification_required) {
                            // Show verification section
                            verificationSection.classList.remove('hidden');
                        } else {
                            // Email updated directly
                            showEmailMessage('Email updated successfully!', 'success');
                            location.reload(); // Refresh to show new email
                        }
                        emailInput.setAttribute('readonly', true);
                        document.getElementById('emailBtnText').textContent = 'Edit';
                        isEditingEmail = false;
                        originalEmail = newEmail;
                    } else {
                        showEmailMessage(data.message || 'Error updating email', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showEmailMessage('Error updating email', 'error');
                })
                .finally(() => {
                    // Hide loading
                    document.getElementById('emailLoadingIcon').classList.add('hidden');
                    editEmailBtn.disabled = false;
                });
            }
        });

        verifyBtn.addEventListener('click', function() {
            const code = codeInput.value;
            if (!code || code.length !== 6) {
                errorDiv.textContent = 'Please enter a valid 6-digit code';
                errorDiv.classList.remove('hidden');
                return;
            }

            // Show loading
            document.getElementById('emailVerifyLoadingIcon').classList.remove('hidden');
            document.getElementById('emailVerifyBtnText').textContent = 'Verifying...';
            verifyBtn.disabled = true;

            fetch('{{ route("email.verify-change") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    verification_code: code
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    verificationSection.classList.add('hidden');
                    codeInput.value = '';
                    showEmailMessage('Email changed successfully!', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    errorDiv.textContent = data.message;
                    errorDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorDiv.textContent = 'Error verifying code';
                errorDiv.classList.remove('hidden');
            })
            .finally(() => {
                // Hide loading
                document.getElementById('emailVerifyLoadingIcon').classList.add('hidden');
                document.getElementById('emailVerifyBtnText').textContent = 'Verify';
                verifyBtn.disabled = false;
            });
        });
    });
</script>
