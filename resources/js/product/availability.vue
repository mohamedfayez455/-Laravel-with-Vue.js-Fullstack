<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">
            Check Availability
            <span class="text-danger" v-if="noAvailability">(NOT Available)</span>
            <span class="text-success" v-if="hasAvailability">(Available)</span>
        </h6>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="form">From</label>
                <input type="text" name="from" @keyup.enter="check" v-model="from" :class="[{'is-invalid' : this.errorFor('from')}]" class="form-control form-control-sm" placeholder="Start date">
                <v-error :errors="errorFor('from')"></v-error>
            </div>
            <div class="form-group col-md-6">
                <label for="to">To</label>
                <input type="text" name="to" @keyup.enter="check" v-model="to" :class="[{'is-invalid' : this.errorFor('to')}]" class="form-control form-control-sm" placeholder="End date">
                <v-error :errors="errorFor('to')"></v-error>
            </div>
        </div>
        <button @click="check" :disabled="loading" class="btn btn-secondary btn-block">Check!</button>
    </div>
</template>

<script>
import {is422} from './../shared/utils/response';
import ValidationErrorsFunction from '../shared/mixins/ValidationErrosrFunction';

export default({
    mixins:[ValidationErrorsFunction],
    props:['productId'],
    data(){
        return{
            from:null,
            to:null,
            loading:false,
            status:null
        }
    },
    created() {
    },
    methods: {
        check(){
            this.loading = true;
            this.errors = null;
            axios.get(`/api/product/${this.productId}/availability?from=${this.from}&to=${this.to}`)
                .then(response=>{
                    this.status = response.status;
                }).catch(error=>{
                    console.log(error)
                    if (is422(error)){
                        this.errors = error.response.data.errors;
                    }
                    this.status = error.response.status;
                }).then(()=>{
                    this.loading = false;
            });
        }
    },
    computed:{
        hasError(){
            return this.status == 422 && this.errors !== null;
        },
        hasAvailability(){
            return this.status == 200;
        },
        noAvailability(){
            return this.status == 404;
        },
    }
})
</script>


<style scoped>
    label{
        font-size: 0.7rem;
        text-transform: uppercase;
        color:gray;
        font-weight: bold;
    }
    .is-invalid{
        border-color: #b22222;
        background-image: none;
    }
    .invalid-feedback{
        color:#b22222 ;
    }
</style>
