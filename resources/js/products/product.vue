<template>
    <div class="card w-100">
        <div class="card-body">
            <h1 class="card-title">{{ productTitle }}</h1>
            <p class="card-text">{{ productDescription }}</p>
        </div>
    </div>
</template>

<script>
export default {
    props:{"productTitle":String ,"productDescription":String ,"productPrice":Number  }
}
</script>