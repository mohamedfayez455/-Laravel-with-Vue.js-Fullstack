import VueRouter from "vue-router"
import Products from "./products/products.vue"
import Product from "./product/product.vue"
const routes = [
    {
        path :"/",
        component: Products,
        name : "home",
    },
    {
        path :"/Products/:id",
        component: Product,
        name : "product",
    },
] 

const router = new VueRouter({
    mode:"history",
    routes
});

export default router;
