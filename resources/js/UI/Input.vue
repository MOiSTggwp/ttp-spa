<template>
    <div>
        <div class="relative">
            <input
                v-model="input"
                :type="arr.type"
                class="h-10 w-full text-md border-2 border-Dark-m outline-none  rounded-md bg-transparent placeholder-transparent
                peer focus:border-Info"
                :class="{'border-Error': arr.error != null, 'pl-2 pr-2 py-2': !padding, 'pl-9 pr-3 py-0': padding}"
                :style="`width: ${width}px`"
                :id="arr.id"
                :placeholder="arr.text"
                @keydown.enter="res"
                @blur="res"
                @input="numbers"
            >
            <label
                :for="arr.id"
                class="absolute left-2.5 -top-4 pb-1 text-sm font-bold text-Dark-l text-opacity-100 transition-all duration-300
                peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-md  peer-placeholder-shown:text-opacity-50
                peer-focus:-top-4 peer-focus:text-sm peer-focus:px-0 peer-focus:text-opacity-100"
                :class="{'peer-placeholder-shown:px-7': padding}"
            >{{ arr.text }}</label>
            <div class="absolute text-Dark-m top-1/2 -translate-y-1/2 left-1.5">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Input",
    props: {
        arr: {},
        padding: {
            type: Boolean,
            default:true
        },
        width: null,
        min: 0,
        max: 0,
    },
    data() {
        return {
            input: '',
            type: '',
        }
    },
    mounted() {
        this.setValue();
    },
    methods: {
        res() {
            this.$emit('res', [
                this.input
            ])
        },
        numbers() {
            if (this.arr.type != 'number') return;
            console.log(123)
            if (this.input <= this.min) {
                this.input = this.min;
            }
            if (this.input >= this.max) {
                this.input = this.max;
            }
        },
        alertClose() {
            this.type = '';
        },
        setValue() {
            if (this.arr.value) this.input = this.arr.value;
        }
    },
    watch: {
        arr() {
            this.setValue();
        },
    }
}
</script>

<style scoped>
::-webkit-calendar-picker-indicator {
    filter: invert(1);
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}
</style>
