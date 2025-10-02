<x-admin-layout>
    @section('title', 'Attributes Management')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Product Attributes</h1>
                        <p class="mt-2 text-sm text-gray-700">Manage product attributes like color, size, etc.</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('admin.attributes.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Add New Attribute
                        </a>
                    </div>
                </div>
            </div>

            <!-- Attributes Table -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @forelse($attributes as $attribute)
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $attribute->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $attribute->slug }}</div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <div class="text-sm text-gray-500">{{ $attribute->products_count }} products
                                        </div>
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $attribute->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $attribute->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500">
                                            {{ $attribute->description ?? 'No description' }}
                                        </p>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.attributes.edit', $attribute->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('admin.attributes.destroy', $attribute->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to delete this attribute?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-5 sm:px-6">
                            <div class="text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No attributes</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new attribute.</p>
                                <div class="mt-6">
                                    <a href="{{ route('admin.attributes.create') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        New Attribute
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- Pagination -->
            {{-- @if ($attributes->hasPages())
                <div class="mt-6">
                    {{ $attributes->links() }}
                </div>
            @endif --}}
        </div>
    </x-slot>
</x-admin-layout>
