<script setup>
import { useAuthUserStore } from "../stores/AuthUserStore";
import { useRouter } from "vue-router";
import { useSettingStore } from "../stores/SettingStore";
import { onMounted, ref } from "vue";
const router = useRouter();
const authUserStore = useAuthUserStore();
const settingStore = useSettingStore();

const logout = () => {
    axios.post("/logout").then((response) => {
        authUserStore.user.name = "";
        router.push("/login");
    });
};

onMounted(() => {
    $('[data-widget="treeview"]').Treeview("init");
});
</script>

<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 fixed">
        <a href="#" class="brand-link">
            <img
                :src="'/img/safe1.png'"
                alt="AdminLTE Logo"
                class="brand-image"
                style="opacity: 0.8"
            />
            <span class="brand-text font-weight-light">{{
                settingStore.setting.app_name
            }}</span>
        </a>

        <div class="sidebar ">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
                <div class="image">
                    <img
                        :src="authUserStore.user.avatar"
                        class="img-circle elevation-2"
                        alt="User Image"
                    />
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{
                        authUserStore.user.name
                    }}</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <li class="nav-item">
                        <router-link
                            to="/admin/dashboard"
                            active-class="active"
                            class="nav-link"
                        >
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </router-link>
                    </li>

                    <!-- <li class="nav-item">
                        <router-link to="/admin/client"
                            :class="$route.path.startsWith('/admin/client') ? 'active' : ''" class="nav-link">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>
                                Client
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/appointments"
                            :class="$route.path.startsWith('/admin/appointments') ? 'active' : ''" class="nav-link">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>
                                Appointments
                            </p>
                        </router-link>
                    </li> -->

                    <li
                        class="nav-item"
                        v-if="authUserStore.user.role === 'ADMIN'"
                    >
                        <router-link
                            to="/admin/users"
                            active-class="active"
                            class="nav-link"
                        >
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link
                            to="/admin/tech-recommendation"
                            active-class="active"
                            class="nav-link"
                        >
                            <i class="nav-icon fas fas fa-server"></i>
                            <p>Tech Recommendation</p>

                        </router-link>

                    </li>

                    <li class="nav-item menu-open">
                        <router-link
                            to="#"

                            class="nav-link"
                        >
                            <i class="nav-icon fas fa-server"></i>
                            <p>Weekly Task Schedule</p>
                            <i class="fas fa-angle-left right"></i>
                        </router-link>
                           <ul class="nav nav-treeview">
                            <li class="nav-item">

                                <router-link
                            to="/admin/weekly-task-schedule/myprio"
                            active-class="active"
                            class="nav-link"
                        >
                            <i class="far fa-circle nav-icon"></i>
                            <p>My Prio</p>

                        </router-link>
                            </li>
                            <li class="nav-item">
                                <a
                                    href="../mailbox/compose.html"
                                    class="nav-link"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>My Closed Prio</p>
                                </a>
                            </li>
                             <li class="nav-item">

                                <router-link
                            to="/admin/weekly-task-schedule/myvsc"
                            active-class="active"
                            class="nav-link"
                        >
                            <i class="far fa-circle nav-icon"></i>
                            <p>My VSS</p>

                        </router-link>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nav-item"
                        v-if="authUserStore.user.role === 'ADMIN'"
                    >
                        <router-link
                            to="/admin/settings"
                            active-class="active"
                            class="nav-link"
                        >
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Settings</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link
                            to="/admin/profile"
                            active-class="active"
                            class="nav-link"
                        >
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profile</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <form class="nav-link">
                            <a href="#" @click.prevent="logout">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>
