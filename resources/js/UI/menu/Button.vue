<template>
    <router-link
        active-class="!shadow-md !bg-opacity-100 !text-Info"
        class="bg-Dark-m bg-opacity-60 shadow-sm flex flex-col p-3 rounded-md justify-center items-center text-Dark-l font-bold
                hover:shadow-md hover:bg-opacity-100 hover:text-Info active:text-Done transition-all duration-500"
        :to="{ name: link }" exact>
        <div class="h-4/5 flex justify-center items-center">
            <slot></slot>
        </div>
        <div class="h-1/5 text-xs uppercase flex justify-center items-start">
            {{ text }}
        </div>
    </router-link>
</template>

<script>
export default {
    name: "Button",

    props: ['arr'],

    data() {
        return {
            text: this.arr.text,
            link: this.arr.link,
        }
    }
}
</script>

<style scoped>

</style>
