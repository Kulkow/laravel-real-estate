<template>
    <tr>
        <td><b>{{ item.id }}</b></td>
        <td>{{ item.title }}</td>
        <td>{{ item.author_id }}</td>
        <td>
            <a :href="`/api/topic/${item.id}`" @click.stop.prevent="viewTopic(item.id)"
               title="topic.view">
                topic.view
            </a>
        </td>
        <td>
            <a :href="`/api/topic/edit/${item.id}`" title="'topic.edit">
                topic.edit
            </a>
        </td>
    </tr>
</template>

<script>
export default {
    name: "TopicTableItem",
    props: ['item'],
    created() {

    },
    mounted() {
        this.headers = this.$parent.headers;
    },
    data() {
        return {
            headers: {}
        };
    },
    methods: {
        viewTopic(_id) {
            let _this = this;
            const config = {
                headers: _this.headers
            };
            axios.get('/api/topic/' + _id, config).then(function (response) {
                console.log('response >>',  response);
                let data = {};
                if(response.hasOwnProperty('data')){
                    data = response.data;
                    if(data.hasOwnProperty('data')){
                        data = data.data;
                    }
                }
                console.log('data >>',data);
                _this.$parent.view = data;
            });
        }
    }
}
</script>

<style scoped>

</style>
