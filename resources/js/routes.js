import VueRouter from "vue-router"
import Products from "./products/products.vue"
import Example2 from "./components/Example2"
const routes = [
    {
        path :"/",
        component: Products,
        name : "home",
    },
    {
        path :"/two",
        component: Example2,
        name : "two",
    },
] 

const router = new VueRouter({
    mode:"history",
    routes
});

export default router;
