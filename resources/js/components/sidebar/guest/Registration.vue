<template>
    <div class="px-3 pt-3">
        <Alert @close="alertClose" :arr="{ type: this.type , errors: this.errors}"></Alert>

        <Label class="mb-6">Регистрация</Label>

        <div class="grid grid-cols-1 gap-4">
            <Input @res="resName" :arr="{ type: 'text', id: 'name', text: 'Введите Логин', error: this.errors.name}">
                <User></User>
            </Input>

            <Input @res="resEmail"
                   :arr="{ type: 'email', id: 'email', text: 'Введите Email', error: this.errors.email}">
                <AtSign></AtSign>
            </Input>

            <Input @res="resPassword"
                   :arr="{ type: 'password', id: 'password', text: 'Введите Пароль', error: this.errors.password}">
                <Lock></Lock>
            </Input>

            <Input @res="resPasswordConfirmation"
                   :arr="{ type: 'password', id: 'password_confirmation', text: 'Введите Пароль ещё раз', error: this.errors.password}">
                <Lock></Lock>
            </Input>

            <Button @click="registration" type="button" value="register" :arr="{ text:'Зарегистрироваться' }">
                <UserCheck></UserCheck>
            </Button>
        </div>
    </div>
</template>

<script>
import Input from '../../../elements/Input';
import Label from '../../../elements/Label';
import Button from '../../../elements/Button';
import Alert from '../../../elements/Alert';
import {AtSign, Lock, UserCheck, User} from 'lucide-vue';

export default {
    name: "Registration",

    components: {
        Input,
        Label,
        Button,
        Alert,
        AtSign,
        Lock,
        UserCheck,
        User,
    },

    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: [],
            type: '',
        }
    },

    methods: {
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
                    this.errors = err.response.data.errors;
                    this.type = 'error';
                    this.msg = 'Регистрация не выполнен, проверьте введенные данные.';
                });
            });
        },

        resName(r) {
            this.name = r[0];
        },

        resEmail(r) {
            this.email = r[0];
        },

        resPassword(r) {
            this.password = r[0];
        },

        resPasswordConfirmation(r) {
            this.password_confirmation = r[0];
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
