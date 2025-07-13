import './bootstrap';
import { createApp, h } from 'vue';
import Chat from './components/Chat.vue';

const app = createApp({
    render: () => h(Chat)
});

app.mount('#app');
