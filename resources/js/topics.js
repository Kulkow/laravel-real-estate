import { createApp } from 'vue';
import TopicTable from './components/Topics/TopicTable.vue';

let app = createApp({
    components: {
        'topic-table'  : TopicTable
    }
});
app.mount('#app-topics');


