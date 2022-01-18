<template>
    <div class="uppercase text-base font-bold w-full flex flex-col justify-center items-center">
        <slot></slot>
        <div class="w-8 h-0.5 rounded-full mt-1 bg-Info"></div>
    </div>
</template>

<script>
export default {
    name: "Label"
}
</script>

<style scoped>

</style>
