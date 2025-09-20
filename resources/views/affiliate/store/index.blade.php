<x-affiliate-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Check if user has a store -->
            @if(!$store)
            <div id="noStoreSection" class="text-center py-12">
                <div class="bg-white rounded-lg shadow-sm p-8 dark:bg-gray-800">
                    <div class="mx-auto w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-store text-3xl text-indigo-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Create Your Store</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                        Set up your own digital marketplace store to showcase and sell your assets to customers worldwide.
                    </p>
                    <button id="createStoreBtn" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Create My Store
                    </button>
                </div>
            </div>
            
            <!-- Create Store Modal -->
            <div id="createStoreModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full dark:bg-gray-800 max-h-[90vh] overflow-hidden flex flex-col">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Create Your Store</h3>
                        </div>
                        
                        <form class="p-6 space-y-6 overflow-y-auto flex-1" style="scrollbar-width: thin;">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Name</label>
                                <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Enter your store name" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Handle</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none">@</span>
                                    <input type="text" name="handle" class="w-full pl-8 pr-10 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-600" placeholder="your-store-handle" pattern="[a-zA-Z0-9]+" title="Only letters and numbers allowed" readonly>
                                    <button type="button" id="editHandleBtn" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Only letters and numbers allowed. This will be your store's unique identifier.</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Description</label>
                                <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Describe what your store offers..."></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store URL Preview</label>
                                <div class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:border-gray-600 dark:bg-gray-600 text-gray-500">
                                    <span id="urlPreview">{{ config('app.url') }}/@your-store-handle</span>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700 mt-6">
                                <button type="button" id="cancelStoreBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create Store</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @else
            <!-- Store Dashboard -->
            <div id="storeSection">
                <!-- Store Header -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 mb-6 dark:bg-gray-800">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-store text-lg sm:text-2xl text-indigo-600"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 dark:text-white truncate">{{ $store->name }}</h1>
                                <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    <span class="block sm:inline">Store URL:</span>
                                    <span id="storeUrl" class="block sm:inline break-all text-xs cursor-pointer hover:text-indigo-600 transition-colors" onclick="copyStoreUrl()" title="Click to copy URL">{{ config('app.url') }}/{{ $store->handle }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <a href="{{ config('app.url') }}/{{ $store->handle }}" target="_blank" class="flex-1 sm:flex-none px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-center text-xs sm:text-sm">
                                <i class="fas fa-eye mr-1"></i><span class="hidden xs:inline">Preview </span>Store
                            </a>
                            <a href="{{ route('affiliate.store.settings') }}" class="flex-1 sm:flex-none px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-center text-xs sm:text-sm">
                                <i class="fas fa-cog mr-1"></i>Settings
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Store Stats -->
                <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-4">
                    <x-widgets.affiliate.store.store-visits />
                    <div class="bg-white rounded-lg shadow-sm p-6 dark:bg-gray-800">
                        <h6 class="text-sm font-medium text-gray-500 uppercase dark:text-gray-400">Total Sales</h6>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">$4,892</h3>
                        <p class="text-sm text-green-600">+8% from last month</p>
                    </div>
                    <x-widgets.affiliate.store.active-products />
                    <div class="bg-white rounded-lg shadow-sm p-6 dark:bg-gray-800">
                        <h6 class="text-sm font-medium text-gray-500 uppercase dark:text-gray-400">Customers</h6>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">156</h3>
                        <p class="text-sm text-green-600">+15 new this month</p>
                    </div>
                </div>

                <!-- Store Management Tabs -->
                <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <nav class="flex space-x-4 sm:space-x-8 px-4 sm:px-6 overflow-x-auto">
                            <button class="py-4 px-1 border-b-2 border-indigo-500 font-medium text-sm text-indigo-600 tab-btn active whitespace-nowrap" data-tab="products">
                                Products
                            </button>

                        </nav>
                    </div>

                    <!-- Tab Contents -->
                    <div class="p-4 sm:p-6">
                        <div id="products" class="tab-content">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Store Products</h3>
                                <button id="addProductBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                    <i class="fas fa-plus mr-2"></i>Add Product
                                </button>
                            </div>
                            <div class="space-y-4" id="productsGrid">
                                <!-- Products will be loaded here -->
                            </div>
                        </div>








                    </div>
                </div>
            </div>
            @endif

            <!-- Add Category Modal -->
            <div id="addCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full dark:bg-gray-800">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Category</h3>
                        </div>
                        
                        <form id="addCategoryForm" class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                                <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                            </div>
                            
                            <div class="flex justify-end space-x-4">
                                <button type="button" id="cancelCategoryBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add Product Modal -->
            <div id="addProductModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full dark:bg-gray-800 max-h-[90vh] overflow-y-auto">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Product</h3>
                        </div>
                        
                        <form id="addProductForm" class="p-6 space-y-6" enctype="multipart/form-data">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Name</label>
                                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price ($)</label>
                                    <input type="number" name="price" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Type</label>
                                <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                                    <option value="digital">Digital Product</option>
                                    <option value="physical">Physical Product</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tags</label>
                                <input type="text" name="tags" placeholder="Enter tags separated by commas (e.g., web, template, modern)" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                                <p class="text-xs text-gray-500 mt-1">Separate multiple tags with commas</p>
                            </div>
                            
                            <div id="stockField" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Stock Quantity</label>
                                <input type="number" name="stock_quantity" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Status</label>
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" checked class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-white">Active (visible to customers)</label>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Images (up to 10)</label>
                                <input type="file" name="images[]" id="productImages" multiple accept="image/*" max="10" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <div id="imagePreview" class="mt-3 grid grid-cols-2 md:grid-cols-3 gap-3"></div>
                            </div>
                            
                            <div id="digitalFileField">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Digital File (for digital products)</label>
                                <input type="file" name="digital_file" id="digitalFile" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <div id="digitalFilePreview" class="mt-3"></div>
                            </div>
                            
                            <div class="flex justify-end space-x-4">
                                <button type="button" id="cancelProductBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('styles')
<style>
    /* Thin scrollbar for modal */
    #createStoreModal form::-webkit-scrollbar {
        width: 3px;
    }
    
    #createStoreModal form::-webkit-scrollbar-track {
        background: transparent;
    }
    
    #createStoreModal form::-webkit-scrollbar-thumb {
        background-color: rgba(107, 114, 128, 0.6);
        border-radius: 2px;
    }
    
    .dark #createStoreModal form::-webkit-scrollbar-thumb {
        background-color: rgba(55, 65, 81, 0.8);
    }
    
    #createStoreModal form::-webkit-scrollbar-thumb:hover {
        background-color: rgba(107, 114, 128, 0.9);
    }
</style>
@endpush

@push('scripts')
    <script>
        // Store management functionality
        function initializeStoreManagement() {
            // Get elements
            const createStoreBtn = document.getElementById('createStoreBtn');
            const createStoreModal = document.getElementById('createStoreModal');
            const cancelStoreBtn = document.getElementById('cancelStoreBtn');
            const nameInput = document.querySelector('input[name="name"]');
            const handleInput = document.querySelector('input[name="handle"]');
            const editHandleBtn = document.getElementById('editHandleBtn');
            const urlPreview = document.getElementById('urlPreview');
            
            console.log('Initializing store management...', {
                createStoreBtn: !!createStoreBtn,
                createStoreModal: !!createStoreModal,
                cancelStoreBtn: !!cancelStoreBtn
            });

            // Show modal
            if (createStoreBtn) {
                createStoreBtn.onclick = function(e) {
                    e.preventDefault();
                    console.log('Opening modal...');
                    if (createStoreModal) {
                        createStoreModal.classList.remove('hidden');
                    }
                };
            }

            // Hide modal
            if (cancelStoreBtn) {
                cancelStoreBtn.onclick = function(e) {
                    e.preventDefault();
                    if (createStoreModal) {
                        createStoreModal.classList.add('hidden');
                    }
                };
            }

            // Close modal on backdrop click
            if (createStoreModal) {
                createStoreModal.onclick = function(e) {
                    if (e.target === createStoreModal) {
                        createStoreModal.classList.add('hidden');
                    }
                };
            }

            // Auto-generate handle from name
            if (nameInput && handleInput) {
                nameInput.oninput = function() {
                    if (!handleInput.value) { // Only auto-generate if handle is empty
                        const handle = this.value.toLowerCase()
                            .replace(/[^a-z0-9]/g, '')
                            .substring(0, 20);
                        handleInput.value = handle;
                        updateUrlPreview(handle);
                    }
                };
            }

            // Edit handle functionality
            if (editHandleBtn && handleInput) {
                function enableEdit() {
                    handleInput.readOnly = false;
                    handleInput.classList.remove('bg-gray-50', 'dark:bg-gray-600');
                    handleInput.classList.add('bg-white', 'dark:bg-gray-700');
                    handleInput.focus();
                    editHandleBtn.innerHTML = '<i class="fas fa-check text-green-500"></i>';
                    editHandleBtn.onclick = saveEdit;
                }
                
                function saveEdit() {
                    handleInput.readOnly = true;
                    handleInput.classList.remove('bg-white', 'dark:bg-gray-700');
                    handleInput.classList.add('bg-gray-50', 'dark:bg-gray-600');
                    handleInput.blur();
                    editHandleBtn.innerHTML = '<i class="fas fa-edit"></i>';
                    editHandleBtn.onclick = enableEdit;
                }
                
                editHandleBtn.onclick = enableEdit;
            }
            
            // Handle input validation and URL preview
            if (handleInput && urlPreview) {
                handleInput.oninput = function() {
                    // Remove invalid characters and @ symbol if user tries to type it
                    this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
                    updateUrlPreview(this.value);
                };
                
                // Prevent @ symbol deletion and ensure cursor positioning
                handleInput.onkeydown = function(e) {
                    // Prevent backspace/delete if cursor is at position 0 (before @)
                    if ((e.key === 'Backspace' || e.key === 'Delete') && this.selectionStart === 0) {
                        e.preventDefault();
                    }
                };
            }
            
            function updateUrlPreview(handle) {
                if (urlPreview) {
                    urlPreview.textContent = handle ? `{{ config('app.url') }}/@${handle}` : '{{ config('app.url') }}/@your-store-handle';
                }
            }

            // Form submission
            const createForm = document.querySelector('#createStoreModal form');
            if (createForm) {
                createForm.onsubmit = async function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    
                    // Disable submit button
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Creating...';
                    }
                    
                    try {
                        const response = await fetch('{{ route("affiliate.store.create") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            window.location.reload();
                        } else {
                            alert('Error: ' + result.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred while creating the store.');
                    } finally {
                        // Re-enable submit button
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Create Store';
                        }
                    }
                };
            }

            // Initialize tab functionality
            function initializeTabs() {
                const tabBtns = document.querySelectorAll('.tab-btn');
                const tabContents = document.querySelectorAll('.tab-content');

                tabBtns.forEach(btn => {
                    btn.onclick = function(e) {
                        e.preventDefault();
                        const tabId = this.dataset.tab;
                        
                        console.log('Tab clicked:', tabId);
                        
                        // Update active tab button
                        tabBtns.forEach(b => {
                            b.classList.remove('border-indigo-500', 'text-indigo-600');
                            b.classList.add('border-transparent', 'text-gray-500');
                        });
                        this.classList.remove('border-transparent', 'text-gray-500');
                        this.classList.add('border-indigo-500', 'text-indigo-600');
                        
                        // Update active tab content
                        tabContents.forEach(content => {
                            content.classList.add('hidden');
                        });
                        
                        const targetTab = document.getElementById(tabId);
                        if (targetTab) {
                            targetTab.classList.remove('hidden');
                            console.log('Showing tab:', tabId);
                            
                            // Load data when tab becomes visible
                            if (tabId === 'products') {
                                loadProducts();
                            }
                        } else {
                            console.log('Tab not found:', tabId);
                        }
                    };
                });
                
                // Show products tab by default
                const productsTab = document.getElementById('products');
                if (productsTab && !productsTab.classList.contains('hidden')) {
                    // Products is already visible
                    loadProducts();
                } else if (productsTab) {
                    productsTab.classList.remove('hidden');
                    loadProducts();
                }
            }
            
            // Initialize tabs
            initializeTabs();
            
            // Load initial stats
            loadProducts();



            // Product management
            const addProductBtn = document.getElementById('addProductBtn');
            const addProductModal = document.getElementById('addProductModal');
            const cancelProductBtn = document.getElementById('cancelProductBtn');
            const addProductForm = document.getElementById('addProductForm');
            const typeSelect = document.querySelector('select[name="type"]');
            const stockField = document.getElementById('stockField');
            const digitalFileField = document.getElementById('digitalFileField');

            if (addProductBtn) {
                addProductBtn.onclick = function() {
                    addProductModal.classList.remove('hidden');
                };
            }

            if (cancelProductBtn) {
                cancelProductBtn.onclick = function() {
                    addProductModal.classList.add('hidden');
                    addProductForm.reset();
                };
            }

            if (addProductModal) {
                addProductModal.onclick = function(e) {
                    if (e.target === addProductModal) {
                        addProductModal.classList.add('hidden');
                        addProductForm.reset();
                    }
                };
            }

            // Toggle fields based on product type
            if (typeSelect) {
                typeSelect.onchange = function() {
                    if (this.value === 'physical') {
                        stockField.classList.remove('hidden');
                        digitalFileField.classList.add('hidden');
                    } else {
                        stockField.classList.add('hidden');
                        digitalFileField.classList.remove('hidden');
                    }
                };
            }
            
            // Image preview functionality
            const productImages = document.getElementById('productImages');
            const imagePreview = document.getElementById('imagePreview');
            const digitalFile = document.getElementById('digitalFile');
            const digitalFilePreview = document.getElementById('digitalFilePreview');
            
            if (productImages) {
                productImages.onchange = function(e) {
                    const files = Array.from(e.target.files).slice(0, 10); // Limit to 10 images
                    imagePreview.innerHTML = '';
                    
                    files.forEach((file, index) => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const div = document.createElement('div');
                                div.className = 'relative group';
                                div.innerHTML = `
                                    <img src="${e.target.result}" class="w-full h-20 object-cover rounded-lg border">
                                    <button type="button" onclick="removeImage(${index})" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                        ×
                                    </button>
                                `;
                                imagePreview.appendChild(div);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                };
            }
            
            if (digitalFile) {
                digitalFile.onchange = function(e) {
                    const file = e.target.files[0];
                    digitalFilePreview.innerHTML = '';
                    
                    if (file) {
                        const div = document.createElement('div');
                        div.className = 'flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg';
                        div.innerHTML = `
                            <i class="fas fa-file text-gray-400 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">${file.name}</p>
                                <p class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                            </div>
                        `;
                        digitalFilePreview.appendChild(div);
                    }
                };
            }
            
            // Remove image function
            window.removeImage = function(index) {
                const input = document.getElementById('productImages');
                const dt = new DataTransfer();
                const files = Array.from(input.files);
                
                files.forEach((file, i) => {
                    if (i !== index) dt.items.add(file);
                });
                
                input.files = dt.files;
                input.dispatchEvent(new Event('change'));
            };

            // Add/Edit product form submission
            if (addProductForm) {
                addProductForm.onsubmit = async function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const editId = this.dataset.editId;
                    const isEdit = !!editId;
                    
                    // Add is_active as 1 or 0
                    formData.set('is_active', document.querySelector('input[name="is_active"]').checked ? '1' : '0');
                    
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = isEdit ? 'Updating...' : 'Adding...';
                    }
                    
                    try {
                        const url = isEdit 
                            ? `{{ route('affiliate.store.products.index') }}/${editId}`
                            : '{{ route("affiliate.store.products.store") }}';
                        const method = isEdit ? 'PUT' : 'POST';
                        
                        if (isEdit) {
                            formData.append('_method', 'PUT');
                        }
                        
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            alert(isEdit ? 'Product updated successfully!' : 'Product added successfully!');
                            addProductModal.classList.add('hidden');
                            this.reset();
                            delete this.dataset.editId;
                            document.querySelector('#addProductModal h3').textContent = 'Add New Product';
                            document.querySelector('#addProductForm button[type="submit"]').textContent = 'Add Product';
                            imagePreview.innerHTML = '';
                            digitalFilePreview.innerHTML = '';
                            loadProducts();
                        } else {
                            alert('Error: ' + result.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred while ' + (isEdit ? 'updating' : 'adding') + ' the product.');
                    } finally {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.textContent = isEdit ? 'Update Product' : 'Add Product';
                        }
                    }
                };
            }

            // Load products function
            async function loadProducts() {
                try {
                    const response = await fetch('{{ route("affiliate.store.products.index") }}', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        displayProducts(result.products);
                    }
                } catch (error) {
                    console.error('Error loading products:', error);
                }
            }
            

            
            // Display products function
            function displayProducts(products) {
                const productsGrid = document.getElementById('productsGrid');
                if (!productsGrid) return;
                
                if (products.length === 0) {
                    productsGrid.innerHTML = `
                        <div class="text-center py-12">
                            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-box-open text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No products yet</h3>
                            <p class="text-gray-600 dark:text-gray-400">Start by adding your first product to your store.</p>
                        </div>
                    `;
                    return;
                }
                
                productsGrid.innerHTML = products.map(product => `
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
                                ${product.images && product.images.length > 0 
                                    ? `<img src="${product.images[0]}" alt="${product.name}" class="w-full h-full object-cover">` 
                                    : `<div class="w-full h-full flex items-center justify-center"><i class="fas fa-image text-xl text-gray-400"></i></div>`
                                }
                            </div>
                            <div class="ml-4 flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-medium text-gray-900 dark:text-white text-sm truncate">${product.name}</h4>
                                    <span class="px-2 py-1 text-xs rounded-full ml-2 ${
                                        product.type === 'digital' 
                                            ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' 
                                            : 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200'
                                    }">${product.type}</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 line-clamp-1">${product.description || 'No description'}</p>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-bold text-gray-900 dark:text-white">$${parseFloat(product.price).toFixed(2)}</span>
                                        ${product.type === 'physical' && product.stock_quantity !== null 
                                            ? `<span class="text-xs text-gray-500 ml-2">${product.stock_quantity} in stock</span>` 
                                            : ''
                                        }
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="editProduct('${product.id}')" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteProduct('${product.id}')" class="text-red-600 hover:text-red-800 text-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
            }
            
            // Edit product function
            window.editProduct = async function(productId) {
                try {
                    const response = await fetch(`{{ route('affiliate.store.products.index') }}/${productId}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        const product = result.product;
                        
                        // Populate form fields
                        document.querySelector('input[name="name"]').value = product.name;
                        document.querySelector('input[name="price"]').value = product.price;
                        document.querySelector('textarea[name="description"]').value = product.description || '';
                        document.querySelector('select[name="type"]').value = product.type;
                        document.querySelector('input[name="tags"]').value = product.tags ? product.tags.join(', ') : '';
                        document.querySelector('input[name="is_active"]').checked = product.is_active;
                        
                        if (product.type === 'physical') {
                            document.querySelector('input[name="stock_quantity"]').value = product.stock_quantity || '';
                            stockField.classList.remove('hidden');
                            digitalFileField.classList.add('hidden');
                        } else {
                            stockField.classList.add('hidden');
                            digitalFileField.classList.remove('hidden');
                        }
                        
                        // Change form to edit mode
                        addProductForm.dataset.editId = productId;
                        document.querySelector('#addProductModal h3').textContent = 'Edit Product';
                        document.querySelector('#addProductForm button[type="submit"]').textContent = 'Update Product';
                        
                        addProductModal.classList.remove('hidden');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while loading the product.');
                }
            };
            
            // Delete product function
            window.deleteProduct = async function(productId) {
                if (!confirm('Are you sure you want to delete this product?')) return;
                
                try {
                    const response = await fetch(`{{ route('affiliate.store.products.index') }}/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        alert('Product deleted successfully!');
                        loadProducts();
                    } else {
                        alert('Error: ' + result.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the product.');
                }
            };
            
            // Category management
            const addCategoryBtn = document.getElementById('addCategoryBtn');
            const addCategoryModal = document.getElementById('addCategoryModal');
            const cancelCategoryBtn = document.getElementById('cancelCategoryBtn');
            const addCategoryForm = document.getElementById('addCategoryForm');

            if (addCategoryBtn) {
                addCategoryBtn.onclick = function() {
                    addCategoryModal.classList.remove('hidden');
                };
            }

            if (cancelCategoryBtn) {
                cancelCategoryBtn.onclick = function() {
                    addCategoryModal.classList.add('hidden');
                    addCategoryForm.reset();
                };
            }

            if (addCategoryModal) {
                addCategoryModal.onclick = function(e) {
                    if (e.target === addCategoryModal) {
                        addCategoryModal.classList.add('hidden');
                        addCategoryForm.reset();
                    }
                };
            }

            // Add category form submission
            if (addCategoryForm) {
                addCategoryForm.onsubmit = async function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Adding...';
                    }
                    
                    try {
                        const response = await fetch('{{ route("affiliate.store.categories.store") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            alert('Category added successfully!');
                            addCategoryModal.classList.add('hidden');
                            this.reset();
                            loadCategories();
                            loadCategoryOptions();
                        } else {
                            alert('Error: ' + result.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred while adding the category.');
                    } finally {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Add Category';
                        }
                    }
                };
            }

            // Load categories function
            async function loadCategories() {
                try {
                    const response = await fetch('{{ route("affiliate.store.categories.index") }}', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        displayCategories(result.categories);
                    }
                } catch (error) {
                    console.error('Error loading categories:', error);
                }
            }

            // Display categories function
            function displayCategories(categories) {
                const categoriesGrid = document.getElementById('categoriesGrid');
                if (!categoriesGrid) return;
                
                if (categories.length === 0) {
                    categoriesGrid.innerHTML = `
                        <div class="col-span-full text-center py-12">
                            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-tags text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No categories yet</h3>
                            <p class="text-gray-600 dark:text-gray-400">Create categories to organize your products.</p>
                        </div>
                    `;
                    return;
                }
                
                categoriesGrid.innerHTML = categories.map(category => `
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-900 dark:text-white">${category.name}</h4>
                            <button onclick="deleteCategory('${category.id}')" class="text-red-600 hover:text-red-800 text-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">${category.description || 'No description'}</p>
                        <p class="text-xs text-gray-500">${category.products_count || 0} products</p>
                    </div>
                `).join('');
            }

            // Load category options for product form
            async function loadCategoryOptions() {
                try {
                    const response = await fetch('{{ route("affiliate.store.categories.index") }}', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        const categorySelect = document.getElementById('categorySelect');
                        if (categorySelect) {
                            categorySelect.innerHTML = '<option value="">Select Category</option>' + 
                                result.categories.map(category => 
                                    `<option value="${category.name}">${category.name}</option>`
                                ).join('');
                        }
                    }
                } catch (error) {
                    console.error('Error loading category options:', error);
                }
            }

            // Delete category function
            window.deleteCategory = async function(categoryId) {
                if (!confirm('Are you sure you want to delete this category?')) return;
                
                try {
                    const response = await fetch(`{{ route('affiliate.store.categories.index') }}/${categoryId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        alert('Category deleted successfully!');
                        loadCategories();
                        loadCategoryOptions();
                    } else {
                        alert('Error: ' + result.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the category.');
                }
            };



            // Customization form
            const customizationForm = document.getElementById('customizationForm');
            if (customizationForm) {
                customizationForm.onsubmit = async function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Uploading...';
                    }
                    
                    try {
                        const response = await fetch('{{ route("affiliate.store.upload-images") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            alert('Images uploaded successfully!');
                            window.location.reload();
                        } else {
                            alert('Error: ' + result.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred while uploading images.');
                    } finally {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Save Images';
                        }
                    }
                };
            }
        }

        // Copy store URL function
        window.copyStoreUrl = function() {
            const storeUrl = document.getElementById('storeUrl');
            const url = storeUrl.textContent.trim();
            
            navigator.clipboard.writeText(url).then(() => {
                // Show success feedback
                const originalText = storeUrl.textContent;
                storeUrl.textContent = 'Copied!';
                storeUrl.classList.add('text-green-600');
                
                setTimeout(() => {
                    storeUrl.textContent = originalText;
                    storeUrl.classList.remove('text-green-600');
                }, 1500);
            }).catch(() => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                const originalText = storeUrl.textContent;
                storeUrl.textContent = 'Copied!';
                storeUrl.classList.add('text-green-600');
                
                setTimeout(() => {
                    storeUrl.textContent = originalText;
                    storeUrl.classList.remove('text-green-600');
                }, 1500);
            });
        };
        


        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeStoreManagement);
        } else {
            initializeStoreManagement();
        }
    </script>
    @endpush
</x-affiliate-layout>