<template>
    <label :class="`block font-medium text-sm text-gray-700`">
        {{ label }}
    </label>
    <textarea
        :name="name"
        :class="`rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full`"
        @input="$parent.topic[name] = $event.target.value"
    >{{value}}</textarea>
    <div class="error-field" v-if="error">{{error }}</div>
</template>

<script>
export default {
    name: "FormTextarea",
    props: ['label', 'name', 'value','error'],
}
</script>

<style scoped>

</style>
