<template>
    <div v-if="profile.id" class="flex flex-col items-center">
        <div>
            <router-link v-if="profile.id === user.id" :to="{ name: 'users.edit', params: { id: user.id } }">редактировать</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "show",

    computed: {},

    data(){
        return {
            user: [],
            profile: [],
        }
    },

    mounted() {
        console.log('111')
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
                    console.log(res.data.data)
                    if(res.data.data) {
                        this.profile = res.data.data;
                    } else {
                        this.$router.push({ name: 'home'});
                    }
                });
            });
        }
    }
}
</script>

<style scoped>

</style>
