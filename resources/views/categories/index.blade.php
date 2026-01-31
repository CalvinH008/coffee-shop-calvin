<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-coffee-800 dark:text-coffee-100">
                    📋 Categories Management
                </h2>
                <p class="text-sm text-coffee-600 dark:text-coffee-300 mt-1">
                    Manage your coffee product categories
                </p>
            </div>
            <a href="{{ route('categories.create') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-coffee-600 to-coffee-700 hover:from-coffee-700 hover:to-coffee-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Add Category
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        
        {{-- FLASH MESSAGES --}}
        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-r-xl shadow-md">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-r-xl shadow-md">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- CARD TABLE --}}
        <div class="bg-white dark:bg-coffee-800 rounded-2xl shadow-xl overflow-hidden">
            
            {{-- TABLE HEADER --}}
            <div class="px-6 py-4 bg-gradient-to-r from-coffee-700 to-coffee-800 border-b border-coffee-600">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <span class="text-2xl mr-2">☕</span>
                        Category List
                    </h3>
                    <span class="px-3 py-1 bg-caramel-500 text-white text-sm font-bold rounded-full">
                        {{ $categories->total() }} Categories
                    </span>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-coffee-200 dark:divide-coffee-700">
                    <thead class="bg-coffee-100 dark:bg-coffee-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-coffee-700 dark:text-coffee-300 uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-coffee-700 dark:text-coffee-300 uppercase tracking-wider">
                                Category Name
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-coffee-700 dark:text-coffee-300 uppercase tracking-wider">
                                Slug
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-coffee-700 dark:text-coffee-300 uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-coffee-700 dark:text-coffee-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-coffee-800 divide-y divide-coffee-200 dark:divide-coffee-700">
                        @forelse ($categories as $index => $category)
                            <tr class="hover:bg-coffee-50 dark:hover:bg-coffee-700/30 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-coffee-600 dark:text-coffee-300">
                                        {{ $categories->firstItem() + $index }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-caramel-400 to-caramel-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                                            <span class="text-white text-lg font-bold">
                                                {{ substr($category->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-coffee-900 dark:text-coffee-50">
                                                {{ $category->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-coffee-200 dark:bg-coffee-700 text-coffee-800 dark:text-coffee-200 border border-coffee-300 dark:border-coffee-600">
                                        {{ $category->slug }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-coffee-600 dark:text-coffee-400">
                                    {{ Str::limit($category->description ?? 'No description', 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        {{-- VIEW --}}
                                        <a href="{{ route('categories.show', $category) }}" 
                                           class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 rounded-lg transition-colors duration-200"
                                           title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        
                                        {{-- EDIT --}}
                                        <a href="{{ route('categories.edit', $category) }}" 
                                           class="p-2 bg-caramel-100 dark:bg-caramel-900/30 text-caramel-600 dark:text-caramel-400 hover:bg-caramel-200 dark:hover:bg-caramel-900/50 rounded-lg transition-colors duration-200"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        
                                        {{-- DELETE --}}
                                        <form action="{{ route('categories.destroy', $category) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 rounded-lg transition-colors duration-200"
                                                    title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-24 h-24 bg-coffee-100 dark:bg-coffee-900 rounded-full flex items-center justify-center mb-4">
                                            <span class="text-5xl">📋</span>
                                        </div>
                                        <h3 class="text-lg font-semibold text-coffee-800 dark:text-coffee-200 mb-2">No Categories Yet</h3>
                                        <p class="text-sm text-coffee-600 dark:text-coffee-400 mb-6">
                                            Start by creating your first coffee category
                                        </p>
                                        <a href="{{ route('categories.create') }}" 
                                           class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-coffee-600 to-coffee-700 hover:from-coffee-700 hover:to-coffee-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Create First Category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($categories->hasPages())
                <div class="px-6 py-4 bg-coffee-50 dark:bg-coffee-900 border-t border-coffee-200 dark:border-coffee-700">
                    {{ $categories->links() }}
                </div>
            @endif

        </div>

    </div>
</x-app-layout>