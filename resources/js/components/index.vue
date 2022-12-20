<template>
    <div class="flex relative min-h-screen text-Light">
        <U-Alerts></U-Alerts>
        <SideBar @sidebarStatus="sidebarStatus"></SideBar>
        <router-view
            class="container 2xl:mr-auto py-4"
            :class="{'mr-auto': !this.sidebar, '2xl:mr-0 2xl:ml-[340px]': this.sidebar}"
        ></router-view>
    </div>
</template>

<script>
import SideBar from './sidebar/SideBar';

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
