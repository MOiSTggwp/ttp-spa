<template>
    <div class="w-full h-full">
        <div class="relative w-full h-full">
            <textarea
                v-model="input"
                class="min-h-full resize-none w-full text-md border-2 border-Dark-m outline-none pl-9 pr-3 py-1.5 rounded-md bg-transparent placeholder-transparent
                peer focus:border-Info"
                :id="arr.id"
                :placeholder="arr.text"
                :maxlength="arr.max"
            ></textarea>
            <label
                :for="arr.id"
                class="absolute left-2.5 -top-4 pb-1 text-sm font-bold text-Dark-l text-opacity-100 transition-all duration-300
                peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-md peer-placeholder-shown:px-7 peer-placeholder-shown:text-opacity-50
                peer-focus:-top-4 peer-focus:text-sm peer-focus:px-0 peer-focus:text-opacity-100"
            >{{ arr.text }}</label>
            <div class="absolute text-Dark-m top-1.5 left-1.5">
                <slot></slot>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "Textarea",

    props: ['arr'],

    data () {
        return {
            input: '',
            type: '',
        }
    },

    mounted () {
        if(this.arr.value)
            this.input = this.arr.value;
    },

    methods: {
        res() {
            this.$emit('res',[
                this.input
            ])
        },

        alertClose() {
            this.type = '';
        }
    },

    watch: {
        input() {
            this.res();
        }
    }
}
</script>

<style scoped>

</style>
