<template>
    <div class="flex items-center">

        <input type="checkbox" class="appearance-none" :name="arr.name" :id="arr.id" v-model="val"/>

        <div class="w-full h-6 grid grid-cols-7">

            <div class="pt-1 pl-1">
                <label :for="arr.id" class="relative w-9 h-4 checkbox-block">
                    <span :class="{ 'bg-Info': val }" class="z-40 checkbox-bg cursor-pointer inline-block absolute w-9 h-4 bg-Dark border-2 border-Dark-m rounded-md"></span>
                    <span :class="{ 'checkbox-pointer-checked bg-Light': val }" class="z-40 checkbox-pointer cursor-pointer inline-block absolute top-1 left-1 w-2 h-2 bg-Dark-m rounded-md"></span>
                </label>
            </div>

            <div class="ml-4 col-span-6 flex items-center">
                <label :for="arr.id" class="cursor-pointer">
                    <span class="block text-sm">
                        <span>
                            {{ arr.title }}
                        </span>
                        <span v-if="arr.y && arr.n">
                            ({{ text }})
                        </span>
                    </span>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SoloCheckboxElement",

    props: ['arr'],

    data() {
        return {
            val: false,
            text: '',
        }
    },
    mounted() {
        this.yesno();
        if(this.arr.model)
        this.val = this.arr.model;
    },
    methods: {
        yesno() {
            if (this.val) {
                this.text = this.arr.y;
            } else {
                this.text = this.arr.n;
            }
        },
        res() {
            this.$emit('res', [
                this.val,
            ])
        },
    },
    watch: {
        val() {
            this.yesno();
            this.res();
        },
    },
}
</script>

<style scoped>
.checkbox-bg {
    transition: background-color 200ms cubic-bezier(0.445, 0.05, 0.55, 0.95);
}

.checkbox-pointer {
    transform: rotate(-45deg);
    transition: all 400ms cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.checkbox-pointer-checked {
    transform: translate3d(1.35em, 0, 0) rotate(0);
}
</style>
