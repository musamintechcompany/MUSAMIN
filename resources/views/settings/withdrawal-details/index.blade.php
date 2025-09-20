<x-app-layout>
    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div class="sticky top-0 flex items-center justify-between py-2 mb-6 bg-white dark:bg-gray-800">
                        <div class="flex items-center">
                            <button onclick="window.history.back()" class="mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Withdrawal Bank Details</h2>
                        </div>
                        <button onclick="showAddBankModal()" class="inline-flex items-center px-4 py-2 text-white transition duration-200 bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="mr-2 fas fa-plus"></i>
                            Add
                        </button>
                    </div>

                    <!-- Bank Accounts List -->
                    <div id="bankAccountsList" class="space-y-4">
                        <!-- Empty State -->
                        <div id="emptyState" class="py-12 text-center">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full dark:bg-gray-700">
                                <i class="text-2xl text-gray-400 fas fa-university"></i>
                            </div>
                            <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-gray-100">No Bank Accounts Added</h3>
                            <p class="mb-4 text-gray-600 dark:text-gray-300">Add your account which you would like to withdraw your funds to</p>
                            <button onclick="showAddBankModal()" class="inline-flex items-center px-4 py-2 text-white transition duration-200 bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <i class="mr-2 fas fa-plus"></i>
                                Add Bank Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bank Account Modal -->
    <div id="addBankModal" class="fixed inset-0 items-center justify-center hidden p-4 bg-black bg-opacity-50" style="z-index: 9999999;">
        <div class="w-full max-w-md bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Bank Account</h3>
                    <button onclick="hideAddBankModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="addBankForm" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Bank Name</label>
                        <input type="text" name="bank_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Account Name</label>
                        <input type="text" name="account_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Account Number</label>
                        <input type="text" name="account_number" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Routing Number (Optional)</label>
                        <input type="text" name="routing_number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Swift Code (Optional)</label>
                        <input type="text" name="swift_code" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    
                    <div class="flex justify-end pt-4 space-x-3">
                        <button type="button" onclick="hideAddBankModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Add Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Bank Account Modal -->
    <div id="editBankModal" class="fixed inset-0 items-center justify-center hidden p-4 bg-black bg-opacity-50" style="z-index: 9999999;">
        <div class="w-full max-w-md bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Bank Account</h3>
                    <button onclick="hideEditBankModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="editBankForm" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="bank_id" id="editBankId">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Bank Name</label>
                        <input type="text" name="bank_name" id="editBankName" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Account Name</label>
                        <input type="text" name="account_name" id="editAccountName" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Account Number</label>
                        <input type="text" name="account_number" id="editAccountNumber" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Routing Number (Optional)</label>
                        <input type="text" name="routing_number" id="editRoutingNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Swift Code (Optional)</label>
                        <input type="text" name="swift_code" id="editSwiftCode" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    
                    <div class="flex justify-end pt-4 space-x-3">
                        <button type="button" onclick="hideEditBankModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Update Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let bankAccounts = [];

        document.addEventListener('DOMContentLoaded', function() {
            loadBankAccounts();
        });

        function showAddBankModal() {
            document.getElementById('addBankModal').classList.remove('hidden');
            document.getElementById('addBankModal').classList.add('flex');
        }

        function hideAddBankModal() {
            document.getElementById('addBankModal').classList.add('hidden');
            document.getElementById('addBankModal').classList.remove('flex');
            document.getElementById('addBankForm').reset();
        }

        function showEditBankModal(account) {
            document.getElementById('editBankId').value = account.id;
            document.getElementById('editBankName').value = account.bank_name;
            document.getElementById('editAccountName').value = account.account_name;
            document.getElementById('editAccountNumber').value = account.account_number;
            document.getElementById('editRoutingNumber').value = account.routing_number || '';
            document.getElementById('editSwiftCode').value = account.swift_code || '';
            
            document.getElementById('editBankModal').classList.remove('hidden');
            document.getElementById('editBankModal').classList.add('flex');
        }

        function hideEditBankModal() {
            document.getElementById('editBankModal').classList.add('hidden');
            document.getElementById('editBankModal').classList.remove('flex');
        }

        function loadBankAccounts() {
            fetch('{{ route("settings.withdrawal-bank.list") }}')
                .then(response => response.json())
                .then(data => {
                    bankAccounts = data.accounts || [];
                    renderBankAccounts();
                })
                .catch(error => {
                    console.error('Error loading bank accounts:', error);
                });
        }

        function renderBankAccounts() {
            const container = document.getElementById('bankAccountsList');
            const emptyState = document.getElementById('emptyState');
            
            if (bankAccounts.length === 0) {
                emptyState.style.display = 'block';
                return;
            }
            
            emptyState.style.display = 'none';
            
            const accountsHtml = bankAccounts.map(account => `
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 dark:text-white">${account.bank_name}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-300">${account.account_name}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">****${account.account_number.slice(-4)}</p>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="showEditBankModal(${JSON.stringify(account).replace(/"/g, '&quot;')})" class="p-2 text-indigo-600 hover:text-indigo-800">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteBankAccount(${account.id})" class="p-2 text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
            
            container.innerHTML = accountsHtml;
        }

        document.getElementById('addBankForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("settings.withdrawal-bank.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    hideAddBankModal();
                    loadBankAccounts();
                    alert('Bank account added successfully!');
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        document.getElementById('editBankForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const bankId = document.getElementById('editBankId').value;
            
            fetch(`/settings/withdrawal-bank/${bankId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    hideEditBankModal();
                    loadBankAccounts();
                    alert('Bank account updated successfully!');
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        function deleteBankAccount(id) {
            if (confirm('Are you sure you want to delete this bank account?')) {
                fetch(`/settings/withdrawal-bank/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadBankAccounts();
                        alert('Bank account deleted successfully!');
                    } else {
                        alert('Error: ' + (data.message || 'Something went wrong'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            }
        }
    </script>
    @endpush
</x-app-layout>