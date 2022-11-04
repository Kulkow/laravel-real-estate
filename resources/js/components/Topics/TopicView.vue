<template>
    <div class="box-border w-400 p-4 border-4" v-if="$parent.view">
        <div class=""><b>{{$parent.view.id}}</b></div>
        <p>{{$parent.view.title}}</p>
        <pre>{{$parent.view.description}}</pre>
        <div v-if="$parent.view.picture_view">
            <img :src="$parent.view.picture_view.src" :alt="$parent.view.picture_view.alt" class="w-24 h-24 rounded-full">
        </div>
    </div>
</template>
<script>
export default {
    name: "TopicView"
}
</script>

<style scoped>

</style>
