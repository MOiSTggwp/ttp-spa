<!--Настройки

url - Ссылка + флаг переключения (ссылка или событие click)
-->
<template>
    <div
        class="inline mx-[1px] relative cursor-pointer before:transition-all before:duration-500 hover:before:skew-y-[5deg]
        before:block before:absolute before:-inset-[2px] before:-skew-y-[5deg] before:rounded-md before:rounded-bl-md before:bg-Info"
        @click="!url ? click() : null">
        <a :href="url ? url : '#'" class="p-[2px] py-[1px] relative rounded-md hover:text-Light"
        >
            <slot></slot>
        </a>
    </div>
</template>

<script>
export default {
    name: "U-Link",
    props: {
        url: {default: ''},
    },
    methods: {
        click() {
            this.$emit('click');
        }
    },
}
</script>

<style scoped>

</style>
