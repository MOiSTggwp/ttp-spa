<template>
    <div class="text-Dark-m">
        <div class="flex items-center space-x-2">
            <div class="flex text-Warn-m text-sm items-center space-x-1">
                <Coins class="w-[20px] h-[20px]"></Coins>
                <div>
                    9999999
                </div>
            </div>

            <Link class="hover:bg-Dark-m hover:bg-opacity-90 rounded-md p-1.5" :arr="{ text: '' }">
                <Mail class="w-[24px] h-[24px]"></Mail>
            </Link>
            <Link class="hover:bg-Dark-m hover:bg-opacity-90 rounded-md p-1.5" :arr="{ text: '' }">
                <Book class="w-[24px] h-[24px]"></Book>
            </Link>

            <router-link :to="{ name: 'users.show', params: { id: user.id }}">
                <div class="w-10 h-10 rounded-md bg-gray-100 border-2 border-Dark-m">

                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
import Link from '../../../elements/Link';
import {Mail, Book, Coins} from 'lucide-vue';

export default {
    name: "InfoBar",

    components: {
        Link,
        Mail,
        Book,
        Coins,
    },

    data() {
        return {
            user: [],
        }
    },

    mounted() {
        this.auth();
    },

    methods: {
        auth() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('/api/user').then(res => {
                    this.user = res.data;
                });
            });
        }
    },
}
</script>

<style scoped>

</style>
