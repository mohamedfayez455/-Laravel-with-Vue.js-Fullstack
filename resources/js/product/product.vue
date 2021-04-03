<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <div v-if="!loading">
                        <h2 >{{ product.title }}</h2>
                        <hr>
                        <article>{{ product.description }}</article>
                    </div>
                    <div v-else>
                        <p>loading.....</p>
                    </div>
                </div>
            </div>
            <ReviewList :product-id="this.$route.params.id"></ReviewList>
        </div>
        <div class="col-md-4 pb-4">

            <availability :product-id="this.$route.params.id" @availability="checkPrice($event)" class="mb-4"></availability>

            <transition name="fade">
                <price-breakdown v-if="price" :price="price" class="mb-4"></price-breakdown>
            </transition>

            <transition name="fade">
                <button class="btn btn-outline-secondary btn-block" :disabled="inBasketAlready" @click="addToBasket" v-if="price">Book now</button>
            </transition>

            <button class="btn btn-outline-secondary btn-block" v-if="inBasketAlready" @click="removeFromBasket" >remove From Basket</button>

            <div v-if="inBasketAlready" class="mt-4 text-muted warning">Seems likes you 'va add this object to basket already if you want to change date remove from basket first. </div>

        </div>
    </div>
</template>

<script>
import Availability from "./availability"
import priceBreakdown from "./PriceBreakdown"
import ReviewList from "./ReviewList"
import {mapState , mapGetters} from "vuex";

export default ({
    components:{
        Availability,
        ReviewList,
        priceBreakdown
    },
    data() {
        return {
            product:null,
            loading:false,
            price:null,
        }
    },
    created() {
        this.loading = true;
        axios.get(`/api/products/${this.$route.params.id}`).then(response=>{
            this.product = response.data.data
            this.loading = false;
        });
    },
    computed :{
        ...mapState({lastSearch : "lastSearch",}),
        inBasketAlready(){
            if(this.product == null){
                return false;
            }
            return this.$store.getters.inBasketAlready(this.product.id);
        }
    },

    methods:{
        async checkPrice(hasAvailability){
            if (!hasAvailability){
                this.price = null;
                return;
            }
            try {
                this.price = (await axios.get(`/api/product/${this.product.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`)).data.data;
            } catch (error) {
                this.price = null;
            }
        },
        addToBasket(){
            this.$store.dispatch("addToBasket" , {
                product: this.product,
                date: this.lastSearch,
                price : this.price,
            });
        },
        removeFromBasket(){
            this.$store.dispatch('removeFromBasket' , this.product.id);
        }
    }
})
</script>

<style scoped>
.warning{
    font-size: .7rem;
}
</style>
