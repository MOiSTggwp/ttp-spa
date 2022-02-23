<template>
    <div>
        <a :href="arr.link" class="group" :title="arr.value ? 'отключить' : 'подключить'">
            <div class="flex justify-between items-center text-Light-l/40 w-full h-full bg-Dark-m/30 py-1 px-2 rounded-md">
                <div class="flex items-center text-xs mr-3">
                    <div class="w-2 h-2 rounded-full" :class="{'bg-Done': arr.value, 'bg-Light-l/40': !arr.value}"></div>

                    <div class="ml-1.5">
                        {{ arr.name }}
                    </div>
                </div>

                <div class="flex items-center">
                    <Link2 class="w-[20px] h-[20px] group-hover:text-Done" v-if="!arr.value"></Link2>
                    <Link2Off class="w-[20px] h-[20px] group-hover:text-Error" v-else></Link2Off>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
import {Link2, Link2Off} from 'lucide-vue';

export default {
    name: "ContactButton",

    components: {
        Link2,
        Link2Off
    },

    props: ['arr'],

}
</script>

<style scoped>

</style>
