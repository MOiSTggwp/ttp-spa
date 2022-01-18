<template>
    <div class="absolute z-10 bottom-0 left-0 w-screen" v-if="alert">
        <div
            class="absolute bottom-8 right-4 bg-Dark shadow-md p-4 flex justify-between items-center rounded-md text-base"
        >
            <div class="mr-2">
                <AlertCircle v-if="arr.type === 'error'" class="bg-Error rounded-full p-1"></AlertCircle>
                <AlertOctagon v-if="arr.type === 'info'" class="bg-Info rounded-full p-1"></AlertOctagon>
                <AlertTriangle v-if="arr.type === 'warn'" class="bg-Warn rounded-full p-1"></AlertTriangle>
                <CheckCircle v-if="arr.type === 'done'" class="bg-Done rounded-full p-1"></CheckCircle>
            </div>
            <div class="divide-y" :class="{
                    'divide-Error': arr.type === 'error',
                    'divide-Info': arr.type === 'info',
                    'divide-Warn': arr.type === 'warn',
                    'divide-Done': arr.type === 'done'
                }">
                <div v-for="error in arr.errors" class="first:pt-0 last:pb-0 py-1" :class="{
                    'text-Error': arr.type === 'error',
                    'text-Info': arr.type === 'info',
                    'text-Warn': arr.type === 'warn',
                    'text-Done': arr.type === 'done'
                }">
                    <div v-for="err in error">
                        {{ err }}
                    </div>
                </div>
            </div>

            <button @click.prevent="close" type="submit" class="ml-8">
                <XCircle></XCircle>
            </button>
        </div>
    </div>
</template>

<script>
import {XCircle, AlertCircle, AlertOctagon, AlertTriangle, CheckCircle} from 'lucide-vue';

export default {
    name: "Alert",

    components: {
        XCircle,
        AlertCircle,
        AlertOctagon,
        AlertTriangle,
        CheckCircle,
    },

    props: ['arr'],

    data() {
        return {
            alert: false,
        }
    },

    mounted() {
        this.open();
    },

    methods: {
        open() {
            if (this.arr.type != '') {
                this.alert = true;
            }
        },

        close() {
            this.alert = false;
            this.$emit('close');
        }
    },

    watch: {
        arr() {
            this.open();
        }
    }
}
</script>

<style scoped>

</style>
