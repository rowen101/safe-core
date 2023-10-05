<template>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="index.html">
                <span class="align-middle">AdminKit</span>
            </a>
            <ul class="sidebar-nav" v-if="isLoggedIn">
                <li class="sidebar-header">Pages</li>
                <router-link to="/dashboard" class="sidebar-item">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Dashboard</span></router-link
                >
                <router-link to="/" class="sidebar-item">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Home</span></router-link
                >
                <router-link to="/books" class="sidebar-item">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Book</span></router-link
                >
                <a
                        class="sidebar-item"
                        style="cursor: pointer"
                        @click="logout"
                        >Logout</a
                    >
            </ul>
            <ul class="sidebar-nav" v-else>
<li class="sidebar-header">Pages</li>
                 <router-link to="/login" class="sidebar-item">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">login</span></router-link
                >
                <router-link to="/register" class="sidebar-item">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Register</span></router-link
                >
                <router-link to="/about" class="sidebar-item">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">About</span></router-link
                >
            </ul>
 <ul class="sidebar-nav">
                <li class="sidebar-header">Pages</li>
                <!-- for logged-in user-->

                <li class="sidebar-item active">
                    <a class="sidebar-link" href="index.html">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="pages-profile.html">
                        <i class="align-middle" data-feather="user"></i>
                        <span class="align-middle">Profile</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="pages-sign-in.html">
                        <i class="align-middle" data-feather="log-in"></i>
                        <span class="align-middle">Sign In</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="pages-sign-up.html">
                        <i class="align-middle" data-feather="user-plus"></i>
                        <span class="align-middle">Sign Up</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="pages-blank.html">
                        <i class="align-middle" data-feather="book"></i>
                        <span class="align-middle">Blank</span>
                    </a>
                </li>

                <li class="sidebar-header">Tools & Components</li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="ui-buttons.html">
                        <i class="align-middle" data-feather="square"></i>
                        <span class="align-middle">Buttons</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="ui-forms.html">
                        <i class="align-middle" data-feather="check-square"></i>
                        <span class="align-middle">Forms</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="ui-cards.html">
                        <i class="align-middle" data-feather="grid"></i>
                        <span class="align-middle">Cards</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="ui-typography.html">
                        <i class="align-middle" data-feather="align-left"></i>
                        <span class="align-middle">Typography</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="icons-feather.html">
                        <i class="align-middle" data-feather="coffee"></i>
                        <span class="align-middle">Icons</span>
                    </a>
                </li>

                <li class="sidebar-header">Plugins & Addons</li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="charts-chartjs.html">
                        <i class="align-middle" data-feather="bar-chart-2"></i>
                        <span class="align-middle">Charts</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="maps-google.html">
                        <i class="align-middle" data-feather="map"></i>
                        <span class="align-middle">Maps</span>
                    </a>
                </li>
            </ul>

        </div>
    </nav>
</template>
<script>
export default {
    name: "SiteBar",
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
