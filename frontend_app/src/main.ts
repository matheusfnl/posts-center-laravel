import '@/assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import modalPlugin from '@/plugins/modal'
import './plugins/axios';

import App from '@/App.vue'
import router from '@/router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(modalPlugin);

app.mount('#app')
