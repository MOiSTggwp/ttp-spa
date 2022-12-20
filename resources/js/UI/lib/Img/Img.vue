<template>
    <div class="w-full border-Dark-m border-2 border-opacity-[47%] rounded-md overflow-hidden shadow-sm"
         :style="`width: ${w}px; height: ${h}px;`">
        <Loader
            v-if="loading"
            :url="url"
            :alt="alt"
            :wh="wh"
            :size="size"
            :id="id"
            @change="loadImg"
        ></Loader>
        <div v-else>
            <img
                class="w-full h-full object-cover aspect-auto cursor-pointer"
                :src="url"
                :alt="alt"
                @click.prevent="zoomOpen"
            >
            <Zoom ref="zoom" :url="url"></Zoom>
        </div>
    </div>
</template>

<script>
import Zoom from "./Zoom";
import Loader from "./Loader";

export default {
    name: "U-Img",
    components: {
        Zoom,
        Loader
    },
    props: {
        loading: {
            default: false,
        },
        wh: {
            default: '280 x 240',
        },
        size: {
            default: '1МБ',
        },
        id: {
            default: 'image',
        },
        url: {
            default: '',
        },
        alt: {
            default: '',
        },
        w: {
            default: '200',
        },
        h: {
            default: '',
        }
    },
    methods: {
        zoomOpen() {
            this.$refs.zoom.open();
        },
        loadImg(r) {
            this.$emit('change', r);
        }
    }
}
</script>

<style scoped>

</style>
