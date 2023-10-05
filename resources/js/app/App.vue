<template>
    <div class="wrapper">
        <sidebar/>
        <router-view />
    </div>

</template>

<script>
import sidebar from "./containers/SideBar.vue";
export default {
    name: "App",
     components: {
    sidebar
  },
    data() {
        return {
            isLoggedIn: false,
        };
    },
    created() {
        if (this.$store.getters.isLoggedIn) {
            this.isLoggedIn = true;
        }
    },
    methods: {
        logout() {
            const token = localStorage.getItem("token"); // Get the token from localStorage
            this.$axios.get("/sanctum/csrf-cookie").then((response) => {
                this.$axios
                    .post("/api/logout", null, {
                        // Pass null as the request body for logout
                        headers: {
                            Authorization: `Bearer ${token}`, // Include the token in the request headers
                        },
                    })
                    .then((resp) => {
                        localStorage.removeItem("token");
                        // Commit the logout action to clear Vuex state
                        this.$store.dispatch("logout");
                        // Redirect to the login page
                         window.location.href = "/login"; // Replace "/login" with your login page URL
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            });
        },
    },
};
</script>
