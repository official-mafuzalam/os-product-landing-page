<x-admin-layout>
    @section('title', 'Edit Attribute')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            Edit Attribute
                        </h2>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <a href="{{ route('admin.attributes.index') }}"
                            class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Attribute Information</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Update the attribute information.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-4">
                                            <label for="name"
                                                class="block text-sm font-medium text-gray-700">Attribute Name</label>
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name', $attribute->name) }}"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                required>
                                            @error('name')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6">
                                            <label for="description"
                                                class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea id="description" name="description" rows="3"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $attribute->description) }}</textarea>
                                            @error('description')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input id="is_active" name="is_active" type="checkbox" value="1"
                                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                                        {{ old('is_active', $attribute->is_active) ? 'checked' : '' }}>
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="is_active"
                                                        class="font-medium text-gray-700">Active</label>
                                                    <p class="text-gray-500">This attribute will be available for
                                                        products when active.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Update Attribute
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products using this attribute -->
            @if ($attribute->products_count > 0)
                <div class="mt-10">
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Products using this attribute
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                {{ $attribute->products_count }} products are using this attribute.
                            </p>
                        </div>
                        <ul class="divide-y divide-gray-200">
                            @foreach ($attribute->products->take(5) as $product)
                                <li>
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                {{ $product->name }}
                                            </p>
                                            <div class="ml-2 flex-shrink-0 flex">
                                                <p
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $product->pivot->value }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            @if ($attribute->products_count > 5)
                                <li class="px-4 py-4 sm:px-6 text-center text-sm text-gray-500">
                                    And {{ $attribute->products_count - 5 }} more products...
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </x-slot>
</x-admin-layout>
