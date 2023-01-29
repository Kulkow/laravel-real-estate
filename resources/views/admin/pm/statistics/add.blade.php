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
                    {{$employe->last_name}} - {{$employe->name}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" enctype="multipart/form-data" action="{{ route('statistic_task.add', ['id' => $id]) }}">
                        @csrf
                        <div>
                            <x-label for="title" :value="__('date')"/>
                            <x-input id="title" class="block mt-1 w-full @error('date') is-invalid @enderror" type="text" name="date" :value="old('date')" />
                        </div>
                        <table>
                            @foreach (range(0,12) as $index)
                            <tr>
                                <td style="width:50%">
                                    <x-input id="title" class="block mt-1 w-full" type="text" placeholder="link" name="task[{{$index}}][link]"  />
                                </td>
                                <td style="width:10%">
                                    <x-input id="title" class="block mt-1 w-full" type="text" placeholder="type" name="task[{{$index}}][type]"  />
                                </td>
                                <td style="width:10%">
                                    <x-input id="title" class="block mt-1 w-full" type="text" placeholder="time" name="task[{{$index}}][time]"  />
                                </td>
                                <td style="width:10%">
                                    <x-input id="title" class="block mt-1 w-full" type="text" placeholder="lead_time" name="task[{{$index}}][lead_time]"  />
                                </td>
                            </tr>
                            @endforeach
                        </table>
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


