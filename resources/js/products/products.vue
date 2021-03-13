<template>
    <div>
        <div v-if="loading">
            <p>data is loading now ......</p>
        </div>
        <div v-else>
            <div class="row mb-4" v-for="row in rows" :key="'row'+row">
                <div class="col" v-for="(product , column) in productsInRow(row)" :key="'row' + row + column">
                    <Product
                    :product-title=" product.title "
                    :product-description=" product.description "
                    :product-price="product.price"
                    ></Product>
                </div>
                <div class="col" v-for="p in placeholderInRow(row)" :key="'placholder' + row + p"></div>
            </div>

        </div>

    </div>
</template>

<script>
import Product from './product'

export default ({
    components:{
        Product,
    },
    data(){
        return{
            products:null,
            loading:false,
            colums:3,
        }
    },
    computed:{
        rows(){
            return this.products == null ? 0 :  Math.ceil(this.products.length / this.colums) ;
        }
    },
    methods: {
        productsInRow(row){
            return this.products.slice((row-1) * this.colums , row * this.colums);
        },
        placeholderInRow(row){
            return this.colums - this.productsInRow(row).length ;
        },
    },
    created() {
        this.loading = true;
        setTimeout(()=>{
            this.products=[
                {title:"product1",description:"product 1 description" ,price:1000},
                {title:"product2",description:"product 2 description" ,price:2000},
                {title:"product2",description:"product 2 description" ,price:2000},
                {title:"product2",description:"product 2 description" ,price:2000},
                {title:"product2",description:"product 2 description" ,price:2000},
                {title:"product2",description:"product 2 description" ,price:2000},
                {title:"product2",description:"product 2 description" ,price:2000},
                {title:"product2",description:"product 2 description" ,price:2000},
                {title:"product2",description:"product 2 description" ,price:2000},
                {title:"product2",description:"product 2 description" ,price:2000},
                {title:"product2",description:"product 2 description" ,price:2000},
                {title:"product2",description:"product 2 description" ,price:2000},
                {title:"product2",description:"product 2 description" ,price:2000},
            ]
            this.loading = false;
            },3000);
    },
})
</script>
