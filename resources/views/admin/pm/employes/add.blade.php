<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add') }}
        </h2>
    </x-slot>
    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" enctype="multipart/form-data" action="{{ route($crud_model.'.add') }}">
                        @csrf
                        <!-- Title -->
                        <div>
                            <x-label for="title" :value="__('last_name')"/>
                            <x-input id="title" class="block mt-1 w-full @error('last_name') is-invalid @enderror" type="text" name="last_name" :value="old('last_name')" />
                        </div>
                        <div>
                            <x-label for="title" :value="__('name')"/>
                            <x-input id="title" class="block mt-1 w-full @error('name') is-invalid @enderror" type="text" name="name" :value="old('name')" />
                        </div>
                        <div>
                            <x-label for="title" :value="__('middle_name')"/>
                            <x-input id="title" class="block mt-1 w-full @error('middle_name') is-invalid @enderror" type="text" name="middle_name" :value="old('middle_name')" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Add') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


