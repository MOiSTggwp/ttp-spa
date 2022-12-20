<template>
    <div class="w-full h-full">
        <U-Paginate :links="games.links" :pagination="games.meta" web-path="/games" @change="getGames"></U-Paginate>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "index",
    components: {},

    data() {
      return {
          games: {},
          countGames: 24,
          pathName: '/api/games',
      }
    },
    mounted() {
        this.getGames();
    },
    methods: {
        ...mapActions(["GET_GAMES"]),
        getGames() {
            this.GET_GAMES(`${this.pathName}/${this.countGames}?${window.location.search.replace('?', '')}`)
                .then(res => {
                    this.games = res;
                });
        }
    }
}
</script>

<style scoped>

</style>
