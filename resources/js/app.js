import { createApp } from "vue";
import store from "./store"
import "./bootstrap";
import App from "./App.vue";
import axios from "axios";
import router from "./router";


const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(router);

// Check if a token exists in localStorage
const token = localStorage.getItem("token");


router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      console.log(store.getters.isLoggedIn);
      if (!token) {
        next({
          name: "login",
        })
      } else {
        next()
      }
    } else if (to.matched.some(record => record.meta.requiresVisitor)) {
      console.log(store.getters.isLoggedIn);
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

  app.use(store); // Use the Vuex store

app.mount("#app");
