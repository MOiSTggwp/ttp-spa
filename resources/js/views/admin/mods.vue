<template>
    <div>
        <U-Title>
            Режимы игры
        </U-Title>
        <div class="flex justify-center gap-4 mt-10">
            <U-Select :data="mainMods" text="Основной режим" @res="resMainMods"></U-Select>
            <U-Select :data="secondMods" text="Доп. режим" @res="resSecondMods"></U-Select>
        </div>
        <div class="flex justify-center mt-6">
            <U-Select :data="mods" text="Основной режим" @res="resMods"></U-Select>
        </div>
    </div>
</template>

<script>
export default {
    name: "mods",
    data() {
        return {
            mainMods: [],
            secondMods: [],
            mods: [],
            mainModsSelect: [],
            secondModsSelect: [],
            modsSelect: []
        }
    },
    mounted () {
        this.getMainMods();
    },
    methods: {
        getMainMods() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('/api/main_mods').then(res => {
                    this.mainMods = res.data.data.filter(i => i.type === 1);
                    this.secondMods = res.data.data.filter(i => i.type === 2);
                });
            });
        },
        getMods() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`/api/mods?main=[${this.mainModsSelect.map(i => i.id)}]&second=[${this.secondModsSelect.map(i => i.id)}]`)
                    .then(res => {
                        this.mods = res.data.data;
                    });
            });
        },
        resMainMods(r) {
            this.mainModsSelect = r;
        },
        resSecondMods(r) {
            this.secondModsSelect = r;
        },
        resMods(r) {
            this.modsSelect = r;
        }
    },
    watch: {
        mainModsSelect() {
            this.getMods();
        },
        secondModsSelect() {
            this.getMods();
        }
    }
}
</script>

<style scoped>

</style>
