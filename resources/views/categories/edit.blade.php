<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-coffee-800 dark:text-coffee-100">
                    ✏️ Edit Category
                </h2>
                <p class="text-sm text-coffee-600 dark:text-coffee-300 mt-1">
                    Update category information
                </p>
            </div>
            <a href="{{ route('categories.index') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-coffee-200 dark:bg-coffee-700 hover:bg-coffee-300 dark:hover:bg-coffee-600 text-coffee-800 dark:text-coffee-100 font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        
        {{-- CARD FORM --}}
        <div class="bg-white dark:bg-coffee-800 rounded-2xl shadow-xl overflow-hidden">
            
            {{-- FORM HEADER --}}
            <div class="px-8 py-6 bg-gradient-to-r from-caramel-500 to-caramel-600 border-b border-caramel-500">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <span class="text-2xl">✏️</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">
                            Editing: {{ $category->name }}
                        </h3>
                        <p class="text-white/80 text-sm mt-1">
                            Update category details below
                        </p>
                    </div>
                </div>
            </div>

            {{-- FORM BODY --}}
            <form action="{{ route('categories.update', $category) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- CATEGORY NAME --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-coffee-800 dark:text-coffee-100 mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $category->name) }}"
                           class="w-full px-4 py-3 bg-coffee-50 dark:bg-coffee-900 border-2 border-coffee-200 dark:border-coffee-700 rounded-xl text-coffee-900 dark:text-coffee-100 placeholder-coffee-400 focus:border-caramel-500 focus:ring focus:ring-caramel-200 dark:focus:ring-caramel-900 transition-all duration-200 @error('name') border-red-500 @enderror"
                           placeholder="e.g. Espresso, Latte, Cappuccino"
                           autofocus>
                    
                    @error('name')
                        <div class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror

                    <p class="mt-2 text-xs text-coffee-500 dark:text-coffee-400">
                        💡 Current slug: <code class="px-2 py-1 bg-coffee-200 dark:bg-coffee-700 rounded">{{ $category->slug }}</code>
                    </p>
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-coffee-800 dark:text-coffee-100 mb-2">
                        Description <span class="text-coffee-500 text-xs">(Optional)</span>
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-4 py-3 bg-coffee-50 dark:bg-coffee-900 border-2 border-coffee-200 dark:border-coffee-700 rounded-xl text-coffee-900 dark:text-coffee-100 placeholder-coffee-400 focus:border-caramel-500 focus:ring focus:ring-caramel-200 dark:focus:ring-caramel-900 transition-all duration-200 @error('description') border-red-500 @enderror"
                              placeholder="Describe this category...">{{ old('description', $category->description) }}</textarea>
                    
                    @error('description')
                        <div class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- METADATA INFO --}}
                <div class="bg-coffee-100 dark:bg-coffee-900 rounded-xl p-4 border border-coffee-200 dark:border-coffee-700">
                    <h4 class="text-sm font-semibold text-coffee-800 dark:text-coffee-200 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Category Information
                    </h4>
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-coffee-600 dark:text-coffee-400">Created:</span>
                            <p class="text-coffee-800 dark:text-coffee-200 font-medium mt-1">
                                {{ $category->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <span class="text-coffee-600 dark:text-coffee-400">Last Updated:</span>
                            <p class="text-coffee-800 dark:text-coffee-200 font-medium mt-1">
                                {{ $category->updated_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- DIVIDER --}}
                <div class="border-t border-coffee-200 dark:border-coffee-700"></div>

                {{-- BUTTONS --}}
                <div class="flex items-center justify-between">
                    <a href="{{ route('categories.index') }}" 
                       class="inline-flex items-center px-5 py-2.5 bg-coffee-100 dark:bg-coffee-700 hover:bg-coffee-200 dark:hover:bg-coffee-600 text-coffee-700 dark:text-coffee-200 font-semibold rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </button>

                    <div class="flex items-center space-x-3">
                        {{-- DELETE BUTTON --}}
                        <button type="button"
                                onclick="document.getElementById('delete-form').submit();"
                                class="inline-flex items-center px-5 py-2.5 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 font-semibold rounded-xl transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>

                        {{-- UPDATE BUTTON --}}
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-caramel-500 to-caramel-600 hover:from-caramel-600 hover:to-caramel-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Category
                        </button>
                    </div>
                </div>

            </form>

        </div>

        {{-- DELETE FORM (Hidden) --}}
        <form id="delete-form" 
              action="{{ route('categories.destroy', $category) }}" 
              method="POST" 
              class="hidden"
              onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone!');">
            @csrf
            @method('DELETE')
        </form>

        {{-- WARNING CARD --}}
        <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-4 rounded-r-xl">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-yellow-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200 mb-1">
                        Important Notes
                    </h4>
                    <ul class="text-xs text-yellow-700 dark:text-yellow-300 space-y-1">
                        <li>• Changing the category name will update the slug automatically</li>
                        <li>• You cannot delete this category if it has products</li>
                        <li>• All changes are saved immediately after clicking "Update Category"</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>