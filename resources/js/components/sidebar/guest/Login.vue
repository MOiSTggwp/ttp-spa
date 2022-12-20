<template>
    <div class="px-3 pt-3">
        <U-Title h="7">Авторизация</U-Title>
        <div class="grid grid-cols-1 gap-4 mt-6">
            <U-Input @res="resEmail" type="email" id="email" text="Введите Email" :error="this.errors.map(i => i.name === 'email')[0]">
                <AtSign></AtSign>
            </U-Input>
            <U-Input @res="resPassword" type="password" id="password" text="Введите Пароль" :error="this.errors.map(i => i.name === 'password')[0]">
                <Lock></Lock>
            </U-Input>
            <U-Checkbox @res="resRemember" :data="[{id: 1, name: 'Запомнить?'}]" type="checkbox"></U-Checkbox>
            <U-Button @click="login" text="Войти" :tip="false">
                <LogIn></LogIn>
            </U-Button>
        </div>
    </div>
</template>

<script>
import {AtSign, Lock, LogIn} from 'lucide-vue';
import {mapActions, mapGetters} from 'vuex';

export default {
    name: "Login",
    components: {
        AtSign,
        Lock,
        LogIn,
    },
    data() {
        return {
            ...mapGetters(['GET_ALERTS']),
            email: '',
            password: '',
            remember: false,
            type: '',
            errors: [],
            msg: '',
        }
    },
    methods: {
        ...mapActions(['SET_ALERT']),
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
        resEmail(r) {
            this.email = r;
        },
        resPassword(r) {
            this.password = r;
        },
        resRemember(r) {
            this.remember = r;
        },
        alertClose() {
            this.type = '';
            this.errors = [];
        },
        token() {
            this.$emit('token');
        }
    },
}
</script>

<style scoped>

</style>
