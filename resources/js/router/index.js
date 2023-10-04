import { createRouter, createWebHistory } from "vue-router";

import Home from '../pages/Home.vue';
import About from '../pages/About.vue';
import Register from '../pages/Register.vue';
import Login from '../pages/Login.vue';
import Dashboard from '../pages/Dashboard.vue';

import Books from '../components/Books.vue';
import AddBook from '../components/AddBook.vue';
import EditBook from '../components/EditBook.vue';

const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,
        meta:{
            requiresAuth : true
          }

    },
    {
        name: 'about',
        path: '/about',
        component: About,
        meta:{
            requiresVisitor : true
          }
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
        meta:{
            requiresVisitor : true
          }
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta:{
            requiresVisitor : true
          }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta:{
            requiresAuth : true
          }

    },
    {
        name: 'books',
        path: '/books',
        component: Books,
        meta:{
            requiresAuth : true
          }

    },
    {
        name: 'addbook',
        path: '/books/add',
        component: AddBook,
        meta:{
            requiresAuth : true
          }

    },
    {
        name: 'editbook',
        path: '/books/edit/:id',
        component: EditBook,
        meta:{
            requiresAuth : true
          }

    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Add a navigation guard to check if the user is authenticated before navigating to the dashboard
router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        // You can add your authentication logic here.
        // For example, check if the user is logged in and has a valid token.
        const isAuthenticated = localStorage.getItem("token");/* Add your authentication check here */ true;
        if (!isAuthenticated) {
            // If not authenticated, redirect to the login page
            next({ name: 'login' });
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
