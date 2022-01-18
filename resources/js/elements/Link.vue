<template>
    <a @click.prevent="click"
       class="max-w-min flex items-center text-sm space-x-2 hover:text-Info active:text-Done cursor-pointer transition-all duration-300">
        <slot></slot>
        <div v-if="arr.text != ''">{{ arr.text }}</div>
    </a>
</template>

<script>
export default {
    name: "Link",

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
