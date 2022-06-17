<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route($crud_model.'.add') }}">
                        {{ __('crud.add') }}
                    </a>
                    <table class="table" style="width: 100%;">
                        @foreach ($list as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <a href="{{ route($crud_model.'.view', ['id' => $item->id]) }}">
                                        {{ __('crud.view') }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route($crud_model.'.edit', ['id' => $item->id]) }}">
                                        {{ __('crud.edit') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $list->links() }}
</x-app-layout>


