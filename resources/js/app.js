import { createApp } from "vue";
import store from "./store"
import App from "./app/App.vue";
import axios from "axios";
import router from "./app/router";
import feather from "feather-icons";

const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(router);

// Check if a token exists in localStorage
const token = localStorage.getItem("token");


router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      if (!token) {
        next({
          name: "login",
        })
      } else {
        next()
      }
    } else if (to.matched.some(record => record.meta.requiresVisitor)) {
      if (token) {
        next({
          name: "dashboard",
        })
      } else {
        next()
      }
    } {
      next()
    }
  });
  app.use(feather);
  app.use(store); // Use the Vuex store

app.mount("#app");
