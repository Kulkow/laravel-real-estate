<template xmlns="http://www.w3.org/1999/html">
    <div v-if="topic.id" class="topic-edit-form">
            <p><b>{{topic.id}}</b></p>
            <form method="POST" enctype="multipart/form-data" :action="`/api/topic/edit/${topic.id}`" @submit.prevent="saveTopic(topic.id)">
                <FormError :errors="errors" ></FormError>
                <FormMessage :messages="messages" ></FormMessage>
                <div>
                    <FormText label="Title" v-model="topic.title"></FormText>
                    <FormTextarea label="Description" v-model="topic.description"></FormTextarea>
                    <FormFile label="picture" v-model="topic.pictureInput"></FormFile>
                    <div class="picture" v-if="topic.picture">
                        <img :src="topic.picture_view.src" :alt="topic.picture_view.alt" class="w-24 h-24 rounded-full" />
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <button >Save</button>
                </div>
            </form>
    </div>
</template>

<script>
import FormText from "../Form/Text";
import FormTextarea from "../Form/Textarea";
import FormFile from "../Form/File";
import FormError from "../Form/Error";
import FormMessage from "../Form/Message";

export default {
    name: "TopicEdit",
    components: {FormText, FormTextarea, FormFile, FormError, FormMessage},
    data() {
        return {
            headers: {},
            topic: {},
            errors: [],
            messages: [],
        };
    },
    mounted() {
        this.headers = this.$parent.headers;
    },
    created() {
        let _this = this;
        _this.$parent.$watch('edit', (topicEdit) => {
            topicEdit.pictureInput = '';
            _this.topic = topicEdit;
        })
    },
    methods: {
        renderMessages(messages)  {
            for (const key in messages) {
                let message = messages[key];
                if(Array.isArray(message)){
                    message = message.join(',');
                }
                message = key+' - '+message;
                this.messages.push(message);
            }
        },
        renderErrors(errors)  {
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
            let _this = this;
            _this.errors = [];
            _this.messages = [];
            const config = {
                headers: this.$parent.headers
            };
            config.headers['Content-Type'] = 'application/json, multipart/form-data';
            let dataSend = new FormData();
            for (const [key, value] of Object.entries(_this.topic))
            {
                dataSend.append(key, value );
            }
            dataSend.append('picture', _this.topic.pictureInput);
            axios.post('/api/topic/update/' + _this.topic.id, dataSend,config).then(function (response) {
                _this.renderMessages({'Topic' : 'Success'});
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
