<template>
    <div class="w-full h-full">
        <input :id="id" hidden ref="file" type="file" @change="setFile">


            <label class="sm:w-full shadow-md shadow-Dark/[98%] bg-Dark rounded-md relative cursor-pointer group" :for="id">
                <Camera class="group-hover:w-12 group-hover:h-12 group-hover:opacity-60 transition-all w-10 h-10 text-Dark-l absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></Camera>
                <img v-if="show" class="w-full h-full object-cover aspect-auto cursor-pointer" :src="show" :alt="alt">

                <span v-else class="block w-full h-full bg-Dark-m/30 flex justify-center items-center">
                    <Camera class="group-hover:w-12 group-hover:h-12 w-10 h-10 text-Dark-l"></Camera>
                </span>
                <span class="text-Dark-l/80 select-none flex flex-col justify-end items-center bg-Dark/60 p-1 w-full h-full text-lg font-bold mt-7 absolute bottom-0 left-0">
                    <span>{{wh}}</span>
                    <span>Макс. размер ({{size}})</span>
                </span>
            </label>

    </div>
</template>

<script>
import {Camera} from 'lucide-vue';

export default {
    name: "Loader",
    components: {
        Camera,
    },
    props: {
        url: {
            default: '',
        },
        alt: {
            default: '',
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
    },
    data() {
        return {
            show: '',
            img: '',
        }
    },
    mounted() {
        this.showFile();
    },
    methods: {
        setFile() {
            if(this.$refs.file) {
                this.img = this.$refs.file.files[0];
                this.$emit('change', this.img);
            }
        },
        showFile() {
            if(this.$refs.file.files[0]) {
                let reader  = new FileReader();
                reader.addEventListener("load", function () {
                    this.show = reader.result;
                }.bind(this), false);

                if( this.img ){
                    if ( /\.(jpe?g|png|gif)$/i.test( this.img.name ) ) {
                        reader.readAsDataURL( this.img );
                    }
                }
            } else if (this.url) {
                this.show = this.url;
            } else {
                this.show = '';
            }
        },
    },
    watch: {
        img() {
            this.showFile();
        },
    }
}
</script>

<style scoped>

</style>
