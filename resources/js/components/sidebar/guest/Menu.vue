<template>
    <div class="px-3 pt-3">
        <Login></Login>
    </div>
</template>

<script>
import Login from './Login';
import Registration from './Registration';


export default {
    name: "Menu",

    components: {
        Login,
        Registration,
    },
}
</script>

<style scoped>

</style>
