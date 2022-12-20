<!--Настройки

text - текст перед инпутом
val - установленное значение
width - ширина инпута
min - мин. значение
max - макс. значение
-->
<template>
    <div class="flex max-w-fit">
        <div v-if="text"
             class="!border-r-0 flex flex-initial min-h-max justify-center items-center p-1.5 border-2 border-Dark-m bg-Dark text-Light/50 rounded-l-md
                    relative after:h-[2px] after:w-[4px] after:absolute after:block after:-right-[4px] after:-top-[2px] after:bg-Dark-m
                    before:h-[2px] before:w-[4px] before:absolute before:block before:-right-[4px] before:-bottom-[2px] before:bg-Dark-m">
            {{ text }}
        </div>
        <U-Input
            type="number"
            :padding="false"
            :width="width"
            @res="res"
            :val="input"
            :max="+max"
            :min="+min"
            v-bind="$attrs"
        ></U-Input>
        <div class="h-auto min-h-full flex flex-column justify-center items-center relative">
            <button
                class="block h-3/6 hover:h-5/6 !border-l-0 hover:text-Light !border-b-0 transition-all duration-300 border-2 border-Dark-m bg-Dark
                text-Light/50 rounded-tr-md relative after:h-[2px] after:w-[4px] after:absolute after:block after:-left-[4px] after:-top-[2px] after:bg-Dark-m"
                @click="setInput(Number(input) + 1)"
            >
                <ChevronUp class="w-4 h-4"></ChevronUp>
            </button>
            <button
                class="block h-3/6 hover:h-5/6 !border-l-0 hover:text-Light !border-t-0 transition-all duration-300 border-2 border-Dark-m bg-Dark
                text-Light/50 rounded-br-md relative after:h-[2px] after:w-[4px] after:absolute after:block after:-left-[4px] after:-bottom-[2px] after:bg-Dark-m"
                @click="setInput(Number(input) - 1)"
            >
                <ChevronDown class="w-4 h-4"></ChevronDown>
            </button>
        </div>
    </div>
</template>

<script>
import {ChevronUp, ChevronDown} from 'lucide-vue';

export default {
    name: "U-Number",
    components: {
        ChevronUp,
        ChevronDown
    },
    props: {
        text: {
            default: '',
        },
        width: {
            default: '50',
        },
        min: {
            default: '1',
        },
        max: {
            default: '24',
        },
        val: {
            default: '',
        }
    },
    data() {
        return {
            input: '',
        }
    },
    mounted() {
        this.setInput(this.val);
    },
    methods: {
        res(r) {
            this.$emit('res', r);
        },
        setInput(val) {
            this.input = this.rangeCheck(val);
        },
        rangeCheck(val) {
            if (Number(val) < Number(this.min)) {
                val = this.max;
            }
            if (Number(val) > Number(this.max)) {
                val = this.min;
            }
            return val+'';
        },
    },
    watch: {
        val() {
            this.setInput(this.val);
        }
    }
}
</script>

<style scoped>

</style>
