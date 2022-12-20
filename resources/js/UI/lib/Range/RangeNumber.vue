<!--Настройки

spacer - заголовок блока
withText - текст перед инпутом "№1"
beforeText - текст перед инпутом "№2"
withVal - установленное значение инпута "№1"
beforeVal - установленное значение инпута "№2"
min - мин. значение
max - макс. значение
step - шаг изминения значения
width - ширина инпута
same - флаг одинакового значения
-->
<template>
    <div class="flex flex-column gap-1 justify-center items-center">
        <U-Spacer v-if="spacer" h="7" position="center">
            {{ spacer }}
        </U-Spacer>
        <div class="flex gap-[10px] items-center">
            <U-Number
                @res="withInput"
                :val="withValue"
                :text="withText"
                :width="width"
                :min="min"
                :max="max"
                :step="step"
            ></U-Number>
            <div class="text-Light/50">
                &#10571;
            </div>
            <U-Number
                @res="beforeInput"
                :val="beforeValue"
                :text="beforeText"
                :width="width"
                :min="min"
                :max="max"
                :step="step"
            ></U-Number>
        </div>
    </div>
</template>

<script>
import {ChevronUp, ChevronDown} from 'lucide-vue';

export default {
    name: "URangeNumber",
    components: {
        ChevronUp,
        ChevronDown
    },
    props: {
        spacer: {
            default: '',
        },
        withText: {
            default: "",
        },
        beforeText: {
            default: "",
        },
        withVal: {
            default: "",
        },
        beforeVal: {
            default: "",
        },
        min: {
            default: '1',
        },
        max: {
            default: '24',
        },
        step: {
            default: '1',
        },
        width: {
            default: '100',
        },
        same: {
            default: false,
        }
    },
    data(){
        return {
            withValue: '',
            withOld: '',
            beforeValue: '',
            beforeOld: '',
        }
    },
    mounted(){
        if(!this.withVal) {
            this.withInput(this.min);
        } else {
            this.withInput(this.withVal);
        }
        if(!this.beforeVal) {
            this.beforeInput(this.max);
        } else {
            this.beforeInput(this.beforeVal);
        }
    },
    methods: {
        withInput(r) {
            this.withOld = this.setOldValue(this.withValue, this.withOld);
            this.withValue = this.sameCheck(r, this.withOld, this.beforeValue);
        },
        beforeInput(r) {
            this.beforeOld = this.setOldValue(this.beforeValue, this.beforeOld);
            this.beforeValue = this.sameCheck(r, this.beforeOld, this.withValue);
        },
        setOldValue(val, oldVal) {
            if(oldVal !== val) {
                oldVal = val;
            }
            return oldVal;
        },
        sameCheck(val, oldVal, otherVal) {
            if(this.same) {
                return val;
            }
            if(Number(val) === Number(otherVal)) {
                val = this.setNewValue(Number(val), Number(oldVal), Number(otherVal));
            }
            return val;
        },
        setNewValue(val, oldVal, otherVal) {
            if (val > oldVal) {
                if(oldVal === 1 && val === 24) {
                    val = otherVal - 1;
                } else {
                    val = otherVal + 1;
                }
            }
            if(val < oldVal) {
                if(oldVal === 24 && val === 1) {
                    val = otherVal + 1;
                } else {
                    val = otherVal - 1;
                }
            }
            return `${val}`;
        }
    },
}
</script>

<style scoped>

</style>
