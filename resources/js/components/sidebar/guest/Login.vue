<template>
    <div class="px-3 pt-3">
        <Alert @close="alertClose" :arr="{ type: this.type , errors: this.errors}"></Alert>

        <Label class="mb-6">Авторизация</Label>

        <div class="grid grid-cols-1 gap-4">
            <Input @res="resEmail" :arr="{ type: 'email', id: 'email', text: 'Введите Email', error: this.errors.email}">
                <AtSign></AtSign>
            </Input>

            <Input @res="resPassword" :arr="{ type: 'password', id: 'password', text: 'Введите Пароль', error: this.errors.password}">
                <Lock></Lock>
            </Input>

            <Checkbox @res="resRemember" :arr="{ name: 'remember', id: 'remember', title: 'Запомнить?', y: 'да', n: 'нет' }"></Checkbox>

            <Button @click="login" type="button" value="login" :arr="{ text:'Войти' }">
                <LogIn></LogIn>
            </Button>
        </div>
    </div>
</template>

<script>
import Input from '../../../elements/Input';
import Label from '../../../elements/Label';
import Button from '../../../elements/Button';
import Alert from '../../../elements/Alert';
import Checkbox from '../../../elements/Checkbox';
import {AtSign, Lock, LogIn} from 'lucide-vue';

export default {
    name: "Login",

    components: {
        Input,
        Label,
        Button,
        Alert,
        AtSign,
        Lock,
        LogIn,
        Checkbox,
    },

    data() {
        return {
            email: '',
            password: '',
            remember: false,
            type: '',
            errors: [],
            msg: '',
        }
    },

    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', {
                    email: this.email,
                    password: this.password,
                    remember: this.remember
                }).then(res => {
                    localStorage.setItem('token', res.config.headers['X-XSRF-TOKEN']);
                    this.token();
                }).catch(err => {
                    this.errors = err.response.data.errors;
                    this.type = 'error';
                    this.msg = 'Вход не выполнен, проверьте введенные данные.';
                });
            });
        },

        resEmail(r) {
            this.email = r[0];
        },

        resPassword(r) {
            this.password = r[0];
        },

        resRemember(r) {
            this.remember = r[0];
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
