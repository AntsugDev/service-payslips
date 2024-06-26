import { createApp } from 'vue'
import store from './store'
import router from './router'
import App from './App.vue';
import vuetify from './plugins/vuetify';
import axios from 'axios'



const app = createApp(App)
    .use(router)
    .use(vuetify)
    .use(store)

app.config.globalProperties.axios = { ...axios }
app.mount('#app')
