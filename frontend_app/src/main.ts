import '@/assets/main.css'

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import modalPlugin from '@/plugins/modal';
import authPlugin  from '@/plugins/auth';
import './plugins/axios';

import App from '@/App.vue'
import router from '@/router'

const app = createApp(App)

app.use(router)
app.use(modalPlugin);
app.use(authPlugin);
app.use(createPinia())

app.mount('#app')
