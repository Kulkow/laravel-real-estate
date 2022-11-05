<template>
    <label :class="`block font-medium text-sm text-gray-700`">
        {{ label }}
    </label>
    <input :name="name" type="file" :class="`rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full`" />
    <div class="error-field" v-if="error">{{error }}</div>
    <div class="picture" v-if="value.src">
        <img :src="value.src" :alt="value.alt" class="w-24 h-24 rounded-full" />
    </div>
</template>

<script>
export default {
    name: "FormFile",
    props: ['label', 'name', 'value','error'],
    data() {
        return {

        }
    },
}
</script>

<style scoped>

</style>
