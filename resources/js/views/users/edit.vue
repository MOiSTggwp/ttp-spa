<template>
    <div>
        <Alert @close="alertClose" :arr="{ type: this.type , errors: this.errors}"></Alert>

        <div v-if="profile !== null" class="space-y-6">


            <div class="w-full grid grid-cols-1 sm:grid-cols-11 md:grid-cols-5 lg:grid-cols-10 xl:grid-cols-9 2xl:grid-cols-5 gap-6 items-center">

                <input id="file" hidden ref="file" type="file" @change="setFile">

                <div class="shadow-sm w-full col-span-1 sm:col-span-5 md:col-span-2 lg:col-span-3 xl:col-span-2 2xl:col-span-1 flex justify-center">
                    <label class="w-[280px] sm:w-full h-[240px] border-2 border-Dark-m rounded-md relative cursor-pointer group" for="file">
                        <Camera class="group-hover:w-12 group-hover:h-12 group-hover:opacity-60 transition-all w-10 h-10 text-Dark-l absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></Camera>
                        <img v-if="show_img" class="w-full h-full object-cover" :src="show_img" alt="">
                        <span v-else class="block w-full h-full bg-Dark-m/30 flex justify-center items-center">
                            <Camera class="group-hover:w-12 group-hover:h-12 w-10 h-10 text-Dark-l"></Camera>
                        </span>
                        <span class="text-Dark-l/80 select-none flex flex-col justify-end items-center bg-Dark/60 p-1 w-full h-full text-lg font-bold mt-7 absolute bottom-0 left-0">
                            <span>280 x 240</span>
                            <span>Макс. размер (10МБ)</span>
                        </span>
                    </label>
                </div>

                <div class="shadow-sm w-full col-span-1 sm:col-span-6 md:col-span-3 lg:col-span-7 xl:col-span-7 2xl:col-span-4 flex justify-center">
                    <div class="w-full h-[240px] border-2 border-Dark-m rounded-md flex flex-col items-center lg:items-start py-6 lg:px-4 sm:px-2 space-y-8">
                        <Input class="w-[280px]" @res="resName" :arr="{ value: user.name, type: 'text', id: 'name', text: 'Имя', error: null}">
                            <User></User>
                        </Input>

                        <Input class="w-[280px]" @res="resDate" :arr="{ value: profile.date, type: 'date', id: 'date', text: 'Дата Рождения', error: null}">
                            <Calendar></Calendar>
                        </Input>

                        <SelectNew
                            class="w-[280px]"
                            @res="resFloor"
                            :arr="{
                                value: profile.floor,
                                array: array,
                                radio: true,
                                btn: false,
                                max: null,
                                id: 'floor',
                                text: 'Пол',
                                error: null
                            }">
                            <CircleSlashed></CircleSlashed>
                        </SelectNew>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-11 md:grid-cols-5 lg:grid-cols-10 xl:grid-cols-9 2xl:grid-cols-5 gap-6">
                <div class="shadow-sm col-span-1 sm:col-span-5 md:col-span-2 lg:col-span-3 xl:col-span-2 2xl:col-span-1 flex flex-col items-start w-full border-2 border-Dark-m rounded-md py-4 px-2">
                    <Label>Подключить</Label>

                    <div class="grid grid-cols-2 mx-auto mt-4 gap-3">
                        <MenuButton :arr="{link: '', text: 'Вконтакте'}">
                            <div></div>
                        </MenuButton>

                        <MenuButton :arr="{link: '', text: 'Telegram'}">

                        </MenuButton>

                        <MenuButton :arr="{link: '', text: 'Discord'}">

                        </MenuButton>

                        <MenuButton :arr="{link: '', text: 'Steam'}">

                        </MenuButton>
                    </div>
                </div>

                <div class="shadow-sm col-span-1 row-start-1 sm:col-span-6 md:col-span-3 lg:col-span-7 xl:col-span-7 2xl:col-span-4 flex flex-col items-start w-full border-2 border-Dark-m rounded-md py-4 px-2">
                    <SelectNew
                        class="w-[280px]"
                        @res="resGames"
                        :arr="{
                                value: profile.games,
                                array: allGames,
                                radio: false,
                                btn: true,
                                max: 4,
                                id: 'games',
                                text: 'Любимые игры',
                                error: null
                            }">
                        <Gamepad2></Gamepad2>
                    </SelectNew>
                </div>
            </div>



            <button @click.prevent="edit" type="submit">test</button>

        </div>
    </div>
</template>

<script>
import Input from '../../elements/Input';
import SelectNew from '../../elements/SelectNew';
import Range from '../../elements/Range';
import Alert from '../../elements/Alert';
import Label from '../../elements/Label';
import MenuButton from '../../elements/menu/Button';
import {Camera, User, Calendar, CircleSlashed, Gamepad2 } from 'lucide-vue';

export default {
    name: "edit",

    components: {
        Camera,
        User,
        Calendar,
        CircleSlashed,
        Input,
        SelectNew,
        Range,
        Label,
        Alert,
        Gamepad2,
        MenuButton,
    },

    data() {
        return {
            user: [],
            profile: null,
            img: null,
            p_img: null,
            show_img: null,
            array: [
                {id: 0, name: 'Женский',},
                {id: 1, name: 'Мужской',},
            ],
            allGames: [],

            type: '',
            errors: '',

            name: '',
            date: null,
            floor: null,
            games: [],
        }
    },

    mounted() {
        this.auth();
    },

    updated() {
        if(this.type !== '') {
            this.alertClose();
        }
    },

    methods: {
        auth() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`/api/main/resource`).then(res => {
                    this.user = res.data.data.auth;
                    this.profile = res.data.data.auth.profile;
                    this.p_img = res.data.data.auth.profile.img_url;
                    this.allGames = res.data.data.games;
                    this.showFile();
                });
            });
        },

        editAccess() {
            if (this.user.id != this.$route.params.id) {
                this.$router.push({name: 'users.edit', params: {id: this.user.id}});
            }
        },

        edit() {
            const data = new FormData();
            const img = this.$refs.file.files[0];

            data.append('_method', 'PATCH');

            if(img != undefined)
            data.append('img', img);

            data.append('name', this.name);

            if(this.date != null)
            data.append('date', this.date);

            data.append('floor', this.floor);

            this.games.forEach(i => {
                data.append('games[]', i);
            });


            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post(`/api/users/${this.user.id}/edit`, data)
                    .then(res => {
                        this.errors = res.data.done;
                        this.type = 'done';
                        this.profile = null;
                        this.auth();
                    }).catch(err => {
                        this.errors = err.response.data.errors;
                        this.type = 'error';
                });
            });
        },

        setFile() {
            if(this.$refs.file)
            this.img = this.$refs.file.files[0];
        },

        showFile() {
            if(this.$refs.file) {
                let reader  = new FileReader();

                reader.addEventListener("load", function () {
                    this.show_img = reader.result;
                }.bind(this), false);

                if( this.img ){
                    if ( /\.(jpe?g|png|gif)$/i.test( this.img.name ) ) {
                        reader.readAsDataURL( this.img );
                    }
                }
            } else if (this.profile.img_url) {
                this.show_img = this.p_img;
            } else {
                this.show_img = null;
            }
        },

        resName(r) {
            this.name = r[0];
        },

        resDate(r) {
            this.date = r[0];
        },

        resFloor(r) {
            this.floor = r[0];
        },

        resGames(r) {
            this.games = r[0];
        },

        alertClose() {
            this.type = '';
            this.errors = [];
        },
    },

    watch: {
        user() {
            this.editAccess();
        },

        img() {
            this.showFile();
        },

        p_img() {
            this.showFile();
        }
    }
}
</script>

<style scoped>

</style>
