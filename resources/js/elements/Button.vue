<template>
    <button @click.prevent="click"
            class="w-full h-10 bg-Info flex space-x-2 justify-center items-center
            hover:bg-Info-m hover:bg-opacity-80 transition-all duration-300
            rounded-md"
    >
        <slot></slot>
        <div>{{ arr.text }}</div>
    </button>
</template>

<script>
export default {
    name: "Button",

    props: ['arr'],

    methods: {
        click() {
            this.$emit('click');
        }
    },
}
</script>

<style scoped>

</style>
