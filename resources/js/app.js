require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import router from "./routes"
import Index from './index'
import moment from "moment"
import starRating from "./shared/components/StarRating"

Vue.filter("fromNow" , value => moment(value).fromNow());

Vue.component('starRating', starRating);

Vue.use(VueRouter)

const app = new Vue({
    el: '#app',
    router,
    components:{
        "index":Index,
    }
});
