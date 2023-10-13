<template>
   <!-- Navbar -->
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link" data-widget="pushmenu"><i class="fa fa-bars"></i></a>
                </li>


            </ul>
            <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">




                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>

                </ul>
        </nav>

</template>
<script>
export default {
    name: "DefaultHeader",
    data() {
          return {
            name: null,
        }
    },
      created() {
        if (this.$store.getters.isLoggedIn) {
            this.name = "Hi! " + this.$store.getters.user.name
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
