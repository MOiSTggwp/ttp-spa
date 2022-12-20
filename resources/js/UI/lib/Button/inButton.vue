<template>
    <div class="w-full flex justify-center gap-2" :class="[
                {'flex-column items-start': position == 'top' || position == 'bottom',
                'flex-row items-center': position != 'top' || position != 'bottom'},
                textStyle
              ]">
        <div
            v-if="$slots.default"
        >
            <slot></slot>
        </div>
        <div
            v-if="text"
            class="leading-0"
        >
            {{ text }}
        </div>
    </div>
</template>

<script>
export default {
    name: "Router",
    props: {
        text: {default: 'Кнопка'},
        position: {default: 'left'},
        textStyle: {default: 'uppercase text-xs'}
    }
}
</script>

<style scoped>

</style>
