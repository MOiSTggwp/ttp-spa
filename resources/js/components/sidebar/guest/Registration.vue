<template>
    <div class="px-3 pt-3">
        <U-Title h="7">Регистрация</U-Title>
        <div class="grid grid-cols-1 gap-4 mt-6">
            <U-Input @res="resName" type="text" id="name" text="Введите Логин" :error="this.errors.map(i => i.name === 'name')[0]">
                <User></User>
            </U-Input>
            <U-Input @res="resEmail" type="email" id="email" text="Введите Email" :error="this.errors.map(i => i.name === 'email')[0]">
                <AtSign></AtSign>
            </U-Input>
            <U-Input @res="resPassword" type="password" id="password" text="Введите Пароль" :error="this.errors.map(i => i.name === 'password')[0]">
                <Lock></Lock>
            </U-Input>
            <U-Input @res="resPasswordConfirmation" type="password" id="password_confirmation" text="Введите Пароль ещё раз" :error="this.errors.map(i => i.name === 'password')[0]">
                <Lock></Lock>
            </U-Input>
            <U-Button @click="registration" text="Зарегистрироваться" :tip="false">
                <UserCheck></UserCheck>
            </U-Button>
<!--            <Input @res="resName" :arr="{ type: 'text', id: 'name', text: 'Введите Логин', error: this.errors.name}">-->
<!--                <User></User>-->
<!--            </Input>-->
<!--            <Input @res="resEmail"-->
<!--                   :arr="{ type: 'email', id: 'email', text: 'Введите Email', error: this.errors.email}">-->
<!--                <AtSign></AtSign>-->
<!--            </Input>-->
<!--            <Input @res="resPassword"-->
<!--                   :arr="{ type: 'password', id: 'password', text: 'Введите Пароль', error: this.errors.password}">-->
<!--                <Lock></Lock>-->
<!--            </Input>-->
<!--            <Input @res="resPasswordConfirmation"-->
<!--                   :arr="{ type: 'password', id: 'password_confirmation', text: 'Введите Пароль ещё раз', error: this.errors.password}">-->
<!--                <Lock></Lock>-->
<!--            </Input>-->
<!--            <Button @click="registration" type="button" value="register" :arr="{ text:'Зарегистрироваться' }">-->
<!--                <UserCheck></UserCheck>-->
<!--            </Button>-->
        </div>
    </div>
</template>

<script>
import {AtSign, Lock, UserCheck, User} from 'lucide-vue';
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Registration",
    components: {
        AtSign,
        Lock,
        UserCheck,
        User,
    },
    data() {
        return {
            ...mapGetters(['GET_ALERTS']),
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: [],
            type: '',
        }
    },
    methods: {
        ...mapActions(['SET_ALERT']),
        registration() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                }).then(res => {
                    localStorage.setItem('token', res.config.headers['X-XSRF-TOKEN']);
                    this.token();
                }).catch(err => {
                    for(let item in err.response.data.errors) {
                        this.SET_ALERT({
                            name: item,
                            type: 'error',
                            massage: err.response.data.errors[item][0],
                            show: true,
                            button: true
                        });
                        this.errors = this.GET_ALERTS();
                    }
                });
            });
        },
        resName(r) {
            this.name = r;
        },
        resEmail(r) {
            this.email = r;
        },
        resPassword(r) {
            this.password = r;
        },
        resPasswordConfirmation(r) {
            this.password_confirmation = r;
        },
        alertClose() {
            this.type = '';
            this.errors = [];
        },
        token() {
            this.$emit('token');
        }
    }
}
</script>

<style scoped>

</style>
