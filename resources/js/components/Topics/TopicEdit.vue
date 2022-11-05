<template xmlns="http://www.w3.org/1999/html">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-if="topic.id">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <p><b>{{topic.id}}</b></p>
                <form method="POST" enctype="multipart/form-data" :action="`/api/topic/edit/${topic.id}`" @submit.prevent="saveTopic(topic.id)">
                    <div v-if="errors.length>0"  class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                        <div v-for="error in errors">
                            {{error}}
                        </div>
                    </div>
                    <div>
                        <FormText label="Title" name="title" :value="topic.title"></FormText>
                        <FormTextarea label="Description" name="description" :value="topic.description"></FormTextarea>
                        <FormFile v-if="topic.picture_view" label="picture" name="picture" :value="topic.picture_view"></FormFile>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <button >Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import FormText from "../Form/Text";
import FormTextarea from "../Form/Textarea";
import FormFile from "../Form/File";

export default {
    name: "TopicEdit",
    components: {FormText, FormTextarea, FormFile},
    data() {
        return {
            headers: {},
            topic: {},
            errors: []
        };
    },
    mounted() {
        this.headers = this.$parent.headers;
    },
    created() {
        let _this = this;
        _this.$parent.$watch('edit', (topicEdit) => {
            _this.topic = topicEdit;
        })
    },
    methods: {
        renderErrors(errors)  {
            console.log(errors);
            for (const errorsKey in errors) {
                let error = errors[errorsKey];
                if(Array.isArray(error)){
                    error = error.join(',');
                }
                error = errorsKey+' - '+error;
                this.errors.push(error);
            }

        },
        saveTopic() {
            this.errors = [];
            let _this = this;
            const config = {
                headers: this.$parent.headers
            };
            axios.post('/api/topic/update/' + _this.topic.id, _this.topic,config).then(function (response) {
                console.log('update ',response);
                /*let data = _this.topic;
                if(response.hasOwnProperty('data')){
                    data = response.data;
                    if(data.hasOwnProperty('data')){
                        data = data.data;
                    }
                }
                _this.$parent.edit = data;*/
            }).catch(function (error) {
                if (error.response.data.errors) {
                    _this.renderErrors(error.response.data.errors);
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
