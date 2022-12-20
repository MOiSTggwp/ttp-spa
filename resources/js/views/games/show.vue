<template>
    <div v-if="game">

    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "show",
    data() {
        return {
            game: null
        }
    },
    mounted() {
        this.getGame();
    },
    methods: {
        ...mapActions(["GET_GAME"]),
        getGame() {
            this.GET_GAME(this.$route.params.id).then(res => {
                this.game = res;
            })
        }
    }
}
</script>

<style scoped>

</style>
