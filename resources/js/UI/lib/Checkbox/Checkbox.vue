<!--Настройки

data - Массив обьектов
checked - Массив выбранных обьектов
type - Тип инпута (checkbox, radio)
y - Если есть (y && n), то при выборе появляется этот текст
n - Если есть (y && n), то появляется если элемент не выбран
error - Флаг ошибки

$emit = change = [{}]
-->

<!--TODO: сделать смену флага error при изменении значения-->
<template>
    <div v-if="data">
        <div v-for="item in data" :key="item.id">
            <div class="flex items-start">
                <input :type="type" class="appearance-none" :name="item.name" :id="item.id" :value="item"
                       v-model="result" @change="pushUp"/>
                <div class="w-full h-6 grid grid-cols-7">
                    <div class="pt-1 pl-1">
                        <label :for="item.id" class="relative w-9 h-4 checkbox-block">
                            <span
                                :class="{ 'bg-Dark-m border-Info border-opacity-100': resFind(item), 'border-Error': error }"
                                class="z-40 checkbox-bg cursor-pointer inline-block absolute w-9 h-4 bg-Dark border-2 border-Dark-m rounded-md"></span>
                            <span :class="{ 'checkbox-pointer-checked !bg-Info !bg-opacity-100': resFind(item) }"
                                  class="z-40 checkbox-pointer cursor-pointer inline-block absolute top-1 left-1 w-2 h-2 bg-Dark-m rounded-md"></span>
                        </label>
                    </div>

                    <div class="ml-4 col-span-6 flex items-center">
                        <label :for="item.id" class="cursor-pointer">
                    <span class="block text-sm">
                        <span>
                            {{ item.name }}
                        </span>
                        <span v-if="y && n">
                            ({{ resFind(item) ? y : n }})
                        </span>
                    </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "U-Checkbox",
    props: {
        data: {
            default: [],
        },
        checked: {
            default: null,
        },
        type: {
            default: 'checkbox',
        },
        y: {
            default: ''
        },
        n: {
            default: '',
        },
        error: {
            default: false,
        },
    },
    data() {
        return {
            result: [],
        }
    },
    methods: {
        pushUp() {
            let res = [];
            if (!Array.isArray(this.result)) {
                res.push(this.result);
            } else {
                res = this.result;
            }

            this.$emit("res", res);
        },
        resFind(item) {
            if (Array.isArray(this.result)) {
                return this.result.find(i => i.id === item.id);
            }
            return item.id === this.result.id;
        }
    },
    watch: {
        checked() {
            this.result = this.checked;
            this.pushUp();
        }
    }
}
</script>

<style scoped>
.checkbox-bg {
    transition: background-color 400ms cubic-bezier(0.445, 0.05, 0.55, 0.95);
}

.checkbox-pointer {
    transform: rotate(-45deg);
    transition: all 400ms cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.checkbox-pointer-checked {
    transform: translate3d(1.35em, 0, 0) rotate(0);
}
</style>
