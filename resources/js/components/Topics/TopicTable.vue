<template>
    <div class="flex flex-row my-10">
        <div class="w-1/2">
            <TopicView></TopicView>
        </div>
        <div class="w-1/2">
            <TopicEdit></TopicEdit>
        </div>
    </div>
    <div class="container mx-auto my-10">
        <div class="overflow-hidden relative">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <TopicTableItem v-for="item in items" :item="item">
                </TopicTableItem>
            </table>
        </div>
    </div>
    <Paginator title="test"></Paginator>
</template>
<script>
import Paginator from "../Paginator";
import TopicTableItem from "./TopicTableItem";
import TopicView from "./TopicView";
import TopicEdit from "./TopicEdit";

export default {
    name: "TopicTable",
    components: {Paginator, TopicTableItem, TopicView, TopicEdit},
    props: ['auth-token'],
    created() {

    },
    mounted() {
        let authToken = this.$props['authToken'];
        this.headers = {Authorization: 'Bearer ' + authToken};
        this.getTopics(1);
    },
    watch : {
        edit: {
            handler(newValue, oldValue) {
                /*console.log(oldValue);
                console.log(newValue);*/
            },
            deep: true
        }
    },
    data() {
        return {
            items: [],
            links: [],
            view: {},
            edit: {},
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
        setDataList(response) {
            let _this = this;
            let data = [],
                links = [];
            if (response.hasOwnProperty('data')) {
                let _data = response.data;
                if (_data.hasOwnProperty('data')) {
                    data = _data.data;
                    if (_data.hasOwnProperty('links')) {
                        links = _data.links;
                    }
                } else {
                    data = _data;
                    if (response.hasOwnProperty('links')) {
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
