<template xmlns="http://www.w3.org/1999/html">
    sdfsd
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-if="$parent.edit">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" enctype="multipart/form-data" :action="`/api/topic/edit/${$parent.edit.id}`">
                    <div>
                        <FormText label="Title" name="title" :value="$parent.edit.title"></FormText>
                        <FormTextarea label="description" name="description" :value="$parent.edit.description"></FormTextarea>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <button>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import FormText from "../Form/Text";
import FormTextarea from "../Form/Textarea";

export default {
    name: "TopicEdit",
    components: {FormText, FormTextarea},
}
</script>

<style scoped>

</style>
