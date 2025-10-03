<x-admin-layout>
    @section('title', 'Site Settings')
    <x-slot name="main">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Site Settings</h1>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200">
                        <nav class="flex ml-6" aria-label="Tabs">
                            @php $firstTab = true; @endphp
                            @foreach ($groups as $groupName => $groupSettings)
                                @php
                                    $tabSlug = \Illuminate\Support\Str::slug($groupName);
                                @endphp
                                <button type="button"
                                    class="tab-button mr-8 py-4 px-1 text-sm font-medium border-b-2 {{ $firstTab ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                                    data-tab="{{ $tabSlug }}">
                                    {{ ucfirst($groupName) }}
                                </button>
                                @php $firstTab = false; @endphp
                            @endforeach
                        </nav>
                    </div>

                    <!-- Tabs Content -->
                    <div class="p-6">
                        @php $firstTab = true; @endphp
                        @foreach ($groups as $groupName => $groupSettings)
                            @php
                                $tabSlug = \Illuminate\Support\Str::slug($groupName);
                            @endphp
                            <div class="tab-content {{ $firstTab ? '' : 'hidden' }}" id="tab-{{ $tabSlug }}">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">{{ ucfirst($groupName) }} Settings
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach ($groupSettings as $setting)
                                        <div class="md:col-span-{{ in_array($setting->type, ['textarea']) ? 2 : 1 }}">
                                            <label for="setting-{{ $setting->key }}"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                {{ $setting->label }}
                                            </label>

                                            @if ($setting->type === 'text' || $setting->type === 'email')
                                                <input type="{{ $setting->type }}" name="{{ $setting->key }}"
                                                    id="setting-{{ $setting->key }}"
                                                    value="{{ old($setting->key, $setting->value) }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                            @elseif($setting->type === 'textarea')
                                                <textarea name="{{ $setting->key }}" id="setting-{{ $setting->key }}" rows="4"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old($setting->key, $setting->value) }}</textarea>
                                            @elseif($setting->type === 'image')
                                                <div class="flex items-center space-x-4">
                                                    @if ($setting->value)
                                                        <div class="w-16 h-16 bg-gray-200 rounded overflow-hidden">
                                                            <img src="{{ Storage::url($setting->value) }}"
                                                                alt="{{ $setting->label }}"
                                                                class="w-full h-full object-cover">
                                                        </div>
                                                    @endif
                                                    <input type="file" name="{{ $setting->key }}"
                                                        id="setting-{{ $setting->key }}"
                                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                        accept="image/*">
                                                </div>
                                            @elseif($setting->type === 'select')
                                                <select name="{{ $setting->key }}" id="setting-{{ $setting->key }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                    @if ($setting->options)
                                                        @foreach (json_decode($setting->options, true) as $value => $label)
                                                            <option value="{{ $value }}"
                                                                {{ $setting->value == $value ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            @elseif($setting->type === 'boolean')
                                                <div class="flex items-center">
                                                    <input type="hidden" name="{{ $setting->key }}" value="0">
                                                    <input type="checkbox" name="{{ $setting->key }}"
                                                        id="setting-{{ $setting->key }}" value="1"
                                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                                        {{ $setting->value ? 'checked' : '' }}>
                                                    <label for="setting-{{ $setting->key }}"
                                                        class="ml-2 block text-sm text-gray-900">Enable</label>
                                                </div>
                                            @endif

                                            @error($setting->key)
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @php $firstTab = false; @endphp
                        @endforeach
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                            Save Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Tab functionality
                    const tabButtons = document.querySelectorAll('.tab-button');
                    const tabContents = document.querySelectorAll('.tab-content');

                    // If no tabs are visible, show the first one
                    const visibleTabs = Array.from(tabContents).filter(tab => !tab.classList.contains('hidden'));
                    if (visibleTabs.length === 0 && tabContents.length > 0) {
                        tabContents[0].classList.remove('hidden');
                        tabButtons[0].classList.add('border-indigo-500', 'text-indigo-600');
                        tabButtons[0].classList.remove('text-gray-500', 'border-transparent');
                    }

                    tabButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const tabId = this.getAttribute('data-tab');

                            // Update button styles
                            tabButtons.forEach(btn => {
                                btn.classList.remove('border-indigo-500', 'text-indigo-600');
                                btn.classList.add('border-transparent', 'text-gray-500',
                                    'hover:text-gray-700', 'hover:border-gray-300');
                            });
                            this.classList.add('border-indigo-500', 'text-indigo-600');
                            this.classList.remove('border-transparent', 'text-gray-500',
                                'hover:text-gray-700', 'hover:border-gray-300');

                            // Show selected tab content
                            tabContents.forEach(content => {
                                content.classList.add('hidden');
                            });

                            const targetTab = document.getElementById(`tab-${tabId}`);
                            if (targetTab) {
                                targetTab.classList.remove('hidden');
                            }
                        });
                    });

                    // Handle tab from URL hash
                    const hash = window.location.hash.substring(1);
                    if (hash) {
                        const tabButton = document.querySelector(`.tab-button[data-tab="${hash}"]`);
                        if (tabButton) {
                            tabButton.click();
                        }
                    }
                });
            </script>
        @endpush
    </x-slot>
</x-admin-layout>
