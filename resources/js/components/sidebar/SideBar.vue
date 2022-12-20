<template>
    <div class="fixed z-50 inset-y-0 left-0 -translate-x-[99%] transition-all duration-300 w-[300px] bg-Dark"
         :class="{'-translate-x-0': open}">
        <div class="text-3xl text-Light-l font-bold flex justify-center items-center p-3">
            > Team<span class="text-Info">ToPlay <</span>
        </div>
        <div class="relative w-full">
            <div @click="open = !open"
                 class="absolute z-50 w-10 h-10 -right-9 -top-5 bg-Dark rounded-r-md flex justify-center items-center">
                <Menu class="text-Dark-m hover:text-Info active:text-Done" v-if="!open"></Menu>
                <X class="text-Dark-m hover:text-Error active:text-Done" v-else></X>
            </div>
        </div>
        <div class="border-t opacity-10 mb-3"></div>

        <div class="pb-3 px-3" v-if="!auth">
            <U-Button @click="menuType = 'login'" v-if="menuType !== 'login'" text="Войти" :tip="false">
                <LogIn></LogIn>
            </U-Button>
            <U-Button @click="menuType = 'registration'" v-if="menuType === 'login'" text="Регистрация" :tip="false">
                <UserCheck></UserCheck>
            </U-Button>
        </div>
        <div class="pb-3 px-3 flex justify-between items-center" v-else>
            <Link
                @click="logout"
                class="hover:bg-Dark-m hover:bg-opacity-90 hover:text-Error rounded-md p-1.5 text-Dark-m"
                :arr="{ text: '' }"
            >
                <LogOut class="w-[24px] h-[24px]"></LogOut>
            </Link>
            <InfoBar></InfoBar>
        </div>

        <div class="border-t opacity-10 mb-3"></div>

        <Link class="ml-3" @click="menuType = 'main'" v-if="menuType === 'login' || menuType === 'registration'" :arr="{ text: 'назад' }">
            <ArrowLeft class="w-[16px] h-[16px]"></ArrowLeft>
        </Link>

        <MenuLogin v-if="menuType === 'login' && !auth" @token="getToken"></MenuLogin>
        <MenuRegistration v-if="menuType === 'registration' && !auth" @token="getToken"></MenuRegistration>
        <MenuMain v-if="menuType !== 'login' && menuType !== 'registration'" :auth="auth"></MenuMain>

    </div>
</template>

<script>
import MenuMain from './auth/Menu';
import MenuLogin from './guest/Login';
import MenuRegistration from './guest/Registration';
import Link from '../../UI/Link';
import InfoBar from './auth/InfoBar';
import {Menu, X, LogIn, UserCheck, ArrowLeft, LogOut} from 'lucide-vue';

export default {
    name: "SideBar",

    components: {
        MenuMain,
        MenuLogin,
        MenuRegistration,
        Menu,
        X,
        LogIn,
        UserCheck,
        ArrowLeft,
        Link,
        LogOut,
        InfoBar,
    },

    data() {
        return {
            open: true,
            menuType: 'main',
            auth: '',
        }
    },

    mounted() {
        this.sidebarStatus();
        this.getToken();
    },

    updated() {
        this.getToken();
    },

    methods: {
        sidebarStatus() {
            let sidebar = localStorage.getItem('sidebar') === 'true' ? this.open = true : this.open = false;
            this.open = sidebar;
            console.log(this.open, sidebar)
        },

        logout() {
            axios.post('/logout').then(res => {
                localStorage.removeItem('token');
                this.$router.push({ name: 'home' });
                this.auth = '';
            });
        },

        getToken() {
            const token = localStorage.getItem('token');
            if(token) {
                this.auth = token;
                this.menuType = 'main';
            }
        }
    },

    watch: {
        open() {
            this.$emit('sidebarStatus', [
                this.open
            ]);
            localStorage.removeItem('sidebar');
            localStorage.setItem('sidebar', this.open);
        }
    }
}
</script>

<style scoped>

</style>
