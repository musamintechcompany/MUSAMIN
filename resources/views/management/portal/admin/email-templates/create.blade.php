<x-admin-layout title="Create Email Template">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create Email Template</h1>
            <p class="text-gray-600 dark:text-gray-400">Create a new email template for system notifications</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <form action="{{ route('admin.email-templates.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Template Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Template Type</label>
                        <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select Type</option>
                            <option value="welcome" {{ old('type') == 'welcome' ? 'selected' : '' }}>Welcome</option>
                            <option value="verification" {{ old('type') == 'verification' ? 'selected' : '' }}>Email Verification</option>
                            <option value="password_reset" {{ old('type') == 'password_reset' ? 'selected' : '' }}>Password Reset</option>
                            <option value="notification" {{ old('type') == 'notification' ? 'selected' : '' }}>Notification</option>
                            <option value="affiliate" {{ old('type') == 'affiliate' ? 'selected' : '' }}>Affiliate</option>
                            <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Body</label>
                    <textarea name="body" id="body" rows="15" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">You can use variables like @{{name}}, @{{email}}, @{{url}}, etc.</p>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.email-templates.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Create Template</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>