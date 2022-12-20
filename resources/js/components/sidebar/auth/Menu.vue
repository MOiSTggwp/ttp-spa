<template>
    <div>
        <div class="grid grid-cols-3 gap-3 px-3">
            <U-Button
                class="col-span-3"
                color="Dark-m"
                type="router"
                text="Главная"
                link="home"
                position="top"
                :tip="false"
            >
                <Home></Home>
            </U-Button>
            <U-Button
                class="col-span-2"
                color="Dark-m"
                type="router"
                text="Мои объявления"
                link="test"
                position="top"
                :tip="false"
            >
                <Archive></Archive>
            </U-Button>
            <U-Button
                class="col-span-1"
                color="Dark-m"
                type="router"
                text="Поиск"
                link="users.show"
                position="top"
                :tip="false"
            >
                <Search></Search>
            </U-Button>
            <U-Button
                class="col-span-1"
                color="Dark-m"
                type="router"
                text="Группы"
                link="home"
                position="top"
                :tip="false"
            >
                <LayoutDashboard></LayoutDashboard>
            </U-Button>
            <U-Button
                class="col-span-2"
                color="Dark-m"
                type="router"
                text="Поиск по игре"
                link="home"
                position="top"
                :tip="false"
            >
                <Gamepad2></Gamepad2>
            </U-Button>
            <div class="border-b col-span-3 border-Dark-m border-opacity-25"></div>
            <U-Button
                class="col-span-1"
                color="Dark-m"
                type="router"
                text="Новости"
                link="home"
                position="top"
                :tip="false"
            >
                <Info></Info>
            </U-Button>
            <U-Button
                class="col-span-1"
                color="Dark-m"
                type="router"
                text="Разное"
                link="home"
                position="top"
                :tip="false"
            >
                <FolderOpen></FolderOpen>
            </U-Button>
            <U-Button
                class="col-span-1"
                color="Dark-m"
                type="router"
                text="Контакты"
                link="admin.mods"
                position="top"
                :tip="false"
            >
                <Globe2></Globe2>
            </U-Button>
            <U-Button
                class="col-span-3"
                color="Dark-m"
                type="router"
                text="Тех. Поддержка"
                link="admin.games"
                position="top"
                :tip="false"
            >
                <HelpCircle></HelpCircle>
            </U-Button>
        </div>
    </div>
</template>

<script>
import MenuButton from '../../../UI/menu/Button';

import {Home, Archive, Search, LayoutDashboard, Gamepad2, Info, Globe2, FolderOpen, HelpCircle} from 'lucide-vue';

export default {
    name: "Menu",

    components: {
        MenuButton,
        Home,
        Archive,
        Search,
        LayoutDashboard,
        Gamepad2,
        Info,
        Globe2,
        FolderOpen,
        HelpCircle
    },

    props: {
        auth: '',
    },

}
</script>

<style scoped>

</style>
