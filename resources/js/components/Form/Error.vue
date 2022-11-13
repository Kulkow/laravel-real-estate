<template>
    <div v-if="errors.length>0"  class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
        <div v-for="error in errors">
            {{error}}
        </div>
    </div>
</template>

<script>
export default {
    name: "Error",
    props: ['errors'],
}
</script>

<style scoped>

</style>
