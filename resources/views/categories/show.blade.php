<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-coffee-800 dark:text-coffee-100">
                    👁️ Category Details
                </h2>
                <p class="text-sm text-coffee-600 dark:text-coffee-300 mt-1">
                    View category information
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('categories.edit', $category) }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-caramel-500 hover:bg-caramel-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-coffee-200 dark:bg-coffee-700 hover:bg-coffee-300 dark:hover:bg-coffee-600 text-coffee-800 dark:text-coffee-100 font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- MAIN INFO CARD --}}
        <div class="bg-white dark:bg-coffee-800 rounded-2xl shadow-xl overflow-hidden">
            
            {{-- CARD HEADER --}}
            <div class="px-8 py-6 bg-gradient-to-r from-coffee-600 to-coffee-700">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                        <span class="text-4xl font-bold text-white">
                            {{ substr($category->name, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">
                            {{ $category->name }}
                        </h3>
                        <p class="text-coffee-100 text-sm mt-1">
                            Slug: <code class="px-2 py-1 bg-white/20 rounded">{{ $category->slug }}</code>
                        </p>
                    </div>
                </div>
            </div>

            {{-- CARD BODY --}}
            <div class="p-8 space-y-6">
                
                {{-- DESCRIPTION --}}
                <div>
                    <h4 class="text-sm font-bold text-coffee-600 dark:text-coffee-300 uppercase tracking-wider mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Description
                    </h4>
                    <div class="bg-coffee-50 dark:bg-coffee-900 rounded-xl p-6 border border-coffee-200 dark:border-coffee-700">
                        @if($category->description)
                            <p class="text-coffee-800 dark:text-coffee-200 leading-relaxed">
                                {{ $category->description }}
                            </p>
                        @else
                            <p class="text-coffee-500 dark:text-coffee-400 italic">
                                No description provided.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- METADATA --}}
                <div>
                    <h4 class="text-sm font-bold text-coffee-600 dark:text-coffee-300 uppercase tracking-wider mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        Timestamps
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-green-700 dark:text-green-300 uppercase">Created At</p>
                            </div>
                            <p class="text-sm font-bold text-green-800 dark:text-green-200">
                                {{ $category->created_at->format('d F Y') }}
                            </p>
                            <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                                {{ $category->created_at->format('H:i:s') }} ({{ $category->created_at->diffForHumans() }})
                            </p>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-blue-700 dark:text-blue-300 uppercase">Last Updated</p>
                            </div>
                            <p class="text-sm font-bold text-blue-800 dark:text-blue-200">
                                {{ $category->updated_at->format('d F Y') }}
                            </p>
                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                                {{ $category->updated_at->format('H:i:s') }} ({{ $category->updated_at->diffForHumans() }})
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        {{-- PRODUCTS SECTION (Preview) --}}
        <div class="bg-white dark:bg-coffee-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-caramel-500 to-caramel-600 border-b border-caramel-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center mr-3">
                            <span class="text-2xl">🫘</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">
                                Products in this Category
                            </h3>
                            <p class="text-white/80 text-sm">
                                Total: <span class="font-bold">{{ $category->products->count() }}</span> products
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8">
                @if($category->products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($category->products->take(6) as $product)
                            <div class="bg-coffee-50 dark:bg-coffee-900 rounded-xl p-4 border border-coffee-200 dark:border-coffee-700 hover:shadow-lg transition-shadow duration-200">
                                <h5 class="font-semibold text-coffee-800 dark:text-coffee-100">
                                    {{ $product->name }}
                                </h5>
                                <p class="text-sm text-coffee-600 dark:text-coffee-400 mt-1">
                                    {{ Str::limit($product->description, 50) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($category->products->count() > 6)
                        <div class="mt-4 text-center">
                            <p class="text-sm text-coffee-600 dark:text-coffee-400">
                                And {{ $category->products->count() - 6 }} more products...
                            </p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <div class="w-20 h-20 bg-coffee-100 dark:bg-coffee-900 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-4xl">📦</span>
                        </div>
                        <p class="text-coffee-600 dark:text-coffee-400">
                            No products in this category yet.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex items-center justify-between bg-white dark:bg-coffee-800 rounded-2xl shadow-xl p-6">
            <form action="{{ route('categories.destroy', $category) }}" 
                  method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete this category?');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete Category
                </button>
            </form>

            <a href="{{ route('categories.edit', $category) }}" 
               class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-caramel-500 to-caramel-600 hover:from-caramel-600 hover:to-caramel-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Category
            </a>
        </div>

    </div>
</x-app-layout>