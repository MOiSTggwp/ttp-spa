<template>
    <div>
        <div v-if="user" class="space-y-6">
            <div class="w-full flex flex-column md:!flex-row gap-6 items-center">
                <U-Avatar :edit="true" @res="resImg"></U-Avatar>

                <div class="shadow-md shadow-Dark/[98%] bg-Dark rounded-md w-full flex justify-center">
                    <div class="w-full rounded-md flex flex-col items-center lg:items-start py-6 lg:px-4 sm:px-2 gap-8">
                        <U-Input
                            :val="user.name"
                            text="Имя"
                            :error="errors.map(i => i.name === 'name')[0]"
                            width="280"
                            @res="resName">
                            <User></User>
                        </U-Input>

                        <U-Input
                            :val="user.profile.date"
                            type="date"
                            text="Дата Рождения"
                            :error="errors.map(i => i.name === 'date')[0]"
                            width="280"
                            @res="resDate">
                            <Calendar></Calendar>
                        </U-Input>

                        <U-Select
                            class="w-[280px]"
                            :data="array"
                            :value="array.filter(i => i.id === user.profile.floor)"
                            text="Пол"
                            :multi="false"
                            @res="resFloor"
                        >
                            <CircleSlashed></CircleSlashed>
                        </U-Select>

                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-11 md:grid-cols-10 xl:grid-cols-11 gap-6">
                <div class="shadow-md shadow-Dark/[98%] bg-Dark rounded-md
                 col-span-1 sm:col-span-6 md:col-span-5 xl:col-span-3
                 w-full flex justify-center rounded-md py-7 px-2">
                    <U-Select
                        class="w-[280px]"
                        :data="allGames"
                        :value="user.profile.games"
                        text="Любимые игры"
                        :multi="true"
                        :max="4"
                        @res="resGames"
                    >
                        <Gamepad2></Gamepad2>
                    </U-Select>
                </div>

                <div class="shadow-md shadow-Dark/[98%] bg-Dark rounded-md
                col-span-1 row-start-1 sm:col-span-full xl:col-span-5 xl:col-start-4
                w-full rounded-md py-7 px-2">
                    <U-Textarea
                        :value="user.profile.description"
                        text="Дополнительно"
                        :padding="true"
                        :max="250"
                        :error="errors.description"
                    >
                        <Gamepad2></Gamepad2>
                    </U-Textarea>
                </div>

                <div class="shadow-md shadow-Dark/[98%] bg-Dark rounded-md
                col-span-1 row-start-2 sm:col-span-5 xl:col-span-3 xl:row-start-1
                flex flex-col items-start w-full rounded-md py-4 px-2">
                    <U-Spacer
                        position="center"
                        h="3"
                    >Подключить</U-Spacer>

                    <div class="grid grid-cols-2 mx-auto mt-4 gap-3">
                        <ContactBtn :arr="{value: hasContact('vk'), has: true, link: '/auth/discord', name: 'VK'}">
                            <Gamepad2></Gamepad2>
                        </ContactBtn>

                        <ContactBtn :arr="{value: hasContact('telegram'), has: true, link: '/auth/discord', name: 'Telegram'}">
                            <Gamepad2></Gamepad2>
                        </ContactBtn>

                        <ContactBtn :arr="{value: hasContact('discord'), has: true, link: '/auth/discord', name: 'Discord'}">
                            <Gamepad2></Gamepad2>
                        </ContactBtn>

                        <ContactBtn :arr="{value: hasContact('steam'), has: true, link: '/auth/discord', name: 'Steam'}">
                            <Gamepad2></Gamepad2>
                        </ContactBtn>
                    </div>
                </div>
            </div>

            <button @click.prevent="edit" type="submit">test</button>

        </div>
    </div>
</template>

<script>
import Input from '../../UI/Input';
import Select from '../../UI/Select';
import Range from '../../UI/Range';
import Alert from '../../UI/Alert';
import Label from '../../UI/Label';
import ContactBtn from '../../UI/ContactButton';
import TextareaE from '../../UI/Textarea';
import MenuButton from '../../UI/menu/Button';
import {Camera, User, Calendar, CircleSlashed, Gamepad2 } from 'lucide-vue';
import {mapActions, mapGetters} from 'vuex';

export default {
    name: "edit",

    components: {
        Camera,
        User,
        Calendar,
        CircleSlashed,
        Input,
        Select,
        Range,
        Label,
        Alert,
        Gamepad2,
        MenuButton,
        TextareaE,
        ContactBtn
    },

    data() {
        return {
            array: [
                {id: 0, name: 'Женский',},
                {id: 1, name: 'Мужской',},
            ],

            allGames: {},

            name: '',
            date: null,
            floor: null,
            games: [],
            description: '',
        }
    },

    computed: {
        ...mapGetters({
            user: 'GET_USER',
            errors: 'GET_ALERTS'
        }),
    },

    created() {

    },

    mounted() {
        this.GET_GAMES().then(res => {
            this.allGames =res;
        });
    },

    methods: {
        ...mapActions(['SET_DATA', 'GET_GAMES', 'EDIT_PROFILE', 'SET_ALERT']),

        editAccess() {
            if (this.user.id !== this.$route.params.id) {
                this.$router.push({name: 'users.edit', params: {id: this.user.id}}).catch(()=>{});
            }
        },

        edit() {
            const data = new FormData();
            data.append('_method', 'PATCH');
            data.append('img', this.img.img);
            data.append('img_edit', JSON.stringify(this.img.img_edit));
            if(this.name !== '') data.append('name', this.name);
            if(this.date !== null) data.append('date', this.date);
            data.append('floor', this.floor);
            this.games.forEach(i => {
                data.append('games[]', i);
            });
            data.append('description', this.description);

            this.EDIT_PROFILE(data).then(r => {
                this.setAlert(r);
                this.SET_DATA();
                this.$router.push({name: 'users.show', params: {id: this.user.id}});
            }).catch(err => {
                this.setAlert(err);
            });
        },

        setAlert(alert) {
            console.log(alert)
            for(let item in alert.errors) {
                this.SET_ALERT({
                    name: item,
                    type: alert.type,
                    massage: alert.errors[item][0],
                    show: true,
                    button: true
                });
            }
        },

        resImg(r) {
            this.img = r;
        },

        resName(r) {
            this.name = r;
        },

        resDate(r) {
            this.date = r;
        },

        resFloor(r) {
            this.floor = r[0].id;
        },

        resGames(r) {
            this.games = r.map(i => {return i.id});
        },

        resDesc(r) {
            this.description = r[0];
        },

        hasContact(contact) {
            if(this.user.profile.contacts.length > 0) {
                return this.user.profile.contacts.filter((r) => {
                    return r.name === contact;
                }).length > 0;
            } else {
                return false;
            }
        },
    },

    watch: {
        user() {
            this.editAccess();
        }
    }
}
</script>

<style scoped>

</style>
