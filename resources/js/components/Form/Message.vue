<template>
    <div v-if="messages.length>0"  class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
        <div v-for="message in messages">
            {{message}}
        </div>
    </div>
</template>

<script>
export default {
    name: "Message",
    props: ['messages'],
}
</script>

<style scoped>

</style>
