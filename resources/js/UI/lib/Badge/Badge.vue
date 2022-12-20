<!--Настройки (обернуть низний элемент)

data - Значение внутри значка
label - Флаг режима значка
size - Внутренние отступы или размер значка если нет data
color - Цвет значка
position - Позиция значка
-->
<template>
    <div class="relative max-w-fit">
        <div
            v-if="!label"
            ref="badge"
            :class="[`bg-${color[0].toUpperCase() + color.slice(1)}`]"
            class="absolute rounded-full animate-bounce flex justify-center items-center leading-none"
            :style="style"
        >
            <span v-if="data" v-bind="$attrs">
                {{ data }}
            </span>
        </div>
        <div
            v-else
            ref="badge"
            :class="[
                `px-${Number(size)+2}`,
                `py-${size}`,
                `bg-${color[0].toUpperCase() + color.slice(1)}`,
                labelPosition()
                ]"
            class="absolute shadow-md z-[5] rounded-md leading-none after:bg-opacity-50
            after:z-[0] after:block after:absolute after:-bottom-[4px] after:w-[5px] after:h-[4px]"
            :style="style"
        >
            <span v-if="data" v-bind="$attrs">
                {{ data }}
            </span>
        </div>
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "U-Badge",
    props: {
        data: {default: ''},
        label: {default: false},
        color: {default: 'error'},
        position: {
            default: () => {
                return ['left', 'top'];
            }
        },
        size: {default: '2'}
    },
    data() {
        return {
            badge: null,
            style: '',
        }
    },
    mounted() {
        this.badge = this.$refs.badge;
    },
    methods: {
        setPosition() {
            let wb = this.badge.offsetWidth;
            let hb = this.badge.offsetHeight;
            if (this.label) {
                return `${this.position[0]}: -5px; ${this.position[1]}: ${hb * 0.5}px;`;
            }
            return `${this.data ? `padding: ${this.size}px ${Number(this.size)+1}px; ${this.position[0]}: -${wb/3}px; ${this.position[1]}: -${hb/3}px;`
                : `width:${this.size}px; height:${this.size}px; ${this.position[0]}: -${this.size/3}px; ${this.position[1]}: -${this.size/3}px;`}`;
        },
        labelPosition() {
            let res = '';
            if(this.position[0] === 'right') {
                res += `after:bg-${this.color[0].toUpperCase() + this.color.slice(1)} !rounded-r-none after:right-0 after:rounded-br-full`
            } else {
                res += `after:bg-${this.color[0].toUpperCase() + this.color.slice(1)} !rounded-l-none after:left-0 after:rounded-bl-full`
            }
            return res;
        }
    },
    watch: {
        badge() {
            this.style = this.setPosition();
        }
    }
}
</script>

<style scoped>

</style>
