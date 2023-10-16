import { createRouter, createWebHistory } from "vue-router";

import Home from "../pages/Home.vue";
import About from "../pages/About.vue";
import Register from "../pages/Register.vue";
import Login from "../pages/Login.vue";
import Dashboard from "../pages/Dashboard.vue";

import AuthLayout from "../layouts/AuthLayout.vue";
import SignOut from "../pages/Signout.vue";
import RecommList from "../pages/recommendation/RecommList.vue";
import RecommSetup from "../pages/recommendation/RecommSetup.vue";
import Profile from "../pages/Profile/index.vue";
import AddProfile from "../pages/Profile/add.vue";
import EditProfile from "../pages/Profile/edit.vue";
import StudentIndex from "../pages/student/StudentIndex.vue";

import UserList from '../pages/users/UserList.vue';
import NotFound from "../pages/NotFound.vue";
const routes = [

    {
        path: "/login",
        component: AuthLayout,
        children: [
            {
                path: "",
                name: "Login",
                component: Login,
                meta: {
                    requiresVisitor: true,
                },
            },
            {
                name: "Registration",
                path: "/register",
                component: Register,
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
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard,
        meta: {
            requiresAuth: true,
        },
    },

    //recommedation
    {
        name: "recommendation",
        path: "/recommendation",
        component: RecommList,
        meta: {
            requiresAuth: true,
        },
    },
    {
        name: "Create Recommendation",
        path: "/recommendation/add",
        component: RecommSetup,
        meta: {
            requiresAuth: true,
        },
    },
    {
        name: "Modify recommendation",
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
        name: "Create Profile",
        path: "/profile/add",
        component: AddProfile,
        meta: {
            requiresAuth: true,
        },
    },
    {
        name: "Modify Profile",
        path: "/profile/edit/:id",
        component: EditProfile,
        meta: {
            requiresAuth: true,
        },
    },
    {

        path: "/sign-out",
        component: SignOut,
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
        path: '/admin/users',
        name: 'Users',
        component: UserList,
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
    linkActiveClass: "active", // Add this line to set the active link class
});

// Add a navigation guard to check if the user is authenticated before navigating to the dashboard
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");

    if(!token){
        if (to.name === 'Login' || to.name === 'Registration') {
            return next()
        } else {
            return next ({
                name: 'Login'
            })
        }
    }
    if (to.name === 'Login' || to.name === 'Registration' && token) {
        return next({
            name: 'Dashboard'
        })
    }
    next()

});

export default router;
