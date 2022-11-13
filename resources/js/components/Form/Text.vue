<template>
    <label v-if="label" :class="`block font-medium text-sm text-gray-700`">
        {{ label }}
    </label>
    <input
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        type="text"
        :class="`rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full`"
    />
    <div class="error-field" v-if="error">{{error }}</div>
</template>

<script>
export default {
    name: "FormText",
    props: ['label', 'modelValue','error'],
    emits: ['update:modelValue']
}
</script>

<style scoped>

</style>
