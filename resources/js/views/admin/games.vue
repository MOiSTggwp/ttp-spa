<template>
    <div>
        <!--        <InputTest :options="{-->
        <!--            id: 'test2',-->
        <!--            type: 'text',-->
        <!--            text: 'placeholder2',-->
        <!--            value: 'text2',-->
        <!--            width: 500,-->
        <!--            padding: true,-->
        <!--            min: 1,-->
        <!--            max: 100,-->
        <!--            error: false,-->
        <!--        }"/>-->
        <!--        <AlertTest :arr="{...arr1}"></AlertTest>-->
        <!--        <AlertTest :arr="{...arr2}"></AlertTest>-->
        <!--        <AlertTest :arr="{...arr3}"></AlertTest>-->
        <U-Avatar></U-Avatar>

        <U-Range-Number spacer="Время игры" withVal="11" withText="с" beforeText="до" width="50" min="1" max="24"></U-Range-Number>

        <U-Img url="https://static-cdn.jtvnw.net/ttv-boxart/512953_IGDB-285x380.jpg" :loading="true" :alt="null" w="280"></U-Img>

        <div class="w-[300px] h-[200px]">
            <U-Textarea text="Test placeholder" max="100" :padding="false"></U-Textarea>
        </div>

        <U-Input text="Test placeholder" max="10" min="4" :padding="false"></U-Input>


        <br>

        <U-Checkbox
            :data="[{id: 1, name: 'тест1'}]"
            :checked="[{id: 1, name: 'тест1'}]"
            type="checkbox"
            :error="true"
        ></U-Checkbox>

        <U-Badge class="text-xs" :position="['right', 'top']" size="10">
            <div class="w-20 h-20 bg-Light/40 rounded-md">

            </div>
        </U-Badge>

        <U-Title class="mb-4" h="1">Тестовый текст</U-Title>

        Провека текста подсказки и ее размещения,
        <U-Link>тестовый текст</U-Link>
        для оценки обстановки с переносом текста!

        <U-Spacer position="center" h="5">Тестовый текст</U-Spacer>

        <Table :columns="columns" :data="data" class="mb-4"></Table>
        <U-Paginate :pagination="pagination" :links="links" web-path="/admin/games" @change="setLink"></U-Paginate>

        <div class="w-full flex justify-center items-end bg-Warn">
            <div>
                <U--Hint text="Провека текста подсказки и ее размещения, для оценки обстановки с переносом текста!">
                    <div class="w-[40px] h-10 bg-Dark"></div>
                </U--Hint>
            </div>
        </div>
        <div class="m-20 mb-2">
            <U-Select max="1"></U-Select>
        </div>
        <div class="w-full p-4 border">
            <div class="p-2 border flex flex-wrap gap-2">
                <U-Tag class="text-Light/50 text-xs" color="error" border="dashed" border-color="error">Тестовый тег
                </U-Tag>
                <U-Tag :button="false">Тестовый</U-Tag>
                <U-Tag color="warn">тег</U-Tag>
                <U-Tag>для оценки обстановки</U-Tag>
            </div>
        </div>

    </div>
</template>

<script>
import Label from "../../UI/Label";
import Table from '../../UI/Table';
import {mapActions} from 'vuex';

export default {
    name: "games",
    components: {
        Table,
        Label,
    },
    data() {
        return {
            addData: [],

            arr1: {
                type: 'done',
                massage: 'Провека текста подсказки и ее размещения, для оценки обстановки с переносом текста!',
                show: true,
                button: true
            },
            arr2: {type: 'error', massage: 'Тестовое сообщение2', show: true, button: true},
            arr3: {type: 'warn', massage: 'Тестовое сообщение3', show: true, button: true},
            arr4: {type: 'info', massage: 'Тестовое сообщение4', show: true, button: true},
            arr5: {type: 'error', massage: 'Тестовое сообщение5', show: true, button: true},

            data: {},
            links: {},
            pagination: {},
            pathName: '/api/admin/games',
            loading: false,
            columns: [
                {
                    title: 'Название',
                    name: [
                        'name'
                    ],
                    width: 60,
                    text: {
                        position: '',
                    },
                    link: '',
                    toggle: 'input'
                },
                {
                    title: 'Ссылка',
                    name: [
                        'url'
                    ],
                    width: 20,
                    text: {
                        position: 'center',
                    },
                    img: true,
                    toggle: 'input'
                },
                {
                    title: 'Действия',
                    name: [
                        'events'
                    ],
                    width: 20,
                    text: {
                        position: 'center',
                    },
                    button: [
                        {
                            text: 'Edit',
                            name: 'edit',
                            toggle: true,
                        },
                        {
                            text: 'Delete',
                            name: 'delete',
                        },
                    ]
                }
            ],
        }
    },
    mounted() {
        this.getGames();

        this.SET_ALERT(this.arr4);
        this.SET_ALERT(this.arr1);
        this.SET_ALERT(this.arr2);
        this.SET_ALERT(this.arr3);
        this.SET_ALERT(this.arr5);
    },
    methods: {
        ...mapActions(['SET_ALERT']),
        async getGames() {
            await axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(this.pathName + '?' + window.location.search.replace('?', '')).then(res => {
                    this.pagination = res.data.meta;
                    this.links = res.data.links;
                    this.data = res.data.data;
                    this.loading = true;
                });
            });
        },
        setLink() {
            this.loading = false;
            this.getGames();
        },

    },
}
</script>

<style scoped>

</style>
