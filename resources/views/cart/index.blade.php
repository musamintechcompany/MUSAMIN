<x-app-layout>
    <div class="container p-4 mx-auto max-w-4xl">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm min-h-[70vh]">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Shopping Cart</h1>
                <i class="fas fa-shopping-cart text-gray-500 dark:text-gray-400"></i>
            </div>
            
            <div id="cartItems" class="divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Cart items will be populated by JavaScript -->
            </div>
            
            <div id="cartEmpty" class="text-center py-16 hidden">
                <i class="fas fa-shopping-cart text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Your cart is empty</h3>
                <p class="text-gray-500 dark:text-gray-400">Add some items to get started</p>
            </div>
            
            @auth
            <!-- Address Section -->
            <div id="addressSection" class="border-t border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-700 hidden">
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium text-gray-900 dark:text-white">Delivery Address</h3>
                        @if(!auth()->user()->address || !auth()->user()->country || !auth()->user()->state)
                            <button onclick="showAddressModal()" class="text-sm bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700">
                                Add Address
                            </button>
                        @endif
                    </div>
                    
                    <div id="currentAddress" class="text-sm text-gray-600 dark:text-gray-400">
                        @if(auth()->user()->address && auth()->user()->country && auth()->user()->state)
                            <p><strong>{{ auth()->user()->name }}</strong></p>
                            <p>{{ auth()->user()->address }}</p>
                            <p>{{ auth()->user()->state }}, {{ auth()->user()->country }}</p>
                            <button onclick="showAddressModal()" class="text-blue-600 hover:text-blue-700 text-xs mt-1">
                                Use different address
                            </button>
                        @else
                            <p class="text-red-500">Please add your delivery address to continue</p>
                        @endif
                    </div>
                </div>
                
                <!-- Shipping Cost -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Shipping Cost (USD)
                    </label>
                    <input type="number" id="shippingCost" step="0.01" min="0" value="0" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
            </div>
            @endauth
            
            <div id="cartSummary" class="border-t border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-700 hidden">
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                        <span id="cartSubtotal" class="font-medium text-gray-900 dark:text-white">$0.00</span>
                    </div>
                    @auth
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                        <span id="cartShipping" class="font-medium text-gray-900 dark:text-white">$0.00</span>
                    </div>
                    @endauth
                    <div class="flex justify-between text-lg font-semibold border-t border-gray-200 dark:border-gray-600 pt-2">
                        <span class="text-gray-900 dark:text-white">Total:</span>
                        <span id="cartTotal" class="text-gray-900 dark:text-white">$0.00</span>
                    </div>
                    @auth
                        <div class="text-center">
                            <span id="cartCoins" class="text-xs text-gray-500 dark:text-gray-400">0 coins</span>
                        </div>
                    @endauth
                </div>
                
                <div class="flex gap-3">
                    <button onclick="clearCart()" class="flex-1 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 py-2 px-4 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">
                        Clear Cart
                    </button>
                    <button onclick="proceedToCheckout()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let cartItems = [];

        function loadCart() {
            @auth
                // For authenticated users, get cart from server
                fetch('/cart', {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cartItems = data.items;
                        renderCart();
                        updateCartBadge(cartItems.length);
                    }
                });
            @else
                // For guests, use session storage
                const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                cartItems = Object.values(sessionCart);
                renderCart();
                updateCartBadge(cartItems.length);
            @endauth
        }

        function renderCart() {
            const cartItemsContainer = document.getElementById('cartItems');
            const cartEmpty = document.getElementById('cartEmpty');
            const cartSummary = document.getElementById('cartSummary');
            
            if (cartItems.length === 0) {
                cartItemsContainer.innerHTML = '';
                cartEmpty.classList.remove('hidden');
                cartSummary.classList.add('hidden');
                @auth
                    document.getElementById('addressSection').classList.add('hidden');
                @endauth
                return;
            }
            
            cartEmpty.classList.add('hidden');
            cartSummary.classList.remove('hidden');
            @auth
                document.getElementById('addressSection').classList.remove('hidden');
            @endauth
            
            cartItemsContainer.innerHTML = cartItems.map(item => `
                <div class="p-4 flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                        ${item.image ? 
                            `<img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover rounded-lg">` :
                            `<i class="fas fa-box text-gray-400 text-xl"></i>`
                        }
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-medium text-gray-900 dark:text-white truncate">${item.name}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">by ${item.store_name}</p>
                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">$${parseFloat(item.price).toFixed(2)}</p>
                        <div class="flex items-center mt-2 space-x-1">
                            <button onclick="updateQuantity('${item.id}', ${item.quantity - 1})" class="w-6 h-6 flex items-center justify-center bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-300 dark:hover:bg-gray-500" ${item.quantity <= 1 ? 'disabled' : ''}>
                                <i class="fas fa-minus" style="font-size: 8px;"></i>
                            </button>
                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded text-xs font-medium min-w-[24px] text-center">${item.quantity}</span>
                            <button onclick="updateQuantity('${item.id}', ${item.quantity + 1})" class="w-6 h-6 flex items-center justify-center bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-300 dark:hover:bg-gray-500">
                                <i class="fas fa-plus" style="font-size: 8px;"></i>
                            </button>
                        </div>
                    </div>
                    <button onclick="removeFromCart('${item.id}')" class="text-red-500 hover:text-red-700 p-2">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `).join('');
            
            updateTotals();
        }

        function updateTotals() {
            const subtotal = cartItems.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
            @auth
                const shippingCost = parseFloat(document.getElementById('shippingCost')?.value || 0);
                const total = subtotal + shippingCost;
                
                document.getElementById('cartShipping').textContent = `$${shippingCost.toFixed(2)}`;
            @else
                const total = subtotal;
            @endauth
            
            document.getElementById('cartSubtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('cartTotal').textContent = `$${total.toFixed(2)}`;
            
            @auth
                const coinsEquivalent = Math.ceil(total * 100); // Assuming 1 USD = 100 coins
                document.getElementById('cartCoins').textContent = `${coinsEquivalent} coins`;
            @endauth
        }
        
        @auth
        // Update totals when shipping cost changes
        document.addEventListener('DOMContentLoaded', function() {
            const shippingInput = document.getElementById('shippingCost');
            if (shippingInput) {
                shippingInput.addEventListener('input', updateTotals);
            }
        });
        @endauth

        function updateQuantity(productId, newQuantity) {
            if (newQuantity < 1) return;
            
            // Optimistic UI update - update immediately
            const item = cartItems.find(item => item.id == productId);
            const oldQuantity = item ? item.quantity : 0;
            
            if (item) {
                item.quantity = newQuantity;
                renderCart();
                
                // Update session storage for guests
                @guest
                    const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                    if (sessionCart[productId]) {
                        sessionCart[productId].quantity = newQuantity;
                        sessionStorage.setItem('cart', JSON.stringify(sessionCart));
                    }
                @endguest
            }
            
            // Send to server in background
            fetch('/cart/update-quantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ product_id: productId, quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Revert optimistic update on error
                    if (item) {
                        item.quantity = oldQuantity;
                        renderCart();
                        
                        @guest
                            const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                            if (sessionCart[productId]) {
                                sessionCart[productId].quantity = oldQuantity;
                                sessionStorage.setItem('cart', JSON.stringify(sessionCart));
                            }
                        @endguest
                    }
                }
            })
            .catch(() => {
                // Revert optimistic update on network error
                if (item) {
                    item.quantity = oldQuantity;
                    renderCart();
                    
                    @guest
                        const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                        if (sessionCart[productId]) {
                            sessionCart[productId].quantity = oldQuantity;
                            sessionStorage.setItem('cart', JSON.stringify(sessionCart));
                        }
                    @endguest
                }
            });
        }

        function removeFromCart(productId) {
            // Optimistic UI update - remove immediately
            const removedItem = cartItems.find(item => item.id == productId);
            cartItems = cartItems.filter(item => item.id != productId);
            renderCart();
            
            // Update session storage for guests
            @guest
                const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                delete sessionCart[productId];
                sessionStorage.setItem('cart', JSON.stringify(sessionCart));
            @endguest
            
            updateCartBadge(cartItems.length);
            
            // Send to server in background
            fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Revert optimistic update on error
                    if (removedItem) {
                        cartItems.push(removedItem);
                        renderCart();
                        
                        @guest
                            const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                            sessionCart[productId] = removedItem;
                            sessionStorage.setItem('cart', JSON.stringify(sessionCart));
                        @endguest
                        
                        updateCartBadge(cartItems.length);
                    }
                }
            })
            .catch(() => {
                // Revert optimistic update on network error
                if (removedItem) {
                    cartItems.push(removedItem);
                    renderCart();
                    
                    @guest
                        const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                        sessionCart[productId] = removedItem;
                        sessionStorage.setItem('cart', JSON.stringify(sessionCart));
                    @endguest
                    
                    updateCartBadge(cartItems.length);
                }
            });
        }

        function clearCart() {
            showClearCartPopup();
        }
        
        function showClearCartPopup() {
            const popup = document.createElement('div');
            popup.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center';
            popup.style.zIndex = '9999999';
            popup.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-sm mx-4 shadow-xl">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Clear Cart</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Are you sure you want to clear all items from your cart?</p>
                    <div class="flex gap-3">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                        <button onclick="confirmClearCart(this)" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Clear Cart
                        </button>
                    </div>
                </div>
            `;
            popup.onclick = (e) => { if (e.target === popup) popup.remove(); };
            document.body.appendChild(popup);
        }
        
        function confirmClearCart(button) {
            fetch('/cart/clear', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    sessionStorage.removeItem('cart');
                    loadCart();
                }
            });
            button.closest('.fixed').remove();
        }

        function proceedToCheckout() {
            if (cartItems.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            @auth
                // Check if address is complete
                @if(!auth()->user()->address || !auth()->user()->country || !auth()->user()->state)
                    alert('Please add your delivery address first.');
                    showAddressModal();
                    return;
                @endif
                
                const subtotal = cartItems.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
                const shippingCost = parseFloat(document.getElementById('shippingCost').value || 0);
                const total = subtotal + shippingCost;
                const coinsNeeded = Math.ceil(total * 100);
                
                // Check user's coin balance
                fetch('/user/coin-balance')
                    .then(response => response.json())
                    .then(data => {
                        if (data.balance >= coinsNeeded) {
                            showCheckoutModal();
                        } else {
                            showInsufficientCoinsPopup(data.balance, coinsNeeded);
                        }
                    })
                    .catch(() => {
                        alert('Error checking coin balance. Please try again.');
                    });
            @else
                window.location.href = '/login?redirect=' + encodeURIComponent('{{ route('cart.index') }}');
            @endauth
        }
        
        @auth
        function showInsufficientCoinsPopup(currentBalance, coinsNeeded) {
            const popup = document.createElement('div');
            popup.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            popup.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-sm mx-4 shadow-xl">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Insufficient Coins</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Sorry, you do not have enough coins in your wallet.</p>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Your balance: <span class="font-medium text-gray-900 dark:text-white">${currentBalance} coins</span></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Required: <span class="font-medium text-red-600">${coinsNeeded} coins</span></p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                        <a href="{{ route('coin-packages.index') }}" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center">
                            Buy Coins
                        </a>
                    </div>
                </div>
            `;
            popup.onclick = (e) => { if (e.target === popup) popup.remove(); };
            document.body.appendChild(popup);
        }
        @endauth

        function updateCartBadge(count) {
            const cartBadge = document.getElementById('cartBadge');
            if (cartBadge) {
                if (count > 0) {
                    cartBadge.textContent = count > 99 ? '99+' : count;
                    cartBadge.style.display = 'flex';
                } else {
                    cartBadge.style.display = 'none';
                }
            }
        }

        @auth
        function showAddressModal() {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4 shadow-xl w-full">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Delivery Address</h3>
                    <form id="addressForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                            <input type="text" id="deliveryName" value="{{ auth()->user()->name }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input type="email" id="deliveryEmail" value="{{ auth()->user()->email }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone (Optional)</label>
                            <input type="tel" id="deliveryPhone" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                            <textarea id="deliveryAddress" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" rows="2">{{ auth()->user()->address }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                                <input type="text" id="deliveryCity" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Postal Code</label>
                                <input type="text" id="deliveryPostal" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">State</label>
                                <input type="text" id="deliveryState" value="{{ auth()->user()->state }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country</label>
                                <input type="text" id="deliveryCountry" value="{{ auth()->user()->country }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes (Optional)</label>
                            <textarea id="deliveryNotes" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" rows="2" placeholder="Special delivery instructions..."></textarea>
                        </div>
                    </form>
                    <div class="flex gap-3 mt-6">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                        <button onclick="saveAddressAndContinue(this)" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Continue
                        </button>
                    </div>
                </div>
            `;
            modal.onclick = (e) => { if (e.target === modal) modal.remove(); };
            document.body.appendChild(modal);
        }
        
        function saveAddressAndContinue(button) {
            const form = document.getElementById('addressForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            button.disabled = true;
            button.textContent = 'Saving...';
            
            const addressData = {
                address: document.getElementById('deliveryAddress').value,
                state: document.getElementById('deliveryState').value,
                country: document.getElementById('deliveryCountry').value
            };
            
            // Save address to user profile
            fetch('/user/update-address', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(addressData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Store full address data for checkout
                    window.checkoutAddress = {
                        name: document.getElementById('deliveryName').value,
                        email: document.getElementById('deliveryEmail').value,
                        phone: document.getElementById('deliveryPhone').value,
                        address: document.getElementById('deliveryAddress').value,
                        city: document.getElementById('deliveryCity').value,
                        state: document.getElementById('deliveryState').value,
                        country: document.getElementById('deliveryCountry').value,
                        postal_code: document.getElementById('deliveryPostal').value,
                        notes: document.getElementById('deliveryNotes').value
                    };
                    
                    button.closest('.fixed').remove();
                    location.reload(); // Refresh to show updated address
                } else {
                    alert('Failed to save address: ' + data.message);
                    button.disabled = false;
                    button.textContent = 'Continue';
                }
            })
            .catch(error => {
                alert('Error saving address. Please try again.');
                button.disabled = false;
                button.textContent = 'Continue';
            });
        }
        
        function showCheckoutModal() {
            const subtotal = cartItems.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
            const shippingCost = parseFloat(document.getElementById('shippingCost').value || 0);
            const total = subtotal + shippingCost;
            const coinsNeeded = Math.ceil(total * 100);
            
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4 shadow-xl">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Confirm Order</h3>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                            <span class="font-medium text-gray-900 dark:text-white">$${subtotal.toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                            <span class="font-medium text-gray-900 dark:text-white">$${shippingCost.toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold border-t border-gray-200 dark:border-gray-600 pt-2">
                            <span class="text-gray-900 dark:text-white">Total:</span>
                            <span class="text-gray-900 dark:text-white">$${total.toFixed(2)} (${coinsNeeded} coins)</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Your order will be processed and sellers will be notified.</p>
                    <div class="flex gap-3">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                        <button onclick="confirmCheckout(this)" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Place Order
                        </button>
                    </div>
                </div>
            `;
            modal.onclick = (e) => { if (e.target === modal) modal.remove(); };
            document.body.appendChild(modal);
        }
        
        function confirmCheckout(button) {
            button.disabled = true;
            button.textContent = 'Processing...';
            
            const addressData = window.checkoutAddress || {
                name: '{{ auth()->user()->name }}',
                email: '{{ auth()->user()->email }}',
                phone: '',
                address: '{{ auth()->user()->address }}',
                city: '',
                state: '{{ auth()->user()->state }}',
                country: '{{ auth()->user()->country }}',
                postal_code: '',
                notes: ''
            };
            
            const checkoutData = {
                shipping_cost: parseFloat(document.getElementById('shippingCost').value || 0),
                delivery_name: addressData.name,
                delivery_email: addressData.email,
                delivery_phone: addressData.phone,
                delivery_address: addressData.address,
                delivery_city: addressData.city,
                delivery_state: addressData.state,
                delivery_country: addressData.country,
                delivery_postal_code: addressData.postal_code,
                notes: addressData.notes
            };
            
            fetch('/cart/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(checkoutData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.closest('.fixed').remove();
                    alert('Order placed successfully! Order numbers: ' + data.orders.join(', '));
                    loadCart();
                } else {
                    alert('Error: ' + data.message);
                    button.disabled = false;
                    button.textContent = 'Place Order';
                }
            })
            .catch(error => {
                alert('Checkout failed. Please try again.');
                button.disabled = false;
                button.textContent = 'Place Order';
            });
        }
        

        @endauth
        
        document.addEventListener('DOMContentLoaded', loadCart);
    </script>
    @endpush
</x-app-layout>