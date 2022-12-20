<template>
    <div
        class="fixed z-[1000] inset-0 w-full h-screen bg-Dark bg-opacity-50 overflow-hidden flex justify-center items-center
        overflow-y-scroll select-none"
        @click.self="close"
        v-if="isOpen"
        @wheel="scroll"
    >
        <div
            v-if="scrolling"
            class="absolute z-[1001] left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 px-2 py-1  bg-Dark-m/50 text-Light/60 rounded-md"
        >
            {{ zoomInfo() }}
        </div>
        <div
            class="absolute z-[1001] top-0 left-0 w-full flex justify-end items-center gap-4 bg-Dark-m bg-opacity-50 py-2 px-4">
            <U-Hint text="Сбросить настройки">
                <RefreshCw
                    class="w-4 h-4 cursor-pointer hover:text-Warn active:text-Done transition-all duration-300 mr-2"
                    @click="refresh"
                ></RefreshCw>
            </U-Hint>

            <U-Hint text="Повернуть ⤹">
                <RotateCcw
                    class="w-4 h-4 cursor-pointer hover:text-Info active:text-Done transition-all duration-300"
                    @click="rotateLeft"
                ></RotateCcw>
            </U-Hint>
            <U-Hint text="Повернуть ⤸">
                <RotateCw
                    class="w-4 h-4 cursor-pointer hover:text-Info active:text-Done transition-all duration-300"
                    @click="rotateRight"
                ></RotateCw>
            </U-Hint>
            <U-Hint text="Увеличить +">
                <ZoomIn
                    class="w-4 h-4 text-Light transition-all duration-300"
                    :class="{'text-opacity-40 cursor-not-allowed': zoom >= 5, 'hover:text-Info active:text-Done cursor-pointer': zoom < 5}"
                    @click="zoomIn"
                ></ZoomIn>
            </U-Hint>
            <U-Hint text="Уменьшить −">
                <ZoomOut
                    class="w-4 h-4 text-Light transition-all duration-300"
                    :class="{'text-opacity-40 cursor-not-allowed': zoom <= 1, 'hover:text-Info active:text-Done cursor-pointer': zoom > 1}"
                    @click="zoomOut"
                ></ZoomOut>
            </U-Hint>
            <U-Hint text="Закрыть">
                <X
                    class="w-8 h-8 ml-4 cursor-pointer hover:text-Error active:text-Done transition-all duration-300"
                    @click="close"
                ></X>
            </U-Hint>
        </div>


        <div ref="imgBox" class="h-full pt-[58px] p-[10px] absolute z-[1000]" @mousedown="move">
            <img
                ref="img"
                class="w-full h-full object-cover aspect-auto cursor-move transition-all duration-500"
                :src="url"
                :alt="alt"
                draggable="false"
            >
        </div>
    </div>
</template>

<script>
import {X, ZoomIn, ZoomOut, RotateCw, RotateCcw, RefreshCw} from 'lucide-vue';

export default {
    name: "Zoom",
    components: {
        X,
        ZoomIn,
        ZoomOut,
        RotateCw,
        RotateCcw,
        RefreshCw,
    },
    props: {
        url: {
            default: '',
        },
        alt: {
            default: '',
        },
    },
    data() {
        return {
            isOpen: false,
            rotate: 0,
            zoom: 1,
            scrolling: false,
            timeout: 0,
        }
    },
    methods: {
        zoomInfo() {
            return Math.floor(this.zoom * 100) + '%';
        },
        scrollHidden() {
            let app = document.getElementById('app');
            let doc = document.documentElement;
            if (this.isOpen) {
                doc.style.overflow = 'hidden';
                app.style.paddingRight = '8px';
            } else {
                doc.style.overflow = 'auto';
                app.style.paddingRight = '0px';
            }
        },
        open() {
            this.isOpen = true;
        },
        close() {
            this.isOpen = false;
            this.refresh();
        },
        rotateRight() {
            this.rotate += 90;
            this.transform();
        },
        rotateLeft() {
            this.rotate -= 90;
            this.transform();
        },
        zoomIn() {
            if (this.zoom < 5) {
                this.zoom += 0.1;
                this.transform();
            }
        },
        zoomOut() {
            if (this.zoom > 1) {
                this.zoom -= 0.1;
                this.transform();
            }
        },
        scroll(e) {
            if (e.deltaY > 0) {
                this.zoomOut();
            } else {
                this.zoomIn();
            }
        },
        refresh() {
            this.zoom = 1;
            this.rotate = 0;
            this.transform();
            let img = this.$refs.imgBox;
            let doc = document.documentElement;
            img.style.left = `${doc.offsetWidth / 2 - img.offsetWidth / 2}px`;
            img.style.top = `${0}px`;
        },
        transform() {
            this.$refs.img.style.transform = `rotate(${this.rotate}deg) scale(${this.zoom})`;
        },
        move(e) {
            let img = this.$refs.imgBox;
            let shiftX = e.clientX - img.getBoundingClientRect().left;
            let shiftY = e.clientY - img.getBoundingClientRect().top;
            document.onmousemove = e => {
                img.style.left = `${e.clientX - shiftX}px`;
                img.style.top = `${e.clientY - shiftY}px`;
            }
            img.onmouseup = () => {
                document.onmousemove = null;
                img.onmouseup = null;
            }
            img.ondragstart = () => false;
        },
    },
    watch: {
        isOpen() {
            this.scrollHidden();
        },
        zoom() {
            clearTimeout(this.timeout);
            if(!this.scrolling) this.scrolling = true;
            this.timeout = setTimeout(() => {
                this.scrolling = false;
            }, 2000);
        }
    }
}
</script>

<style scoped>

</style>
