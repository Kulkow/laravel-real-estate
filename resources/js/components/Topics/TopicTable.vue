<template>
    <div class="overflow-x-auto relative">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <TopicTableItem v-for="item in items" :item="item">
            </TopicTableItem>
        </table>
    </div>
    <Paginator title="test"></Paginator>
    <div class="box-border w-400 p-4 border-4" v-if="view">
        <div class="">{{view.id}}</div>
        <p>{{view.title}}</p>
        <pre>{{view.description}}</pre>
        <div v-if="view.picture_view">
            <img :src="view.picture_view.src" :alt="view.picture_view.alt" class="w-24 h-24 rounded-full">
        </div>
    </div>
</template>

<script>
import Paginator from "../Paginator";
import TopicTableItem from "./TopicTableItem";

export default {
    name: "TopicTable",
    components: {Paginator, TopicTableItem},
    props: ['auth-token'],
    created() {

    },
    mounted() {
        let authToken = this.$props['authToken'];
        this.headers = {Authorization: 'Bearer ' + authToken};
        this.getTopics(1);
    },
    data() {
        return {
            items: [],
            links: [],
            view: {},
            headers: {}
        };
    },
    methods: {
        getPaginatorLink(link) {
            if (link === null) {
                return false;
            }
            let _this = this;
            const config = {
                headers: _this.headers
            };
            axios.get(link, config).then(function (response) {
                _this.setDataList(response);
            });
            return !1;
        },
        setDataList(response){
            let _this = this;
            let data = [],
                links = [];
            if(response.hasOwnProperty('data')){
                let _data = response.data;
                if(_data.hasOwnProperty('data')){
                    data = _data.data;
                    if(_data.hasOwnProperty('links')){
                        links = _data.links;
                    }
                }else{
                    data = _data;
                    if(response.hasOwnProperty('links')){
                        links = response.links;
                    }
                }
            }
            _this.items = data;
            _this.links = links;
        },
        getTopics(page = 1) {
            let _this = this;
            const config = {
                headers: _this.headers
            };
            axios.get('/api/topics?page=' + page, config).then(function (response) {
                _this.setDataList(response);
            });
        }
    }
}
</script>

<style scoped>

</style>
