<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">price breakdown</h6>
        <div v-for="(day,price) in price.breakdown" :key="price" class="pt-2 pb-2 border-bottom border-top d-flex justify-content-between">
            <span>{{day}} x ${{price}}</span>
            <span>{{day * price}}</span>
        </div>
        <div class="pt-2 font-weight-bolder d-flex justify-content-between">
            <span>Total</span>
            <span>${{price.total}}</span>
        </div>
    </div>
</template>

<script>

export default({
    props: {price : Object},
    data(){
        return{
        }
    },
    created() {
    },
    methods: {
    },
    computed:{
    }
})
</script>
