<!--передается [] в SET_ALERT()-->
<!--
type - Тип сообщения (error, warn, info, done)
massage - Текст сообщения
show - Флаг отображения алерта (true, false)

button - пока что не используется
-->
<!--///////-->
<template>
    <div class="fixed z-[101] flex justify-end z-10 top-0 right-0 w-screen pointer-events-none h-screen" v-if="data">
        <transition-group class="relative w-screen z-20 whitespace-bold flex flex-column justify-start items-end pt-2 pr-2 sm:pr-10" name="action">
            <div
                v-for="alert in data"
                :key="alert.id"
                class="transition-translate duration-500 transform-gpu mt-3 max-w-max w-[300px] sm:w-full bg-Dark bg-opacity-[94%]
                border-2 border-Dark-m border-opacity-[47%] shadow-md py-1 px-2 sm:!py-3 sm:!px-4 flex justify-between items-center rounded-md text-base"
            >
                <div class="mr-4 rounded-full p-1 bg-Dark-m bg-opacity-70">
                    <AlertCircle v-if="alert.type === 'error'" class="bg-Error rounded-full p-1"></AlertCircle>
                    <AlertOctagon v-if="alert.type === 'info'" class="bg-Info rounded-full p-1"></AlertOctagon>
                    <AlertTriangle v-if="alert.type === 'warn'" class="bg-Warn rounded-full p-1"></AlertTriangle>
                    <CheckCircle v-if="alert.type === 'done'" class="bg-Done rounded-full p-1"></CheckCircle>
                </div>
                <div class="divide-y" :class="color(alert.type, 'divide-')">
                    <div class="first:pt-0 last:pb-0 py-1 min-w-fit" :class="color(alert.type, 'text-')">
                        {{ alert.massage }}
                    </div>
                </div>

                <button
                    @click.prevent.once="close(alert)"
                    type="submit"
                    class="ml-4 sm:ml-10 p-0.5 rounded-full text-Light/60 active:text-Done pointer-events-auto hover:text-Light bg-Dark-m bg-opacity-70"
                >
                    <XCircle class="w-5 h-5"></XCircle>
                </button>
            </div>
        </transition-group>
    </div>
</template>

<script>
import {XCircle, AlertCircle, AlertOctagon, AlertTriangle, CheckCircle} from 'lucide-vue';
import {mapGetters, mapActions} from 'vuex';

export default {
    name: "U-Alerts",
    components: {
        XCircle,
        AlertCircle,
        AlertOctagon,
        AlertTriangle,
        CheckCircle,
        mapGetters,
        mapActions,
    },
    data() {
        return {
            data: [],
        }
    },
    computed: mapGetters(['GET_ALERTS']),
    methods: {
        ...mapActions(['SET_ACTIVE_ALERTS', 'SET_ALERT_HIDDEN','SET_ALERT_DELETED']),
        color(type, prefix) {
            if (type === 'error') {
                return `${prefix}Error`;
            } else if (type === 'info') {
                return `${prefix}Info`;
            } else if (type === 'warn') {
                return `${prefix}Warn`;
            } else {
                return `${prefix}Done`;
            }
        },
        async setData() {
            await this.SET_ACTIVE_ALERTS().then((result, reject) => {
                this.data = result;
            });
        },
        close(alert) {
            this.SET_ALERT_HIDDEN(alert);
            this.setData();
            setTimeout(() => {
                this.SET_ALERT_DELETED(alert);
            }, 300);

        },
        // auto_close() {
        //     for (let k in this.data) {
        //         let time = 3000 +(1500*(k+1));
        //         setTimeout(() => {
        //             this.close(this.data[k]);
        //         }, time);
        //     }
        // }
    },
    watch: {
        GET_ALERTS() {
            this.setData();
        },
        // data() {
        //     this.auto_close();
        // }
    }
}
</script>

<style scoped>
.action-enter, .action-leave-to {
    opacity: 0;
    transform: translateY(-150%);
}
.action-leave-active {
    position: absolute;
}
</style>
