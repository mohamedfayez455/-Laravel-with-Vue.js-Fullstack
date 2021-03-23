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
                <div class="invalid-feedback" v-for="(error , index) in this.errorFor('from')" :key="'from' + index">{{error}}</div>
            </div>
            <div class="form-group col-md-6">
                <label for="to">To</label>
                <input type="text" name="to" @keyup.enter="check" v-model="to" :class="[{'is-invalid' : this.errorFor('to')}]" class="form-control form-control-sm" placeholder="End date">
                <div class="invalid-feedback" v-for="(error , index) in this.errorFor('to')" :key="'to' + index">{{error}}</div>
            </div>
        </div>
        <button @click="check" :disabled="loading" class="btn btn-secondary btn-block">Check!</button>
    </div>
</template>

<script>
export default({
    // props:{
    //    productId:String
    // },
    props:['productId'],
    data(){
        return{
            from:null,
            to:null,
            loading:false,
            errors:null,
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
                    if (error.response.status == 422){
                        this.errors = error.response.data.errors;
                    }
                    this.status = error.response.status;
                }).then(()=>{
                    this.loading = false;
            });
        },
            errorFor(field){
                return this.hasError && this.errors[field] ? this.errors[field]  :  null;
        },
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
