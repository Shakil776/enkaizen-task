import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);


// Dashboard Component
import Dashboard from '../pages/dashboard/index.vue'
import UserProfile from '../pages/dashboard/profile.vue'

// Authentication File
import Login from '../pages/auth/Login.vue'
import Signup from '../pages/auth/Signup.vue'

const routes = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            component: Dashboard,
            name: 'dashboard',
            meta: {
                requiresAuth: true,
            }
        },
        
        {
            path: '/auth/login',
            component: Login,
            name: 'login',
            meta: {
                requiresVisitor: true,
            }
        },
        {
            path: '/auth/signup',
            component: Signup,
            name: 'signup',
            meta: {
                requiresVisitor: true,
            }
        },
        {
            path: '/profile',
            component: UserProfile,
            name: 'user-profile',
            meta: {
                requiresAuth: true,
            }
        }
    ]
});

export default routes;
