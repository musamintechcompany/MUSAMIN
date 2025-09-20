<x-admin-layout title="Send Emails">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Send Emails</h1>
            <p class="text-gray-600 dark:text-gray-400">Send emails to users using templates</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <form action="{{ route('admin.email-sender.send') }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <div>
                    <label for="template_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Template</label>
                    <select name="template_id" id="template_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Select Template</option>
                        @foreach($templates as $template)
                            <option value="{{ $template->id }}">{{ $template->name }} ({{ ucfirst($template->type) }})</option>
                        @endforeach
                    </select>
                    @error('template_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recipients</label>
                    <div class="mt-2 space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="recipient_type" value="single" class="mr-2" required>
                            <span>Single Email</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="recipient_type" value="all" class="mr-2" required>
                            <span>All Users</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="recipient_type" value="filtered" class="mr-2" required>
                            <span>Selected Users</span>
                        </label>
                    </div>
                </div>

                <div id="singleEmailField" style="display: none;">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div id="userSearchField" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search Users</label>
                    <input type="text" id="userSearch" placeholder="Type to search users..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <div id="userResults" class="mt-2 max-h-40 overflow-y-auto border rounded-md hidden"></div>
                    <div id="selectedUsers" class="mt-2"></div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Variables (Optional)</label>
                    <div id="variableFields" class="mt-2 space-y-2">
                        <div class="flex space-x-2">
                            <input type="text" placeholder="Variable name (e.g., company)" class="flex-1 rounded-md border-gray-300">
                            <input type="text" placeholder="Value" class="flex-1 rounded-md border-gray-300">
                            <button type="button" onclick="addVariable()" class="px-3 py-2 bg-blue-600 text-white rounded-md">+</button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">Send Emails</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="recipient_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('singleEmailField').style.display = this.value === 'single' ? 'block' : 'none';
                document.getElementById('userSearchField').style.display = this.value === 'filtered' ? 'block' : 'none';
            });
        });

        let selectedUserIds = [];

        document.getElementById('userSearch')?.addEventListener('input', function() {
            const query = this.value;
            if (query.length > 2) {
                fetch(`{{ route('admin.coin-manager.search-users') }}?q=${query}`)
                    .then(response => response.json())
                    .then(users => {
                        const results = document.getElementById('userResults');
                        results.innerHTML = '';
                        results.classList.remove('hidden');
                        
                        users.forEach(user => {
                            const div = document.createElement('div');
                            div.className = 'p-2 hover:bg-gray-100 cursor-pointer border-b';
                            div.innerHTML = `${user.name} (${user.email})`;
                            div.onclick = () => selectUser(user);
                            results.appendChild(div);
                        });
                    });
            }
        });

        function selectUser(user) {
            if (!selectedUserIds.includes(user.id)) {
                selectedUserIds.push(user.id);
                const selectedDiv = document.getElementById('selectedUsers');
                const userTag = document.createElement('span');
                userTag.className = 'inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm mr-2 mb-2';
                userTag.innerHTML = `${user.name} <button type="button" onclick="removeUser(${user.id}, this)" class="ml-1 text-red-600">×</button>`;
                selectedDiv.appendChild(userTag);
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'user_ids[]';
                input.value = user.id;
                input.id = `user_${user.id}`;
                selectedDiv.appendChild(input);
            }
            document.getElementById('userResults').classList.add('hidden');
        }

        function removeUser(userId, button) {
            selectedUserIds = selectedUserIds.filter(id => id !== userId);
            button.parentElement.remove();
            document.getElementById(`user_${userId}`)?.remove();
        }

        function addVariable() {
            const container = document.getElementById('variableFields');
            const div = document.createElement('div');
            div.className = 'flex space-x-2';
            div.innerHTML = `
                <input type="text" name="variables[key][]" placeholder="Variable name" class="flex-1 rounded-md border-gray-300">
                <input type="text" name="variables[value][]" placeholder="Value" class="flex-1 rounded-md border-gray-300">
                <button type="button" onclick="this.parentElement.remove()" class="px-3 py-2 bg-red-600 text-white rounded-md">-</button>
            `;
            container.appendChild(div);
        }
    </script>
</x-admin-layout>