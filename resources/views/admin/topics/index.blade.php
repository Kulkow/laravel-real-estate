<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Topics') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('topic.add') }}">
                        {{ __('topic.Topics add') }}
                    </a>
                    <div id="app-test-v" data-token="1|bvvzC3ndTJkbpieCCI7unbZ9vLWOqzwvJomMt1Wl">
                        <div v-if="view">
                            <p>@{{view.id}}</p>
                            <p>@{{view.title}}</p>
                            <pre>@{{view.description}}</pre>
                            <div v-if="view.picture">
                                <img src="view.picture.">
                            </div>
                        </div>
                        <table  class="table" style="width: 100%;">
                            <tr v-for="item in items">
                                <td><b>@{{ item.id }}</b></td>
                                <td>@{{ item.title }}</td>
                                <td>@{{ item.author_id }}</td>
                                <td>
                                    <a :href="`/api/topic/${item.id}`" @click.stop.prevent="viewTopic(item.id)" title="{{ __('topic.view') }}">
                                        {{ __('topic.view') }}
                                    </a>
                                </td>
                                <td>
                                    <a :href="`/api/topic/edit/${item.id}`"  title="{{ __('topic.edit') }}">
                                        {{ __('topic.edit') }}
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <ul class="paginate">
                            <li v-for="link in links">
                                <span v-if="link.url!==null" :class="{ active: link.active }" @click="getTopicsLink(link.url)" :href="`${link.url}`">@{{ link.label }}</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <script src="{{ mix('js/topics.js') }}" defer></script>
</x-app-layout>


