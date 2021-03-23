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
            <availability :product-id="this.$route.params.id"></availability>
        </div>
    </div>
</template>

<script>
import Availability from "./availability"
import ReviewList from "./ReviewList"
export default ({
    components:{
        Availability,
        ReviewList
    },
    data() {
        return {
            product:null,
            loading:false,
        }
    },
    created() {
        this.loading = true;
        axios.get(`/api/products/${this.$route.params.id}`).then(response=>{
            this.product = response.data.data
            this.loading = false;
        });
    },
})
</script>
