<template>
    <div>
        <div class="grid grid-cols-3 gap-3 px-3">
            <MenuButton class="col-span-3" :arr="{ text: 'Главная', link: 'home' }">
                <Home></Home>
            </MenuButton>

            <MenuButton class="col-span-2" :arr="{ text: 'Мои объявления', link: 'test' }">
                <Archive></Archive>
            </MenuButton>
            <MenuButton :arr="{ text: 'Поиск', link: 'users.show'}">
                <Search></Search>
            </MenuButton>

            <MenuButton :arr="{ text: 'Группы', link: 'home' }">
                <LayoutDashboard></LayoutDashboard>
            </MenuButton>
            <MenuButton class="col-span-2" :arr="{ text: 'Поиск по игре', link: 'home' }">
                <Gamepad2></Gamepad2>
            </MenuButton>

            <div class="border-b col-span-3 border-Dark-m border-opacity-25"></div>

            <MenuButton :arr="{ text: 'Новости', link: 'home' }">
                <Info></Info>
            </MenuButton>
            <MenuButton :arr="{ text: 'Разное', link: 'home' }">
                <FolderOpen></FolderOpen>
            </MenuButton>
            <MenuButton :arr="{ text: 'Контакты', link: 'home' }">
                <Globe2></Globe2>
            </MenuButton>

            <MenuButton class="col-span-3" :arr="{ text: 'Тех. Поддержка', link: 'home' }">
                <HelpCircle></HelpCircle>
            </MenuButton>
        </div>
    </div>
</template>

<script>
import MenuButton from '../../../elements/menu/Button';

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
