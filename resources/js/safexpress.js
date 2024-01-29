import './bootstrap';


import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createPinia } from 'pinia';
import { createRouter, createWebHistory } from 'vue-router';
import Routes from './routes.js';
import Safexpress from './Safexpress.vue';


const pinia = createPinia();
const app = createApp(Safexpress);

const router = createRouter({
    routes: Routes,
    history: createWebHistory(),
});


app.use(pinia);
app.use(router);
app.mount('#safexpress');
