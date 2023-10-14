import { createApp } from "vue";
import store from "./store"
import App from "./app/App.vue";
import axios from "axios";
import router from "./app/router";
import feather from "feather-icons";
import Notifications from '@kyvg/vue3-notification'
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

// Import the setCsrfCookie function from the csrf.js file


const app = createApp(App);
app.config.globalProperties.$axios = axios;
// Register feather-icons as a global property
app.config.globalProperties.$feather = feather;
app.use(router);



  app.use(store); // Use the Vuex store
  app.use(Notifications)
  app.use(VueToast); // Add this line to use VueToast



app.mount("#app");
