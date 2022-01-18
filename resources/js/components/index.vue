<template>
    <div class="flex relative min-h-screen bg-Dark bg-opacity-[98%] text-Light">
        <SideBar @sidebarStatus="sidebarStatus"></SideBar>
        <router-view class="container 2xl:mr-auto pt-4"
                     :class="{'mr-auto': !this.sidebar, 'lg:mr-0 lg:ml-[340px]': this.sidebar}"
        ></router-view>
    </div>
</template>

<script>
import SideBar from './sidebar/SideBar'

export default {
    name: "index",

    components: {
        SideBar,
    },

    data() {
        return {
            sidebar: true,
        }
    },

    methods: {
        sidebarStatus(r) {
            this.sidebar = r[0];
        }
    },
}
</script>

<style scoped>

</style>
