<!--Настройки

text - текст кнопки
color - tailwind цвет кнопки
tip - флаг отображения подсказки
type - вариант кнопки (router, '')
link - ссылка для варианта кнопки router
position - вариант отступов и расположения внутри кнопки
textStyle - стиль текста
content - флаг переключения начального вида кнопки
active - флаг активности
disabled - флаг отключения
-->
<template>
    <U-Hint :text="text" :show="tip">
        <div>
            <router-link
                active-class="!shadow-md !bg-opacity-100 !text-Light !pointer-events-none"
                v-if="type == 'router'"
                class="w-full flex justify-center items-center rounded-md font-bold active:text-Done transition-all duration-500 text-Light text-opacity-70
                bg-opacity-70 disabled:bg-Dark-l hover:bg-opacity-100 hover:text-opacity-100 hover:text-Light"
                :class="[
                    slotFlex(),
                    checkContent()
                    ]"
                :to="{ name: link }"
                exact
            >
                <inButton
                    :text="text"
                    :position="position"
                    :text-style="textStyle"
                >
                    <slot></slot>
                </inButton>
            </router-link>

            <button
                @click.prevent="click"
                v-else
                class="w-full flex justify-center items-center rounded-md font-bold active:text-Done transition-all duration-500 text-Light text-opacity-80
                bg-opacity-80 disabled:bg-Dark-l hover:bg-opacity-100 hover:text-opacity-100"
                :class="[
                    slotFlex(),
                    checkContent()
                    ]"
                :disabled="active || disabled"
            >
                <inButton
                    :text="text"
                    :position="position"
                    :text-style="textStyle"
                >
                    <slot></slot>
                </inButton>
            </button>
        </div>
    </U-Hint>
</template>

<script>
import inButton from "./inButton";

export default {
    name: "U-Button",
    components: {
        inButton,
    },
    props: {
        type: {default: 'button'},
        tip: {default: true,},
        link: {default: ''},
        text: {default: 'Кнопка'},
        textStyle: {default: 'uppercase text-xs'},
        color: {default: 'info'},
        content: {default: false},
        position: {default: 'left',},
        active: {default: false},
        disabled: {default: false},
    },
    methods: {
        click() {
            if (!this.disabled || !this.active) this.$emit('click');
        },
        slotFlex() {
            let res = '';
            if (this.position === 'right') {
                res += this.small('flex-row-reverse space-x-2 space-x-reverse', 'px-4 py-2');
            } else if (this.position === 'top') {
                res += this.small('flex-column space-y-1', 'p-2.5');
            } else if (this.position === 'bottom') {
                res += this.small('flex-column-reverse space-y-1 space-y-reverse', 'p-2.5');
            } else {
                res += this.small('space-x-2', 'px-4 py-2');
            }

            return res;
        },
        small(atr, p) {
            if (this.type === 'small') {
                return atr + ' ' + 'm-[1px] rounded-full';
            } else {
                return atr + ' ' + p;
            }
        },
        checkContent() {
            return this.content ? ``
                                : `bg-${this.setColorStyle()} bg-opacity-50 hover:bg-${this.setColorStyle()} hover:bg-opacity-100`
        },
        setColorStyle() {
            return this.color[0].toUpperCase() + this.color.slice(1);
        }
    }
}
</script>

<style scoped>

</style>
