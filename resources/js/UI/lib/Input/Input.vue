<!--Настройки

val - Установленное значение :''
type - тип инпута :text
id - идентификатор инпута
text - текст плейсхолдера
placeholderUp - флаг перемещение плейсхолдера вверх или вниз
maxValue - макс. кол-во символов
width - ширина инпута
padding - отступы внутри инпута
error - флаг ошибки
-->
<template>
    <div>
        <div class="relative">
            <input
                v-bind="$attrs"
                v-model="input"
                :type="type"
                class="h-10 w-full text-md border-2 border-Dark-m outline-none bg-Dark rounded-md placeholder-transparent
                peer focus:border-Info placeholder:select-none disabled:bg-Dark-m/50"
                :class="{'border-Error': error, 'pl-2 pr-2 py-2': !padding, 'pl-9 pr-3 py-0': padding}"
                :style="`width: ${width}px`"
                :id="id"
                :placeholder="text"
                @keydown.enter="res"
                @input="maxLength"
            >
            <label
                :for="id"
                class="absolute left-2.5 text-sm font-bold text-Dark-l text-opacity-100 transition-all duration-300
                 peer-placeholder-shown:text-md peer-placeholder-shown:text-opacity-50
                 peer-focus:text-sm peer-focus:px-0 peer-focus:text-opacity-100 cursor-text select-none"
                :class="[{'peer-placeholder-shown:px-7': padding},
                placeholderUp
                ? '-top-4 pb-1 peer-focus:-top-4 peer-placeholder-shown:top-2.5'
                : '-bottom-4 pt-1 peer-focus:-bottom-4 peer-placeholder-shown:bottom-2.5']"
            >{{ text }}</label>
            <div v-if="$slots.default" class="absolute text-Dark-m top-1/2 -translate-y-1/2 left-1.5">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "U-Input",
    props: {
        val: {
            default: '',
        },
        type: {
          default: 'text',
        },
        text: {
            default: '',
        },
        maxValue: {
          default: '100',
        },
        width: {
            default: '',
        },
        padding: {
            default: true,
        },
        placeholderUp: {
            default: true,
        },
        error: {
            default: false,
        }
    },
    data() {
        return {
            input: '',
            id: '',
        }
    },
    mounted() {
        this.setValue();
        this.rand();
    },
    methods: {
        rand() {
            this.id = Math.random().toString(36).substr(2);
        },
        res() {
            this.$emit('res', this.input);
        },
        maxLength() {
            if (this.input.length >= this.maxValue) this.input = this.input.slice(0, this.maxValue);
            this.res();
        },
        setValue() {
            this.input = this.val;
            this.res();
        }
    },
    watch: {
        val() {
            this.setValue();
        },
        error() {
            this.setValue();
        }
    }
}
</script>

<style scoped>
::-webkit-calendar-picker-indicator {
    filter: invert(1);
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
