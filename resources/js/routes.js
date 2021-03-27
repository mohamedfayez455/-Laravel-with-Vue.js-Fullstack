import VueRouter from "vue-router"
import Products from "./products/products.vue"
import Product from "./product/product.vue"
import Review from "./review/Review"
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
    {
        path :"/review/:id",
        component: Review,
        name : "review",
    },
]

const router = new VueRouter({
    mode:"history",
    routes
});

export default router;
