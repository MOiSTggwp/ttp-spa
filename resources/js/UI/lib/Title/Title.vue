<!--Настройки

h - Размер шрифта + толшина и ширина линии
-->
<template>
    <div v-if="$slots.default"
         class="relative uppercase text-center font-[900]
         after:inline-block after:pseudo-content-comma after:mt-1 after:bg-Info after:absolute after:-translate-x-1/2 after:rounded-md"
         :class="[line()]"
    >
        <h1 v-if="h === '1'" class="text-4xl">
            <slot></slot>
        </h1>
        <h2 v-else-if="h === '2'" class="text-3xl">
            <slot></slot>
        </h2>
        <h3 v-else class="text-2xl">
            <slot></slot>
        </h3>
    </div>
</template>

<script>
export default {
    name: "U-Title",
    props: {
        h: {default: '1'},
    },
    methods: {
        line() {
            if (this.h === '1') {
                return 'after:w-10 after:h-[4px]';
            } else if (this.h === '2') {
                return 'after:w-9 after:h-[3px]';
            } else {
                return 'after:w-8 after:h-[2px]';
            }
        },
    }
}
</script>

<style scoped>

</style>
