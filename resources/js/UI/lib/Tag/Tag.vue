<!--Настройки

color - цвет кнопки
border - стиль обводки
borderColor - цвет обводки
button - флаг отображения кнопки
-->
<template>
    <div v-if="$slots.default">
        <div class="flex min-w-fit border-[1px] bg-Dark-m/60 border-opacity-40 shadow-sm px-1 py-0.5 rounded-md items-center justify-between"
             :class="[borderStyle(), {'space-x-2': button}]"
        >
            <div class="whitespace-normal" v-bind="$attrs">
                <slot></slot>
            </div>
            <div>
                <U-Button
                    v-if="button"
                    @click="click"
                    type="small"
                    :tip="false"
                    text=""
                    position="top"
                    :color="color"
                >
                    <X class="w-[12px] h-[12px] text-Dark-m"></X>
                </U-Button>
            </div>
        </div>
    </div>
</template>

<script>
import {X} from 'lucide-vue';

export default {
    name: "U-Tag",
    props: {
        color: {default: 'light'},
        border: {default: 'solid'},
        borderColor: {default: 'light'},
        button: {default: true},
    },
    components: {
        X
    },
    methods: {
        click() {
            this.$emit('click');
        },
        borderStyle() {
            let borderColor = '';
            let border = '';
            switch (this.borderColor) {
                case 'done': borderColor = 'border-Done'; break;
                case 'error': borderColor = 'border-Error'; break;
                case 'info': borderColor = 'border-Info'; break;
                case 'warn': borderColor = 'border-Warn'; break;
                default: borderColor = 'border-Light'; break;
            }
            switch (this.border) {
                case 'dotted': border = 'border-dotted'; break;
                case 'dashed': border = 'border-dashed'; break;
                case 'double': border = 'border-double'; break;
                default: border = 'border-solid'; break;
            }
            return `${borderColor} ${border}`
        }
    }
}
</script>

<style scoped>

</style>
