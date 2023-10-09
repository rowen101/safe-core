<template>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="index.html">
                <span class="align-middle">AdminKit</span>
            </a>
            <ul class="sidebar-nav" v-if="isLoggedIn">
                <li class="sidebar-header">Pages</li>
                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/dashboard">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">Dashboard</span></router-link
                    >
                </li>
                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">Home</span></router-link
                    >
                </li>
                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/books">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">Book</span></router-link
                    >
                </li>
                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/recommendations">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">Recommendation</span></router-link
                    >
                </li>
             

            </ul>
            <ul class="sidebar-nav" v-else>
                <li class="sidebar-header">Pages</li>
                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/login">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">login</span></router-link
                    >
                </li>
                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/register">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">Register</span></router-link
                    >
                </li>
                <li class="sidebar-item">
                    <router-link class="sidebar-link" to="/about">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">About</span></router-link
                    >
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
export default {
    name: "DefaulSidebar",
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

    },
};
</script>
