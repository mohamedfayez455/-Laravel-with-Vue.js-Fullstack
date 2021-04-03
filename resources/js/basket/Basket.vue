<template>
    <div>
        <success v-if="success">congratulations on your purchase! </success>

        <div class="row" v-else>

            <div class="col-md-8" v-if="itemsInBasket">

                <div class="row">

                    <div class="col-md-6 form-group">
                        <label for="first_name">First name</label>
                        <input type="text" name="first_name" class="form-control" :class="[{'is-invalid' : errorFor('customer.first_name')}]" v-model="customer.first_name"/>
                    </div>
                    <v-error :errors="errorFor('customer.first_name')"></v-error>

                    <div class="col-md-6 form-group">
                        <label for="last_name">Last name</label>
                        <input type="text" name="last_name" class="form-control" :class="[{'is-invalid' : errorFor('customer.last_name')}]" v-model="customer.last_name"/>
                    </div>
                    <v-error :errors="errorFor('customer.last_name')"></v-error>

                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" :class="[{'is-invalid' : errorFor('customer.email')}]" v-model="customer.email"/>
                    </div>
                    <v-error :errors="errorFor('customer.email')"></v-error>
                </div>

                <div class="row">

                    <div class="col-md-6 form-group">
                        <label for="street">Street</label>
                        <input type="text" name="street" class="form-control" :class="[{'is-invalid' : errorFor('customer.street')}]" v-model="customer.street"/>
                    </div>
                    <v-error :errors="errorFor('customer.street')"></v-error>

                    <div class="col-md-6 form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" class="form-control" :class="[{'is-invalid' : errorFor('customer.city')}]" v-model="customer.city"/>
                    </div>
                    <v-error :errors="errorFor('customer.city')"></v-error>

                </div>

                <div class="row">

                    <div class="col-md-6 form-group">
                        <label for="country">Country</label>
                        <input type="text" name="country" class="form-control" :class="[{'is-invalid' : errorFor('customer.country')}]" v-model="customer.country"/>
                    </div>
                    <v-error :errors="errorFor('customer.country')"></v-error>

                    <div class="col-md-4 form-group">
                        <label for="state">State</label>
                        <input type="text" name="state" class="form-control" :class="[{'is-invalid' : errorFor('customer.state')}]" v-model="customer.state"/>
                    </div>
                    <v-error :errors="errorFor('customer.state')"></v-error>

                    <div class="col-md-2 form-group">
                        <label for="zip">Zip</label>
                        <input type="text" name="zip" class="form-control" :class="[{'is-invalid' : errorFor('customer.zip')}]" v-model="customer.zip"/>
                    </div>
                    <v-error :errors="errorFor('customer.zip')"></v-error>

                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-lg btn-primary btn-block" :disabled="loading" @click.prevent="book">Book now!</button>
                    </div>
                </div>

            </div>

            <div class="col-md-8" v-else>
                <div class="jumbotron jumbotron-fluid text-center">
                    <h1>Empty</h1>
                </div>
            </div>

            <div class="col-md-4">

                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase text-secondary font-weight-bolder">your cart</h6>
                    <h6 class="text-uppercase badge badge-secondary">
                        <span v-if="itemsInBasket">{{itemsInBasket}} items</span>
                        <span v-else>empty</span>
                    </h6>
                </div>

                <transition-group name="fade">

                    <div v-for="item in basket" :key="item.product.id">

                        <div class="pt-2 pb-2 border-top d-flex justify-content-between">
                        <span>
                            <router-link :to="{name:'product' , params:{id : item.product.id}}">
                                {{item.product.title}}
                            </router-link>
                        </span>
                            <span class="font-wight-bold">${{item.price.total}}</span>
                        </div>

                        <div class="pt-2 pb-2  d-flex justify-content-between">
                            <span>From {{item.date.from}}</span>
                            <span>To {{item.date.to}}</span>
                        </div>

                        <div class="pt-2 pb-2 text-right">
                            <button class="btn btn-sm btn-outline-secondary" @click="$store.dispatch('removeFromBasket' , item.product.id)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>

                    </div>

                </transition-group>

            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapGetters} from "vuex"
    import ValidationErrorsFunction from "../shared/mixins/ValidationErrosrFunction";

    export default {
        mixins:[ValidationErrorsFunction],
        data(){
          return{
              loading:false,
              bookingAttempted:false,
              customer:{
                  first_name:null,
                  last_name:null,
                  email:null,
                  street:null,
                  city:null,
                  country:null,
                  state:null,
                  zip:null,
              }
          }
        },
        computed:{
            ...mapState({
                basket :state => state.basket.items,
            }),
            ...mapGetters(["itemsInBasket"]),
            success(){
                return !this.loading && this.itemsInBasket == 0 && this.bookingAttempted == true ;
            }
        },
        methods:{
            async book(){
                this.loading = true
                this.bookingAttempted = false
                this.errors = null
                try {
                    await axios.post(`api/checkout` , {
                        customer : this.customer,
                        bookings : this.basket.map(item => ({
                            'product_id' : item.product.id,
                            'from' : item.date.from,
                            'to' : item.date.to,
                        }))
                    })
                    this.$store.dispatch('clearBasket');
                }catch (errors) {
                    this.errors = errors.response && errors.response.data.errors;
                }
                this.loading = false;
                this.bookingAttempted = true;
            },
        }
    }
</script>

<style>
    h6.badge{
        font-size: 100%;
    }
    a{
        color: black;
    }
</style>
