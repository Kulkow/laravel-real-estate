import { createApp } from 'vue';
import TopicTable from './components/Topics/TopicTable.vue';
import TopicView from './components/Topics/TopicView.vue';

let app = createApp({
    components: {
        'topic-table'  : TopicTable,
        'topic-view'  : TopicView,
    }
});
app.mount('#app-topics');


