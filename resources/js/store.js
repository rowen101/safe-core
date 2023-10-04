import { createApp } from "vue";
import { createStore } from "vuex";
import axios from "axios";
import createPersistedState from "vuex-persistedstate";
import miniToastr from "mini-toastr";

miniToastr.init();

const store = createStore({
  state() {
    return {
      status: "",
      token: localStorage.getItem("token") || null,
      user: localStorage.getItem("vuex"),
    };
  },
  plugins: [createPersistedState()],
  mutations: {
    auth_request(state) {
      state.status = "loading";
    },
    auth_success(state, token) {
      state.status = "success";
      state.token = token;
    },
    auth_user(state, id) {
      state.id = id;
    },
    auth_error(state) {
      state.status = "error";
    },
    setLoading(state, isLoading) {
      state.isLoading = isLoading;
    },
    email(state, email) {
      state.email = email;
    },
    destroyToken(state) {
      state.token = null;
      state.status = "";
      state.id = "";
    },
  },
  actions: {
    login({ commit }, userparam) {
      return new Promise((resolve, reject) => {
        commit("auth_request");

        axios({
          url: "api/login",
          data: userparam,
          method: "POST",
        })

          .then((resp) => {
            axios.defaults.headers.common["Authorization"] =
              "Basic " + resp.data.token;

            const token = resp.data.token;
            const user = resp.data.user;
            localStorage.setItem("token", token);
            commit("auth_success", token);
            commit("auth_user", user);
            resolve(resp);
          })
          .catch((err) => {
            miniToastr.error("Login Failed");
            commit("auth_error");
            localStorage.removeItem("token");
            reject(err);
          });
      });
    },
    destroyToken(context, userparam) {
      return new Promise((resolve, reject) => {
        axios({
          data: userparam,
          method: "POST",
        })
          .then((response) => {
            localStorage.removeItem("token");
            context.commit("destroyToken");
            delete axios.defaults.headers.common["Authorization"];
            resolve(response);
          })
          .catch((error) => {
            localStorage.removeItem("token");
            context.commit("destroyToken");
            reject(error);
          });
      });
    },
  },
  getters: {
    isLoggedIn: (state) => state.token,
    authStatus: (state) => state.status,
    user: (state) => state.user,
  },
});

const app = createApp({});

app.use(store); // Add the Vuex store to the app

// If you have other parts of your Vue 3 app, you can add them here

app.mount("#app"); // Mount your app to the DOM

export default store;
