import './bootstrap';

import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createPinia } from 'pinia';
import { createRouter, createWebHistory } from 'vue-router';
import Routes from './routes.js';
import Login from './pages/auth/Login.vue';
import App from './App.vue';
import { useAuthUserStore } from './stores/AuthUserStore';
import { useSettingStore } from './stores/SettingStore';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css'

const pinia = createPinia();
const app = createApp(App);

const router = createRouter({
    routes: Routes,
    history: createWebHistory(),
});

router.beforeEach(async (to, from,next) => {
    const authUserStore = useAuthUserStore();
    const settingStore = useSettingStore();
    if (authUserStore.user.name === '' && to.name !== 'admin.login') {

        await Promise.all([
            authUserStore.getAuthUser(),
            settingStore.getSetting(),
        ]);

        // Assuming you have a token property in your authUserStore
        if (authUserStore.token === true) {
            // Redirect to the dashboard route
            next({ name: 'dashboard' });
        } else {
            // Continue with the regular navigation
            next();
        }
    }
    else{
        // Continue with the regular navigation
        next();
    }
});

app.use(pinia);
app.use(router);
app.use(VueSweetalert2);



app.mount('#app');
