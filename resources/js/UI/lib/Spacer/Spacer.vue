<!--Настройки

h - Размер шрифта + толшина линий
position - Расположение текста
-->
<template>
    <div v-if="$slots.default" class="flex w-full items-center py-0.5 font-[400] uppercase text-center
    after:inline-block after:bg-Info after:opacity-60 after:ml-3
    before:inline-block before:bg-Info before:opacity-60 before:mr-3"
         :class="lineHight()"
    >
        <div v-if="h" class="min-w-fit">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "U-Spacer",
    props: {
        h: {default: '4'},
        position: {default: 'left'}
    },
    methods: {
        lineHight() {
            let res = '';

            if (this.h === '1' || this.h === '2') {
                res = 'after:h-[2px] before:h-[2px] text-lg';
            } else if (this.h === '3') {
                res = 'after:h-[2px] before:h-[2px] text-base';
            } else if (this.h === '4') {
                res = 'after:h-[1px] before:h-[1px] text-sm';
            } else {
                res = 'after:h-[1px] before:h-[1px] text-xs';
            }

            if (this.position === 'center') {
                res += ` after:w-full before:w-full`;
            } else if (this.position === 'right') {
                res += ` after:w-[6%] before:w-full`;
            } else {
                res += ` after:w-full before:w-[6%]`;
            }

            return res;
        }
    }
}
</script>

<style scoped>

</style>
