<template>
    <div class="d-flex">
        <i class="fas fa-star" v-for="full in fullStars"></i>
        <i class="fas fa-star-half-alt" v-if="halfStar"></i>
        <i class="far fa-star" v-for="empty in emptyStars"></i>
    </div>
</template>
<script>
export default {
    props:{
        rating:Number,
    },
    data(){
        return{

        }
    },
    computed:{
        fullStars(){
            return 2;
        },
        emptyStars(){
            return 2;
        },
        halfStar(){
            return true;
        }
    }
}
</script>
