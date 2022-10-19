import { createApp } from 'vue'

createApp({
    created() {
        this.getTopics(1);
    },
    data() {
        return {
            items: [],
            links: [],
            view: {},
            headers: { Authorization: `Bearer 1|bvvzC3ndTJkbpieCCI7unbZ9vLWOqzwvJomMt1Wl` }
        };
    },
    methods : {
        viewTopic(link){
            let _this = this;
            const config = {
                headers: _this.headers
            };
            axios.get(link, config).then(function (response) {
                console.log(response);
                _this.view = response.data.data;
            });
        },
        getTopicsLink(link){
            let _this = this;
            const config = {
                headers: _this.headers
            };
            axios.get(link, config).then(function (response) {
                console.log(response);
                _this.items = response.data.data;
                _this.links = response.data.links;
            });
            return !1;
        },
        getTopics(page = 1){
            let _this = this;
            const config = {
                headers: _this.headers
            };
            axios.get('/api/topics?page='+page, config).then(function (response) {
                console.log(response);
                _this.items = response.data.data;
                _this.links = response.data.links;
            });
        }
    }
}).mount('#app-test-v');


