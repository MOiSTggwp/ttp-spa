<template>
    <div
        class="fixed z-[1000] inset-0 w-full h-full bg-Dark bg-opacity-50 overflow-hidden flex justify-center items-center overflow-y-auto"
        @click.self="close"
        v-if="isOpen"
    >
        <div class="absolute top-0 left-0 w-full flex justify-end items-center gap-4 bg-Dark-m bg-opacity-50 py-2 px-4">
            <X
                @click.prevent="close"
            ></X>
            <X
                @click.prevent="close"
            ></X>
            <X
                @click.prevent="close"
            ></X>
            <X
                @click.prevent="close"
            ></X>
            <X
                class="w-8 h-8 cursor-pointer hover:text-Error active:text-Done transition-all duration-300"
                @click.prevent="close"
            ></X>
        </div>


        <div class="max-w-fit">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import {X} from 'lucide-vue';

export default {
    name: "U-Popup",
    components: {
        X,
    },
    data(){
        return {
            isOpen: false,
        }
    },
    methods: {
        scroll() {
            if (this.isOpen) {
                document.documentElement.style.overflow = 'hidden';
            } else {
                document.documentElement.style.overflow = 'auto';
            }
        },
        open() {
            this.isOpen = true;
        },
        close() {
            this.isOpen = false;
        }
    },
    watch: {
        isOpen() {
            this.scroll();
        }
    }
}
</script>

<style scoped>

</style>
