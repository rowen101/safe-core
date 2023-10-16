<template>
    <!-- <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="index.html">
                <span class="align-middle">SLI Monitoring</span>
            </a>
            <ul class="sidebar-nav" v-if="isLoggedIn">
                <li class="sidebar-header">Pages</li>
                 <li :class="['sidebar-item', { 'active': $route.path === '/dashboard' }]">
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
                 <li :class="['sidebar-item', { 'active': $route.path === '/profile' }]">
                    <router-link class="sidebar-link" to="/profile">
                     <i v-html="$feather.icons['user'].toSvg({ width: 24, height: 24 })"></i>
                        <span class="align-middle">Profile</span></router-link
                    >
                </li>
                 <li :class="['sidebar-item', { 'active': $route.path === '/recommendation' }]">
                    <router-link class="sidebar-link" to="/recommendation">
                      <i v-html="$feather.icons['layers'].toSvg({ width: 24, height: 24 })"></i>
                        <span class="align-middle">Recommendation</span></router-link
                    >
                </li>
  <li :class="['sidebar-item', { 'active': $route.path === '/student' }]">
                    <router-link class="sidebar-link" to="/student">
                      <i v-html="$feather.icons['layers'].toSvg({ width: 24, height: 24 })"></i>
                        <span class="align-middle">Student</span></router-link
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
    </nav> -->

     <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img :src="'backend/images/AdminLTELogo.png'" alt="Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Admin</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img :src="'backend/images/avatar5.png'" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                           <a href="#"> {{name}}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                         <li class="nav-item">
                    <router-link class="nav-link" to="/dashboard">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p></router-link
                    >
                </li>
                 <li class="nav-item">
                    <router-link class="nav-link" to="/recommendation">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>Tech Recommendation</p></router-link
                    >
                </li>
                 <li class="nav-item">
                    <router-link class="nav-link" to="/preventive">
                        <i class="fa fa-user nav-icon"></i>
                        <p>Preventive Meantenace</p></router-link
                    >
                </li>
                 <li class="nav-item">
                        <router-link to="/admin/users" active-class="active" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                            </p>
                        </router-link>
                    </li>
                <li class="nav-item">

                    <router-link class="nav-link" to="/sign-out">
                        <i class="far fas fa-sign-out-alt nav-icon"></i>
                        <p>Sign Out</p></router-link
                    >
                </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
</template>
<script>
export default {
    name: "DefaulSidebar",
    data() {
        return {
            isLoggedIn: false,
            name: null,
        };
    },
    created() {
        if (this.$store.getters.isLoggedIn) {
            this.isLoggedIn = true;
             this.name = "Hi! " + this.$store.getters.user.name
        }
    },
   methods: {
    isRouteActive(routePath) {
      return this.$route.path === routePath;
    },
   }
};
</script>
