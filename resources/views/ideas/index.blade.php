<x-app-layout>
    @push('styles')
        <style>
            :root {
                --primary-blue: #3498db;
                --dark-blue: #2980b9;
                --black: #2c3e50;
                --light-black: #34495e;
                --purple: #9b59b6;
                --light-purple: #be90d4;
                --white: #ecf0f1;
                --gray: #bdc3c7;
                --success-green: #2ecc71;
                --card-bg: white;
                --border-color: #ddd;
                --text-color: #2c3e50;
                --hint-color: #666;
            }

            .dark {
                --primary-text: #f9fafb;
                --secondary-text: #d1d5db;
                --bg-color: #111827;
                --card-bg: #1f2937;
                --coin-bg: rgba(245, 158, 11, 0.1);
                --coin-border: rgba(245, 158, 11, 0.3);
                --white: #111827;
                --border-color: #374151;
                --text-color: #f9fafb;
                --hint-color: #9ca3af;
                --gray: #4b5563;
                --light-black: #f3f4f6;
                --black: #f9fafb;
            }

            @media (prefers-color-scheme: dark) {
                :root:not(.light) {
                    --primary-text: #f9fafb;
                    --secondary-text: #d1d5db;
                    --bg-color: #111827;
                    --card-bg: #1f2937;
                    --coin-bg: rgba(245, 158, 11, 0.1);
                    --coin-border: rgba(245, 158, 11, 0.3);
                    --white: #111827;
                    --border-color: #374151;
                    --text-color: #f9fafb;
                    --hint-color: #9ca3af;
                    --gray: #4b5563;
                    --light-black: #f3f4f6;
                    --black: #f9fafb;
                }
            }

            .idea-page {
                background-color: white;
                color: var(--text-color);
                line-height: 1.6;
                min-height: 100vh;
                transition: background-color 0.3s, color 0.3s;
            }
            
            .dark .idea-page {
                background-color: #111827;
            }

            .idea-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .idea-header {
                background: linear-gradient(135deg, var(--black), var(--purple));
                color: white;
                padding: 3rem 0;
                text-align: center;
                border-radius: 0 0 20px 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                margin-bottom: 2rem;
                position: relative;
                overflow: hidden;
                min-height: 220px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .idea-header::before {
                content: "";
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
                transform: rotate(30deg);
                pointer-events: none;
            }

            .idea-title {
                font-size: 2.8rem;
                margin-bottom: 1rem;
                position: relative;
                text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            }

            .idea-subtitle {
                font-size: 1.25rem;
                opacity: 0.9;
                max-width: 700px;
                margin: 0 auto;
                position: relative;
            }

            .rotating-message {
                position: absolute;
                width: 100%;
                text-align: center;
                padding: 0 20px;
                opacity: 0;
                transition: all 0.8s ease;
                transform: translateX(50px);
            }

            .rotating-message.active {
                opacity: 1;
                transform: translateX(0);
            }

            .rotating-message.fade-out {
                opacity: 0;
                transform: translateX(-50px);
            }

            .rotating-message h3 {
                font-size: 1.8rem;
                margin-bottom: 0.5rem;
                color: white;
            }

            .rotating-message p {
                font-size: 1.1rem;
                max-width: 700px;
                margin: 0 auto;
            }

            .idea-form {
                background: var(--card-bg);
                border-radius: 15px;
                padding: 2.5rem;
                box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
                margin-bottom: 3rem;
                position: relative;
                z-index: 1;
                border: 1px solid var(--border-color);
                transition: all 0.3s;
            }

            .form-group {
                margin-bottom: 1.75rem;
                position: relative;
            }

            .form-label {
                display: block;
                margin-bottom: 0.75rem;
                font-weight: 600;
                color: var(--light-black);
                font-size: 1.05rem;
            }

            .form-control {
                width: 100%;
                padding: 14px;
                border: 2px solid var(--gray);
                border-radius: 10px;
                font-size: 1rem;
                transition: all 0.3s ease;
                background-color: var(--card-bg);
                color: var(--text-color);
            }

            .form-control:focus {
                border-color: var(--primary-blue);
                outline: none;
                box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            }

            textarea.form-control {
                min-height: 180px;
                resize: vertical;
                line-height: 1.7;
            }

            .idea-btn {
                display: inline-block;
                background: linear-gradient(to right, var(--primary-blue), var(--purple));
                color: white;
                border: none;
                padding: 14px 28px;
                font-size: 1.05rem;
                font-weight: 600;
                border-radius: 10px;
                cursor: pointer;
                transition: all 0.3s ease;
                text-transform: uppercase;
                letter-spacing: 1px;
                position: relative;
                overflow: hidden;
            }

            .idea-btn::after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: 0.5s;
            }

            .idea-btn:hover {
                background: linear-gradient(to right, var(--dark-blue), var(--light-purple));
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }

            .idea-btn:hover::after {
                left: 100%;
            }

            .step-indicator {
                display: flex;
                justify-content: space-between;
                margin-bottom: 2rem;
                position: relative;
            }

            .step {
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                z-index: 1;
            }

            .step-number {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background-color: var(--gray);
                color: var(--text-color);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                margin-bottom: 0.5rem;
                transition: all 0.3s;
            }

            .step.active .step-number {
                background-color: var(--primary-blue);
                color: white;
            }

            .step.completed .step-number {
                background-color: var(--success-green);
                color: white;
            }

            .step-title {
                font-size: 0.9rem;
                color: var(--light-black);
                text-align: center;
            }

            .step-indicator::before {
                content: '';
                position: absolute;
                top: 20px;
                left: 0;
                right: 0;
                height: 2px;
                background-color: var(--gray);
                z-index: 0;
            }

            .step-progress {
                position: absolute;
                top: 20px;
                left: 0;
                height: 2px;
                background-color: var(--primary-blue);
                z-index: 1;
                transition: width 0.3s;
            }

            .form-step {
                display: none;
                animation: fadeIn 0.5s ease;
            }

            .form-step.active {
                display: block;
            }

            .phone-input-container {
                display: flex;
                gap: 10px;
            }

            .country-code {
                flex: 0 0 120px;
            }

            .phone-number {
                flex: 1;
            }

            .upload-hint {
                font-size: 14px;
                color: var(--hint-color);
                margin-top: 5px;
            }

            .popup-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.7);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s;
            }

            .popup-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .contact-popup, .thank-you-popup {
                background: var(--card-bg);
                padding: 30px;
                border-radius: 15px;
                width: 90%;
                max-width: 500px;
                box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
                border: 1px solid var(--border-color);
            }

            .thank-you-popup {
                text-align: center;
            }

            .thank-you-popup h2 {
                color: var(--success-green);
                margin-bottom: 20px;
            }

            .success-message {
                display: none;
                background-color: var(--success-green);
                color: white;
                padding: 1.5rem;
                border-radius: 10px;
                margin-bottom: 2rem;
                text-align: center;
                animation: fadeIn 0.5s ease;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .char-counter {
                font-size: 0.85rem;
                color: var(--light-black);
                text-align: right;
                margin-top: 0.5rem;
                opacity: 0.7;
            }

            @media (max-width: 992px) {
                .idea-title {
                    font-size: 2.4rem;
                }

                .idea-subtitle {
                    font-size: 1.15rem;
                }
            }

            @media (max-width: 768px) {
                .idea-header {
                    padding: 2.5rem 0;
                    min-height: 180px;
                }

                .idea-title {
                    font-size: 2.2rem;
                }

                .rotating-message h3 {
                    font-size: 1.5rem;
                }

                .rotating-message p {
                    font-size: 1rem;
                }

                .idea-form {
                    padding: 2rem;
                }

                .step-title {
                    display: none;
                }
            }

            @media (max-width: 576px) {
                .idea-title {
                    font-size: 1.8rem;
                }

                .idea-subtitle {
                    font-size: 1rem;
                }

                .idea-header {
                    min-height: 160px;
                }

                .rotating-message h3 {
                    font-size: 1.3rem;
                }

                .rotating-message p {
                    font-size: 0.9rem;
                }

                .idea-form {
                    padding: 1.5rem;
                }

                .idea-btn {
                    width: 100%;
                }

                .phone-input-container {
                    flex-direction: column;
                }

                .country-code, .phone-number {
                    width: 100%;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dbTheme = "{{ auth()->user()->theme }}";
                if (dbTheme) {
                    applyTheme(dbTheme);
                    localStorage.setItem('theme', dbTheme);
                }

                function applyTheme(theme) {
                    const html = document.documentElement;
                    html.classList.remove('light', 'dark');
                    html.classList.add(theme);
                }

                const formSteps = document.querySelectorAll('.form-step');
                const stepIndicator = document.querySelector('.step-indicator');
                const stepProgress = document.querySelector('.step-progress');
                const steps = document.querySelectorAll('.step');
                let currentStep = 0;

                updateProgress();
                showStep(currentStep);

                document.querySelectorAll('.next-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (validateStep(currentStep)) {
                            currentStep++;
                            showStep(currentStep);
                            updateProgress();
                        }
                    });
                });

                document.querySelectorAll('.prev-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        currentStep--;
                        showStep(currentStep);
                        updateProgress();
                    });
                });

                function showStep(stepIndex) {
                    formSteps.forEach((step, index) => {
                        step.classList.toggle('active', index === stepIndex);
                    });

                    steps.forEach((step, index) => {
                        if (index < stepIndex) {
                            step.classList.add('completed');
                            step.classList.remove('active');
                        } else if (index === stepIndex) {
                            step.classList.add('active');
                            step.classList.remove('completed');
                        } else {
                            step.classList.remove('active', 'completed');
                        }
                    });
                }

                function updateProgress() {
                    const progress = (currentStep / (steps.length - 1)) * 100;
                    stepProgress.style.width = `${progress}%`;
                }

                function validateStep(stepIndex) {
                    let isValid = true;
                    const currentStepFields = formSteps[stepIndex].querySelectorAll('[required]');
                    currentStepFields.forEach(field => {
                        if (!field.value.trim()) {
                            field.style.borderColor = '#e74c3c';
                            isValid = false;

                            if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-message')) {
                                const errorMsg = document.createElement('div');
                                errorMsg.className = 'error-message';
                                errorMsg.style.color = '#e74c3c';
                                errorMsg.style.fontSize = '0.85rem';
                                errorMsg.style.marginTop = '0.25rem';
                                errorMsg.textContent = 'This field is required';
                                field.parentNode.insertBefore(errorMsg, field.nextSibling);
                            }
                        } else {
                            field.style.borderColor = '';
                            if (field.nextElementSibling && field.nextElementSibling.classList.contains('error-message')) {
                                field.nextElementSibling.remove();
                            }
                        }
                    });

                    if (stepIndex === 0) {
                        const description = document.getElementById('description');
                        if (description.value.trim().length < 20) {
                            description.style.borderColor = '#e74c3c';
                            isValid = false;

                            if (!description.nextElementSibling || !description.nextElementSibling.classList.contains('error-message')) {
                                const errorMsg = document.createElement('div');
                                errorMsg.className = 'error-message';
                                errorMsg.style.color = '#e74c3c';
                                errorMsg.style.fontSize = '0.85rem';
                                errorMsg.style.marginTop = '0.25rem';
                                errorMsg.textContent = 'Please provide at least 20 characters';
                                description.parentNode.insertBefore(errorMsg, description.nextSibling);
                            }
                        }
                    }

                    return isValid;
                }

                const description = document.getElementById('description');
                const charCounter = document.createElement('div');
                charCounter.className = 'char-counter';
                description.parentNode.appendChild(charCounter);

                function updateCounter() {
                    const remaining = 2000 - description.value.length;
                    charCounter.textContent = `${description.value.length}/2000 characters`;

                    if (remaining < 50) {
                        charCounter.style.color = '#e74c3c';
                    } else {
                        charCounter.style.color = '';
                    }
                }

                description.addEventListener('input', updateCounter);
                updateCounter();

                document.getElementById('media').addEventListener('change', function(e) {
                    const files = e.target.files;
                    const maxSize = 10 * 1024 * 1024;

                    for (let i = 0; i < files.length; i++) {
                        if (files[i].size > maxSize) {
                            alert(`File "${files[i].name}" exceeds the 10MB size limit`);
                            e.target.value = '';
                            return;
                        }
                    }
                });

                document.getElementById('ideaForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (validateStep(currentStep)) {
                        // Update review content before showing contact popup
                        updateReviewContent();
                        document.getElementById('contactPopup').classList.add('active');
                    }
                });
                
                function updateReviewContent() {
                    const reviewDiv = document.getElementById('review-content');
                    const title = document.getElementById('idea-title').value;
                    const category = document.getElementById('category').value;
                    const description = document.getElementById('description').value;
                    const benefits = document.getElementById('benefits').value;
                    
                    reviewDiv.innerHTML = `
                        <h4><strong>Title:</strong> ${title}</h4>
                        <p><strong>Category:</strong> ${category}</p>
                        <p><strong>Description:</strong> ${description}</p>
                        ${benefits ? `<p><strong>Benefits:</strong> ${benefits}</p>` : ''}
                    `;
                }

                document.getElementById('contactForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const email = document.getElementById('email').value.trim();
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        alert('Please enter a valid email address');
                        return;
                    }

                    const phone = document.getElementById('phone').value.trim();
                    if (phone.length < 7 || !/^[\d\s\-()+]+$/.test(phone)) {
                        alert('Please enter a valid phone number');
                        return;
                    }

                    // Submit the idea to the server
                    submitIdea();
                });
                
                function submitIdea() {
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    formData.append('title', document.getElementById('idea-title').value);
                    formData.append('category', document.getElementById('category').value);
                    formData.append('description', document.getElementById('description').value);
                    formData.append('benefits', document.getElementById('benefits').value);
                    formData.append('additional_info', document.getElementById('additional-info').value);
                    formData.append('contact_email', document.getElementById('email').value);
                    formData.append('contact_phone', document.getElementById('phone').value);
                    formData.append('country_code', document.getElementById('countryCode').value);
                    
                    // Add media files
                    const mediaFiles = document.getElementById('media').files;
                    for (let i = 0; i < mediaFiles.length; i++) {
                        formData.append('media[]', mediaFiles[i]);
                    }
                    
                    fetch('{{ route("ideas.store") }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('contactPopup').classList.remove('active');
                            document.getElementById('thankYouPopup').classList.add('active');
                        } else {
                            alert('Error submitting idea: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error submitting idea. Please try again.');
                    });
                }

                document.getElementById('okButton').addEventListener('click', function() {
                    document.getElementById('thankYouPopup').classList.remove('active');
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 300);
                });

                const messages = [
                    {
                        title: "Share Your Vision",
                        content: "Have a brilliant website or app idea? We want to hear it! Submit your concept and help shape the future of our platform."
                    },
                    {
                        title: "Fuel Innovation",
                        content: "Your creative ideas drive our platform forward. We're always looking for fresh perspectives to enhance our offerings."
                    },
                    {
                        title: "Potential Implementation",
                        content: "Exceptional ideas may be developed into actual products, with credit and rewards for the original thinkers."
                    },
                    {
                        title: "Confidential Process",
                        content: "All submissions are treated as confidential. We respect your intellectual property and creative input."
                    }
                ];

                const headerContent = document.querySelector('.idea-header');
                messages.forEach((message, index) => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `rotating-message message-${index}`;
                    messageDiv.innerHTML = `
                        <h3>${message.title}</h3>
                        <p>${message.content}</p>
                    `;
                    headerContent.appendChild(messageDiv);
                });

                const messageElements = document.querySelectorAll('.rotating-message');
                messageElements[0].classList.add('active');
                let currentIndex = 0;

                function rotateMessages() {
                    messageElements[currentIndex].classList.add('fade-out');
                    messageElements[currentIndex].classList.remove('active');
                    currentIndex = (currentIndex + 1) % messages.length;
                    setTimeout(() => {
                        messageElements[currentIndex].classList.remove('fade-out');
                        messageElements[currentIndex].classList.add('active');
                    }, 800);
                    setTimeout(() => {
                        messageElements.forEach(el => el.classList.remove('fade-out'));
                    }, 1600);
                }

                setInterval(rotateMessages, 4000);

                const countryCodeSelect = document.getElementById('countryCode');
                const userLang = navigator.language || navigator.userLanguage;
                const countryCode = userLang.split('-')[1];

                if (countryCode) {
                    const optionToSelect = countryCodeSelect.querySelector(`option[value="+${getCountryCode(countryCode)}"]`);
                    if (optionToSelect) {
                        optionToSelect.selected = true;
                    }
                }
            });

            function getCountryCode(country) {
                const codes = {
                    'US': '1', 'GB': '44', 'AU': '61', 'DE': '49',
                    'FR': '33', 'JP': '81', 'CN': '86', 'IN': '91',
                    'NG': '234', 'CA': '1', 'BR': '55', 'ZA': '27',
                    'KE': '254', 'GH': '233', 'EG': '20', 'MX': '52'
                };
                return codes[country] || '1';
            }
        </script>
    @endpush

    <div class="idea-page">
        <div class="idea-header">
            <div class="idea-container">
            </div>
        </div>

        <div class="idea-container">
            <form class="idea-form" id="ideaForm">
                @csrf

                <div class="step-indicator">
                    <div class="step-progress"></div>
                    <div class="step active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-title">Idea Details</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-title">Supporting Media</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-title">Review & Submit</div>
                    </div>
                </div>

                <div class="form-step active" data-step="1">
                    <div class="form-group">
                        <label for="idea-title" class="form-label">Idea Title</label>
                        <input type="text" id="idea-title" class="form-control" placeholder="A clear, concise title for your idea" required>
                    </div>

                    <div class="form-group">
                        <label for="category" class="form-label">Category</label>
                        <select id="category" class="form-control" required>
                            <option value="">Select a category</option>
                            <option value="product">Product Idea</option>
                            <option value="service">Service Improvement</option>
                            <option value="feature">New Feature</option>
                            <option value="process">Process Improvement</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Detailed Description</label>
                        <textarea id="description" class="form-control" placeholder="Describe your idea in detail. What problem does it solve? How would it work? Who would benefit?" maxlength="2000" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="benefits" class="form-label">Potential Benefits</label>
                        <textarea id="benefits" class="form-control" placeholder="What value would this idea bring to users or the business?"></textarea>
                    </div>

                    <div class="form-group" style="text-align: right;">
                        <button type="button" class="idea-btn next-btn">Continue →</button>
                    </div>
                </div>

                <div class="form-step" data-step="2">
                    <div class="form-group">
                        <label for="media" class="form-label">Upload Supporting Files</label>
                        <input type="file" id="media" class="form-control" accept="image/*, video/*" multiple>
                        <p class="upload-hint">You may upload images or videos that help illustrate your idea (Max 10MB per file).</p>
                    </div>

                    <div class="form-group">
                        <label for="additional-info" class="form-label">Additional Information</label>
                        <textarea id="additional-info" class="form-control" placeholder="Any other details that might help us understand your idea better"></textarea>
                    </div>

                    <div class="form-group" style="display: flex; justify-content: space-between;">
                        <button type="button" class="idea-btn prev-btn" style="width: 48%;">← Previous</button>
                        <button type="button" class="idea-btn next-btn" style="width: 48%;">Continue →</button>
                    </div>
                </div>

                <div class="form-step" data-step="3">
                    <div class="form-group">
                        <h3 style="margin-bottom: 1rem;">Review Your Idea</h3>
                        <div id="review-content" style="background: rgba(0,0,0,0.05); padding: 1.5rem; border-radius: 8px;"></div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="idea-btn">Submit Idea</button>
                    </div>

                    <div class="form-group" style="text-align: left;">
                        <button type="button" class="idea-btn prev-btn">← Previous</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="contactPopup">
        <div class="contact-popup">
            <h2>How Can We Reach You?</h2>
            <p>Please provide your contact information so we can discuss your idea with you.</p>

            <form id="contactForm">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter the email address you want us to use to contact you">
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <div class="phone-input-container">
                        <select id="countryCode" class="country-code form-control" name="countryCode">
                            <option value="+1">+1 (US/Canada)</option>
                            <option value="+44">+44 (UK)</option>
                            <option value="+61">+61 (Australia)</option>
                            <option value="+49">+49 (Germany)</option>
                            <option value="+33">+33 (France)</option>
                            <option value="+81">+81 (Japan)</option>
                            <option value="+86">+86 (China)</option>
                            <option value="+91">+91 (India)</option>
                            <option value="+234">+234 (Nigeria)</option>
                            <option value="+27">+27 (South Africa)</option>
                            <option value="+254">+254 (Kenya)</option>
                            <option value="+233">+233 (Ghana)</option>
                        </select>
                        <input type="tel" id="phone" class="phone-number form-control" name="phone" required placeholder="Your phone number">
                    </div>
                </div>

                <button type="submit" class="idea-btn">Submit Contact Information</button>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="thankYouPopup">
        <div class="thank-you-popup">
            <h2>Thank You For Your Submission</h2>
            <p>We've received your idea and will review it shortly.</p>
            <p>Our team will contact you using the information you provided.</p>
            <button id="okButton" class="idea-btn">Okay</button>
        </div>
    </div>
</x-app-layout>
