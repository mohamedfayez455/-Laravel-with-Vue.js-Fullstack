<template>
    <div class="row">
        <div class="col-md-8">
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
        </div>  
        <div class="col-md-4">
            xx
        </div>  
    </div>
</template>

<script>
export default ({
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
