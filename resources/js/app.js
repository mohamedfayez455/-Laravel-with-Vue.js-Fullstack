require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import router from "./routes"
import Index from './index'

Vue.use(VueRouter)

const app = new Vue({
    el: '#app',
    router,
    components:{
        "index":Index,
    }
});
