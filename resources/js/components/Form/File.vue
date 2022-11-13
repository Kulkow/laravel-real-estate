<template>
    <label v-if="label" :class="`block font-medium text-sm text-gray-700`">
        {{ label }}
    </label>
    <input
        @input="handleFileUpload"
        type="file"
        :class="`rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full`"
    />
    <div class="error-field" v-if="error">{{error }}</div>
</template>

<script>
export default {
    name: "FormFile",
    props: ['label', 'name', 'value','error', 'file'],
    emits: ['update:value'],
    mounted() {
        this.headers = this.$parent.headers;
    },
    beforeCreated() {
        let _this = this;
    },
    created() {
        let _this = this;
    },
    methods : {
        handleFileUpload( e ){
            let value = e.target.files[0];
            this.$emit('update:modelValue', value);
        }
    }
}
</script>

<style scoped>

</style>
