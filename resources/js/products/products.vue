<template>
    <div>
        <div v-if="loading">
            <p>data is loading now ......</p>
        </div>
        <div v-else>
            <div class="row mb-4" v-for="row in rows" :key="'row'+row">
                <div class="col d-flex align-items-stretch" v-for="(product , column) in productsInRow(row)" :key="'row' + row + column">
             
                <!--here if you want to bind each props   -->
                    <!-- <Product
                    :title=" product.title "
                    :description=" product.description "
                    ></Product> -->
                    
                <!--  here if you want to bind all props as object   -->
                    <Product v-bind="product"></Product>


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
        let p = new Promise((resolve,reject)=>{
            console.log(resolve); 
            console.log(reject); 
            setTimeout(()=>reject("error"),300);
        })
        .then((value)=> console.log(value))
        .catch((value)=>console.log(value));
        console.log(p);

        let data = axios.get("/api/products").then(response=>{
            this.products = response.data.data;
            this.loading = false;
        });
    },
})
</script>
