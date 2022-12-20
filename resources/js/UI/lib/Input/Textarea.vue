<!--Настройки

value - заданное значение
id - идентификатор textarea
text - текст плейсхолдера
max - макс. кол-во символов
padding - отступ внутри
error - флаг ошибки
-->
<template>
    <div class="w-full h-full">
        <div class="relative w-full h-full">
            <textarea
                v-model="input"
                class="min-h-full resize-none w-full text-md border-2 border-Dark-m outline-none rounded-md bg-Dark placeholder-transparent
                peer focus:border-Info placeholder:select-none"
                :class="{'border-Error': error, 'pl-2 pr-2 py-2': !padding, 'pl-9 pr-3 py-1.5': padding}"
                :id="id"
                :placeholder="placeholder()"
                :maxlength="max"
            ></textarea>
            <label
                :for="id"
                class="absolute left-2.5 -top-4 pb-1 text-sm font-bold text-Dark-l text-opacity-100 transition-all duration-300
                peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-md peer-placeholder-shown:text-opacity-50
                peer-focus:-top-4 peer-focus:text-sm peer-focus:px-0 peer-focus:text-opacity-100 select-none cursor-text"
                :class="{'peer-placeholder-shown:px-7': padding}"
            >{{ placeholder() }}</label>
            <div class="absolute text-Dark-m top-1.5 left-1.5">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "U-Textarea",
    props: {
        value: {
            default: '',
        },
        id: {
            default: 'textarea',
        },
        text: {
            default: '',
        },
        max: {
            default: 500,
        },
        padding: {
            default: true,
        },
        error: {
            default: false,
        }
    },
    data() {
        return {
            input: '',
        }
    },
    mounted() {
        this.input = this.value;
    },
    methods: {
        res() {
            this.$emit('res', this.input);
        },

        placeholder() {
            return `${this.text} ${this.input.length < 1 ? `(макс. ${this.max})` : `(еще: ${this.max - this.input.length})`}`;
        }
    },
    watch: {
        input() {
            this.res();
        },
        value() {
            this.input = this.value;
        }
    }
}
</script>

<style scoped>

</style>
