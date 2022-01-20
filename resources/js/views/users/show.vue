<template>
    <div class="flex flex-col">
        <div v-if="profile !== null" class=" space-y-6">
            <div class="w-full flex justify-end">
                    <router-link v-if="profile.id === user.id" :to="{ name: 'users.edit', params: { id: user.id } }">
                        <div class="w-[200px] h-10 bg-Info flex space-x-2 justify-center items-center
                                hover:bg-Info-l hover:bg-opacity-80 hover:text-Light transition-all duration-300
                                rounded-md">
                            <div class="flex justify-center items-center space-x-2">
                                <Edit></Edit>
                                <div>
                                    Редактировать
                                </div>
                            </div>
                        </div>
                    </router-link>
            </div>

            <div class="w-full grid grid-cols-1 sm:grid-cols-11 md:grid-cols-5 lg:grid-cols-10 xl:grid-cols-9 2xl:grid-cols-5 gap-6 justify-center items-center">

                <div class="w-full col-span-1 sm:col-span-5 md:col-span-2 lg:col-span-3 xl:col-span-2 2xl:col-span-1 flex justify-center">
                    <label class="w-[280px] sm:w-full h-[240px] shadow-md shadow-Dark/[98%] rounded-md bg-Dark cursor-pointer group">
                        <img v-if="show_img" class="w-full h-full rounded-md object-cover" :src="show_img" alt="">
                    </label>
                </div>

                <div class="shadow-md shadow-Dark/[98%] rounded-md bg-Dark w-full col-span-1 sm:col-span-6 md:col-span-3 lg:col-span-7 xl:col-span-7 2xl:col-span-4 flex justify-center">

                    <div class="w-full h-[240px] flex rounded-md items-center lg:justify-center lg:items-start py-6 px-1 lg:!px-4 sm:!px-2">

                        <div class="lg:w-full flex justify-center mx-auto lg:mx-0 lg:my-auto lg:justify-start">
                            <div class="max-w-min h-full text-Dark-m text-base font-bold flex flex-col justify-around items-start mr-3 space-y-6">
                                <div>
                                    Имя:
                                </div>

                                <div>
                                    Возраст:
                                </div>

                                <div>
                                    Пол:
                                </div>
                            </div>

                            <div class="w-full h-full text-base font-bold flex flex-col justify-around items-start space-y-6">
                                <div>
                                    {{ profile.name }}
                                </div>

                                <div v-if="profile.profile.age">
                                    {{ profile.profile.age }}
                                </div>
                                <div v-else class="text-base text-Dark-m">
                                    не указан
                                </div>

                                <div v-if="profile.profile.floor">
                                    {{ profile.profile.floor_text }}
                                </div>
                                <div v-else class="text-base text-Dark-m">
                                    не указан
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="w-full h-full min-h-[190px] flex flex-col justify-center items-center bg-Dark shadow-Dark/[98%] shadow-md rounded-md py-7 px-4">
                    <Label class="mb-3 h-1/3">Дополнительно</Label>

                    <div v-if="profile.profile.description" class="flex justify-center items-center text-base h-2/3">
                        {{ profile.profile.description }}
                    </div>
                    <div v-else class="flex justify-center items-center text-Dark-m text-base font-bold h-2/3">
                        не указано
                    </div>
                </div>

                <div class="w-full h-full min-h-[190px] flex flex-col justify-center items-center shadow-Dark/[98%] shadow-md rounded-md bg-Dark py-7 px-4">
                    <Label class="mb-3 h-1/3">Контакты</Label>

                    <div v-if="profile.profile.description" class="flex justify-center items-center text-base h-2/3">
                        {{ profile.profile.description }}
                    </div>
                    <div v-else class="flex justify-center items-center text-Dark-m text-base font-bold h-2/3">
                        не указано
                    </div>
                </div>
            </div>

            <Label class="mb-3">Любимые игры</Label>
            <div class="grid gap-6 place-items-center grid-cols-1 sm:grid-cols-2"
            :class="{
                'lg:grid-cols-1': profile.profile.games.length === 1,
                'lg:grid-cols-2': profile.profile.games.length === 2,
                'lg:grid-cols-3': profile.profile.games.length === 3,
                'lg:grid-cols-4': profile.profile.games.length === 4,
                }" v-if="profile.profile.games.length > 0">
                    <CardProfileGame
                        class="col-span-1 max-w-[240px]"
                        v-for="game in profile.profile.games"
                        :key="game.id"
                        :arr="game"
                    ></CardProfileGame>
            </div>
            <div v-else class="flex justify-center items-center text-Dark-m text-base font-bold bg-Dark w-full py-7 px-4 rounded-md shadow-md shadow-Dark/[98%]">
                не выбраны
            </div>
        </div>

    </div>
</template>

<script>
import MenuButton from '../../elements/menu/Button';
import Label from '../../elements/Label';
import CardProfileGame from '../../components/card/profile/Game';
import {Edit} from 'lucide-vue';

export default {
    name: "show",

    components: {
        MenuButton,
        Edit,
        Label,
        CardProfileGame,
    },

    data(){
        return {
            user: [],
            profile: null,
            show_img: null,
        }
    },

    mounted() {
        this.auth();
        this.getProfile();
    },

    methods: {
        auth() {
            console.log('auth')
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`/api/user`).then(res => {
                    this.user = res.data;
                });
            });
        },

        getProfile() {
            console.log('getProfile')
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`/api/users/${this.$route.params.id}`).then(res => {
                    if(res.data.data) {
                        this.profile = res.data.data;
                        this.showFile(res.data.data);
                    } else {
                        this.$router.push({ name: 'home'});
                    }
                });
            });
        },

        showFile(data) {
            if (data.profile && data.profile.img_url) {
                this.show_img = data.profile.img_url;
            } else {
                this.show_img = null;
            }
        },
    },

    watch: {
        $route() {
            this.getProfile();
        }
    }
}
</script>

<style scoped>

</style>
