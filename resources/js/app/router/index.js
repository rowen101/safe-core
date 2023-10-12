import { createRouter, createWebHistory } from "vue-router";

import Home from "../pages/Home.vue";
import About from "../pages/About.vue";
import Register from "../pages/Register.vue";
import Login from "../pages/Login.vue";
import Dashboard from "../pages/Dashboard.vue";

import AuthLayout from "../layouts/AuthLayout.vue";

import Recomm from "../pages/recommendation/Recomm.vue";
import RecommSetup from "../pages/recommendation/RecommSetup.vue";
import EditRecomm from "../pages/recommendation/EditRecomm.vue";

import Profile from "../pages/Profile/index.vue";
import AddProfile from "../pages/Profile/add.vue";
import EditProfile from "../pages/Profile/edit.vue";

import StudentIndex from "../pages/student/StudentIndex.vue";

import NotFound from "../pages/NotFound.vue";
const routes = [
    {
        path: "/",
        redirect: "/login", // Redirect to the login page by default
    },
    {
        path: "/login",
        component: AuthLayout,
        children: [
            {
                path: "",
                name: "login",
                component: Login,
                meta: {
                    requiresVisitor: true,
                },
            },
        ],
    },
    {
        name: "home",
        path: "/",
        component: Home,
        meta: {
            requiresAuth: true,
        },
    },
    {
        name: "about",
        path: "/about",
        component: About,
        meta: {
            requiresVisitor: true,
        },
    },
    {
        name: "signup",
        path: "/signup",
        component: Register,
        meta: {
            requiresVisitor: true,
        },
    },

    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard,
        meta: {
            requiresAuth: true,
        },
    },

    //recommedation
    {
        name: "recommendation",
        path: "/recommendation",
        component: Recomm,
        meta: {
            requiresAuth: true,
        },
    },
    {
        name: "add-recommendation",
        path: "/recommendation/add",
        component: RecommSetup,
        meta: {
            requiresAuth: true,
        },
    },
    {
        name: "edit-recommendation",
        path: "/recommendation/edit/:id",
        component: RecommSetup,
        meta: {
            requiresAuth: true,
        },
    },
    //Profile
    {
        name: "profile",
        path: "/profile",
        component: Profile,
        meta: {
            requiresAuth: true,
        },
    },
    {
        name: "add-profile",
        path: "/profile/add",
        component: AddProfile,
        meta: {
            requiresAuth: true,
        },
    },
    {
        name: "edit-profile",
        path: "/profile/edit/:id",
        component: EditProfile,
        meta: {
            requiresAuth: true,
        },
    },
    {
        name: "student",
        path: "/student",
        component: StudentIndex,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/:catchAll(.*)",
        component: NotFound,
        meta: {
            requiresVisitor: true, // You can customize this meta property if needed
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    mode: "history", // Add this line to enable history mode
    linkActiveClass: "active", // Add this line to set the active link class
});

// Add a navigation guard to check if the user is authenticated before navigating to the dashboard
router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        // You can add your authentication logic here.
        // For example, check if the user is logged in and has a valid token.
        const isAuthenticated = localStorage.getItem("token");
        /* Add your authentication check here */ true;
        if (!isAuthenticated) {
            // If not authenticated, redirect to the login page
            next({ name: "login" });
        } else {
            // If authenticated, proceed to the dashboard
            next();
        }
    } else {
        // If the route doesn't require authentication, proceed as usual
        next();
    }
});

export default router;
