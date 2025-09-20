<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-sm space-y-4">
            <!-- Authentication Card Logo -->
            <div class="flex justify-center">
                <x-authentication-card-logo />
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white">
                Email Verification<br>
                <span class="text-sm font-normal text-gray-600 dark:text-gray-400">Enter the 6-digit code sent to your email</span>
            </h2>

            @if (session('status') == 'verification-link-sent')
                <div id="successAlert" class="p-3 text-sm text-green-600 bg-green-100 rounded dark:text-green-400 dark:bg-green-900">
                    A new verification code has been sent to your email address.
                </div>
            @endif

            <!-- Error Toast -->
            <div id="errorToast" class="fixed z-50 hidden w-11/12 max-w-md py-2 text-sm text-center text-white transform -translate-x-1/2 bg-red-500 rounded shadow-lg top-4 left-1/2 dark:bg-red-700"></div>

            <!-- Verification Code Form -->
            <form method="POST" action="{{ route('verification.verify') }}" class="space-y-4">
                @csrf

                <!-- Main Input Field (switches between email and code) -->
                <div>
                    <label for="mainInput" id="inputLabel" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Verification Code</label>
                    <input type="text" name="code" id="mainInput" maxlength="6" required autofocus
                           class="w-full px-3 py-2 mt-1 text-center text-2xl tracking-widest border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                           placeholder="000000" value="" />
                    <div id="inputError" class="text-sm text-red-500 dark:text-red-400 mt-1 hidden"></div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="mainBtn"
                        class="flex items-center justify-center w-full px-4 py-2 text-white transition rounded-md bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg id="spinner" class="hidden w-5 h-5 mr-2 text-white spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span id="buttonText">Verify Email</span>
                </button>
            </form>

            <!-- Resend Code Section -->
            <div class="flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}" class="inline">
                    @csrf
                    <button type="submit" id="resendBtn" class="text-sm text-primary-600 hover:underline dark:text-primary-400 disabled:opacity-50 disabled:cursor-not-allowed">
                        Resend Verification Code
                    </button>
                </form>
                
                <span id="countdown" class="text-sm font-mono text-gray-500 dark:text-gray-400">05:00</span>
            </div>
            


            <!-- Profile and Logout -->
            <div class="flex items-center justify-center space-x-6 pt-2">
                <button type="button" id="changeEmailBtn" class="text-sm text-purple-600 hover:underline dark:text-purple-400">
                    <i class="fas fa-edit mr-1"></i>
                    <span id="changeEmailBtnText">Change Email</span>
                </button>
                
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:underline dark:text-red-400">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            const countdownEl = document.getElementById('countdown');
            const resendBtn = document.getElementById('resendBtn');
            const verifyBtn = document.getElementById('verifyBtn');
            let countdown = 300; // 5 minutes in seconds
            let timer;

            // Auto-hide success alert after 2 seconds
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 2000);
            }

            // Start countdown timer
            function startCountdown(disableButton = true) {
                clearInterval(timer);
                countdown = 300;
                if (disableButton) {
                    resendBtn.disabled = true;
                }
                updateCountdownDisplay();

                timer = setInterval(() => {
                    countdown--;
                    updateCountdownDisplay();

                    if (countdown <= 0) {
                        clearInterval(timer);
                        resendBtn.disabled = false;
                        countdownEl.textContent = 'Expired';
                        countdownEl.classList.add('text-red-500', 'dark:text-red-400');
                        countdownEl.classList.remove('text-gray-500', 'dark:text-gray-400');
                    }
                }, 1000);
            }
            
            // Start countdown immediately for the initial email (but keep button clickable)
            startCountdown(false);

            // Update countdown display
            function updateCountdownDisplay() {
                const minutes = Math.floor(countdown / 60);
                const seconds = countdown % 60;
                countdownEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                // Change color to red when 1 minute or less
                if (countdown <= 60) {
                    countdownEl.classList.remove('text-gray-500', 'dark:text-gray-400');
                    countdownEl.classList.add('text-red-500', 'dark:text-red-400');
                } else {
                    countdownEl.classList.remove('text-red-500', 'dark:text-red-400');
                    countdownEl.classList.add('text-gray-500', 'dark:text-gray-400');
                }
            }

            // Mode management
            let isEmailMode = false;
            const mainInput = document.getElementById('mainInput');
            const inputLabel = document.getElementById('inputLabel');
            const mainBtn = document.getElementById('mainBtn');
            const buttonText = document.getElementById('buttonText');
            const changeEmailBtn = document.getElementById('changeEmailBtn');
            const changeEmailBtnText = document.getElementById('changeEmailBtnText');
            const inputError = document.getElementById('inputError');
            const spinner = document.getElementById('spinner');
            
            function switchToEmailMode() {
                isEmailMode = true;
                mainInput.type = 'email';
                mainInput.removeAttribute('maxlength');
                mainInput.name = 'email';
                mainInput.value = '{{ Auth::user()->email }}';
                mainInput.placeholder = 'Enter your email address';
                mainInput.className = 'w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white';
                inputLabel.textContent = 'Email Address';
                buttonText.textContent = 'Save & Verify Email';
                changeEmailBtnText.innerHTML = '<i class="fas fa-arrow-left mr-1"></i>Back to Code';
                inputError.classList.add('hidden');
                setTimeout(() => mainInput.select(), 100);
            }
            
            function switchToCodeMode() {
                isEmailMode = false;
                mainInput.type = 'text';
                mainInput.setAttribute('maxlength', '6');
                mainInput.name = 'code';
                mainInput.value = '';
                mainInput.placeholder = '000000';
                mainInput.className = 'w-full px-3 py-2 mt-1 text-center text-2xl tracking-widest border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white';
                inputLabel.textContent = 'Verification Code';
                buttonText.textContent = 'Verify Email';
                changeEmailBtnText.innerHTML = '<i class="fas fa-edit mr-1"></i>Change Email';
                inputError.classList.add('hidden');
            }
            
            // Handle main form submission
            const verificationForm = document.querySelector('form[action="{{ route('verification.verify') }}"]');
            if (verificationForm) {
                verificationForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (isEmailMode) {
                        handleEmailChange();
                    } else {
                        handleCodeVerification();
                    }
                });
            }
            
            function handleEmailChange() {
                const newEmail = mainInput.value.trim();
                const currentEmail = '{{ Auth::user()->email }}';
                
                if (!newEmail || !newEmail.includes('@')) {
                    showInputError('Please enter a valid email address');
                    return;
                }
                
                if (newEmail === currentEmail) {
                    showInputError('Please enter a different email address');
                    return;
                }
                
                showLoading('Saving...');
                
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("email.change") }}';
                form.style.display = 'none';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                const emailInput = document.createElement('input');
                emailInput.type = 'hidden';
                emailInput.name = 'email';
                emailInput.value = newEmail;
                
                form.appendChild(csrfInput);
                form.appendChild(emailInput);
                document.body.appendChild(form);
                
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route("email.change") }}', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Accept', 'application/json');
                
                xhr.onload = function() {
                    document.body.removeChild(form);
                    hideLoading();
                    
                    if (xhr.status === 200) {
                        const data = JSON.parse(xhr.responseText);
                        if (data.success) {
                            switchToCodeMode();
                            showSuccessMessage(`Email changed successfully! A verification code has been sent to ${newEmail}. Please enter the code above to verify your new email address.`);
                            startCountdown(true);
                            const titleSpan = document.querySelector('h2 span');
                            if (titleSpan) {
                                titleSpan.textContent = `Enter the 6-digit code sent to ${newEmail}`;
                            }
                        } else {
                            showInputError(data.message || 'Error changing email. Please try again.');
                        }
                    } else {
                        showInputError('Error changing email. Please check your connection and try again.');
                    }
                };
                
                xhr.onerror = function() {
                    document.body.removeChild(form);
                    hideLoading();
                    showInputError('Error changing email. Please check your connection and try again.');
                };
                
                const formData = new FormData(form);
                xhr.send(formData);
            }
            
            function handleCodeVerification() {
                const code = mainInput.value.trim();
                
                if (!code || code.length !== 6) {
                    showInputError('Please enter a valid 6-digit verification code');
                    return;
                }
                
                showLoading('Verifying...');
                
                // Ensure proper form submission
                mainInput.name = 'code';
                verificationForm.submit();
            }
            
            function showLoading(text) {
                spinner.classList.remove('hidden');
                buttonText.textContent = text;
                mainBtn.disabled = true;
            }
            
            function hideLoading() {
                spinner.classList.add('hidden');
                buttonText.textContent = isEmailMode ? 'Save & Verify Email' : 'Verify Email';
                mainBtn.disabled = false;
            }
            
            function showInputError(message) {
                inputError.textContent = message;
                inputError.classList.remove('hidden');
            }

            // Handle resend button click
            if (resendBtn) {
                resendBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Submit the form to send verification code
                    const resendForm = resendBtn.closest('form');
                    const formData = new FormData(resendForm);
                    
                    fetch(resendForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Show success message
                        showSuccessMessage('A new verification code has been sent to your email address.');
                        // Restart countdown and disable button
                        startCountdown(true);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Still restart countdown and disable button even if there's an error
                        startCountdown(true);
                    });
                });
            }
            
            // Change Email button functionality
            changeEmailBtn.addEventListener('click', function() {
                if (isEmailMode) {
                    switchToCodeMode();
                } else {
                    switchToEmailMode();
                }
            });

            // Function to show success message
            function showSuccessMessage(message) {
                // Create or update success alert
                let successAlert = document.getElementById('successAlert');
                if (!successAlert) {
                    successAlert = document.createElement('div');
                    successAlert.id = 'successAlert';
                    successAlert.className = 'p-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-md dark:text-green-400 dark:bg-green-900 dark:border-green-700 mb-4';
                    // Insert after the title
                    const title = document.querySelector('h2');
                    title.parentNode.insertBefore(successAlert, title.nextSibling);
                }
                
                successAlert.innerHTML = `<div class="flex items-start"><i class="fas fa-check-circle mr-2 mt-0.5"></i><span>${message}</span></div>`;
                successAlert.style.display = 'block';
                
                // Hide after 8 seconds
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 8000);
            }


        });
    </script>
</x-guest-layout>
