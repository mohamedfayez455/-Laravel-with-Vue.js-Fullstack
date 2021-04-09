import ValidationError from "./shared/components/ValidationErrors";

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import Vuex from 'vuex'
import router from "./routes"
import Index from './index'
import moment from "moment"
import starRating from "./shared/components/StarRating"
import FatalError from "./shared/components/FatalError"
import Success from "./shared/components/Success"
import ValidationErrors from "./shared/components/ValidationErrors"
import StoreDefinition from "./store"

Vue.filter("fromNow" , value => moment(value).fromNow());

Vue.component('star-rating', starRating);
Vue.component('fatal-error', FatalError);
Vue.component('success', Success);
Vue.component('v-error', ValidationErrors);

Vue.use(VueRouter)
Vue.use(Vuex)

const store = new Vuex.Store(StoreDefinition);

window.axios.interceptors.response.use(
    response =>{
        return response;
    },
    error=>{
        if(error.response.status == 401 ){
            store.dispatch("logout");
        }
        return Promise.reject(error);

    }
)
const app = new Vue({
    el: '#app',
    router,
    store,
    components:{
        "index":Index,
    },
    async beforeCreate() {
        this.$store.dispatch('LoadStoredState');
        this.$store.dispatch("loadUser");
    }

});
