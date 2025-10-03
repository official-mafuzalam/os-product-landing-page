<x-admin-layout>
    @section('title', 'Site Settings')
    <x-slot name="main">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Site LayoutsSettings</h1>
            </div>
            <div class="bg-white rounded-lg shadow overflow-hidden p-4">

                <form action="{{ route('admin.settings.homepage-sections.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <h2 class="text-xl font-bold mb-4">Select Public Page Layout</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Layout 1 -->
                        <label class="border rounded-lg cursor-pointer hover:shadow-lg transition relative">
                            <input type="radio" name="default_layout_type" value="layout1"
                                {{ $layoutSetting->value === 'layout1' ? 'checked' : '' }}
                                class="absolute top-2 right-2 w-5 h-5">

                            <div class="p-4 space-y-2">
                                <h3 class="font-semibold text-center">Layout 1</h3>
                                <div class="bg-blue-600 text-white rounded h-32 flex items-center justify-center">Hero
                                    Carousel</div>
                                {{-- <p class="mt-2 text-sm text-gray-600 text-center">
                                    Full hero carousel layout without side columns.
                                </p> --}}
                            </div>
                            <div class="grid grid-cols-2 gap-2 px-4">
                                <div class="bg-gray-400 rounded h-8 flex items-center justify-center text-xs">Bottom
                                    Deal 1</div>
                                <div class="bg-gray-400 rounded h-8 flex items-center justify-center text-xs">Bottom
                                    Deal 2</div>
                            </div>
                        </label>
                        <!-- Layout 2 -->
                        <label class="border rounded-lg cursor-pointer hover:shadow-lg transition relative">
                            <input type="radio" name="default_layout_type" value="layout2"
                                {{ $layoutSetting->value === 'layout2' ? 'checked' : '' }}
                                class="absolute top-2 right-2 w-5 h-5">

                            <div class="p-4 space-y-3">
                                <h3 class="font-semibold text-center">Layout 2</h3>
                                <div class="grid grid-cols-1 lg:grid-cols-4 gap-2 h-32">
                                    <div class="hidden lg:flex flex-col space-y-2">
                                        <div class="bg-gray-300 rounded h-16 flex items-center justify-center text-xs">
                                            Deal 1</div>
                                        <div class="bg-gray-300 rounded h-16 flex items-center justify-center text-xs">
                                            Deal 2</div>
                                    </div>
                                    <div
                                        class="col-span-1 lg:col-span-2 bg-blue-600 rounded flex items-center justify-center text-white font-bold">
                                        Carousel
                                    </div>
                                    <div class="hidden lg:flex flex-col space-y-2">
                                        <div class="bg-gray-300 rounded h-16 flex items-center justify-center text-xs">
                                            Deal 1</div>
                                        <div class="bg-gray-300 rounded h-16 flex items-center justify-center text-xs">
                                            Deal 2</div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                    <div class="bg-gray-400 rounded h-8 flex items-center justify-center text-xs">Bottom
                                        Deal 1</div>
                                    <div class="bg-gray-400 rounded h-8 flex items-center justify-center text-xs">Bottom
                                        Deal 2</div>
                                </div>
                                <p class="mt-2 text-sm text-gray-600 text-center">
                                    Multi-column layout with side deals, main carousel, and bottom deals.
                                </p>
                            </div>
                        </label>


                    </div>

                    <div class="mt-6 text-center">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                            Save Layout
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </x-slot>
</x-admin-layout>
