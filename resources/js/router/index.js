import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";

Vue.use(VueRouter);

// Dashboard Component
import Dashboard from "../pages/dashboard/Index.vue";

// Authentication File
import Login from "../pages/auth/Login.vue";
import Register from "../pages/auth/Register.vue";

// Add image
import AddImage from "../components/AddImage.vue";

const routes = new VueRouter({
    mode: "history",
    linkExactActiveClass: "active",
    routes: [
        {
            path: "/",
            redirect: { name: "login" },
        },
        {
            path: "/login",
            component: Login,
            name: "login",
        },
        {
            path: "/register",
            component: Register,
            name: "register",
        },
        {
            path: "/dashboard",
            component: Dashboard,
            name: "dashboard",
            meta: {
                requiresAuth: true,
            },
        },
        {
            path: "/add-image",
            component: AddImage,
            name: "addimage",
            meta: {
                requiresAuth: true,
            },
        },
    ],
});

routes.beforeEach((to, from, next) => {
    // check if the route requires authentication and user is not logged in
    if (
        to.matched.some((route) => route.meta.requiresAuth) &&
        !store.state.isLoggedIn
    ) {
        // redirect to login page
        next({ name: "login" });
        return;
    }

    // if logged in redirect to dashboard
    if (to.path === "/login" && store.state.isLoggedIn) {
        next({ name: "dashboard" });
        return;
    }

    next();
});

export default routes;
