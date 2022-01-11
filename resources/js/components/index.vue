<template>
    <div>
        <router-link to="{ name: 'Home'}">Home</router-link>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "index"
}
</script>

<style scoped>

</style>
