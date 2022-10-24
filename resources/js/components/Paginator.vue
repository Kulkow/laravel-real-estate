<template>

    <nav :aria-label="title">
        <ul class="inline-flex -space-x-px">
            <li v-for="(link, key) in $parent.links">
                <a
                    class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    :class="{ 'text-blue-600': link.active,'rounded-l-lg': (key==0), 'rounded-r-lg': (key==($parent.links.length-1))}"
                    @click.stop.prevent="$parent.getPaginatorLink(link.url)" :href="link.url"
                    v-html="link.label">
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "Paginator",
    props: ['title'],
    data(){
        return {
           // 'links' : [],
           // 'title' : 'Paginator'
        }
    }
}
</script>
