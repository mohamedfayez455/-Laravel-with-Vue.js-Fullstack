<template>
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">{{ productTitle }}</h1>
            <p class="card-text">{{ productDescription }}</p>
            <span class="card-text">{{ productPrice }}$</span>
        </div>
    </div>
</template>

<script>
export default {
    props:{"productTitle":String ,"productDescription":String ,"productPrice":Number  }
}
</script>