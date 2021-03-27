import ValidationError from "./shared/components/ValidationErrors";

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import router from "./routes"
import Index from './index'
import moment from "moment"
import starRating from "./shared/components/StarRating"
import FatalError from "./shared/components/FatalError"
import Success from "./shared/components/Success"
import ValidationErrors from "./shared/components/ValidationErrors"

Vue.filter("fromNow" , value => moment(value).fromNow());

Vue.component('star-rating', starRating);
Vue.component('fatal-error', FatalError);
Vue.component('success', Success);
Vue.component('v-error', ValidationErrors);

Vue.use(VueRouter)

const app = new Vue({
    el: '#app',
    router,
    components:{
        "index":Index,
    }
});
