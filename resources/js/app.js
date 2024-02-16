import { createApp } from 'vue'
import store from './store'
import router from './router'
import App from './App.vue';
import vuetify from './plugins/vuetify';
import axios from 'axios'

const axiosInstance = axios.create({})

const app = createApp(App)
    .use(router)
    .use(vuetify)
    .use(store)

app.config.globalProperties.axios = { ...axiosInstance }
app.mount('#app')
