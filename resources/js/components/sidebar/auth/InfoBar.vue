<template>
    <div class="text-Dark-m">
        <div v-if="user" class="flex items-center space-x-2">
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
                <div class="w-10 h-10 rounded-md bg-Dark-m/20 border-2 border-Dark-m">
                    <img v-if="user.profile" class="w-full h-full rounded-md" :src="user.profile.img_url" :alt="user.name"/>
                </div>
            </router-link>
        </div>
        <div v-else></div>
    </div>
</template>

<script>
import Link from '../../../UI/Link';
import {Mail, Book, Coins} from 'lucide-vue';
import {mapGetters} from 'vuex';

export default {
    name: "InfoBar",

    components: {
        Link,
        Mail,
        Book,
        Coins,
    },

    computed: {
        ...mapGetters({
            user: 'GET_USER'
        })
    },
}
</script>

<style scoped>

</style>
