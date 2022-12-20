<template>
    <div>
        <U-Title class="mb-4" :h="4">Настройка Ролей</U-Title>
        <div class="flex gap-2 items-center justify-center mb-2 bg-Dark p-4 rounded-md shadow-md">
            <U-Input text="Роль" :padding="false" @res="resRole" :val="role"></U-Input>
            <U-Input text="Метка" :padding="false" @res="resTag" :val="tag"></U-Input>
            <U-Button text="Добавить" @click="addRole"></U-Button>
        </div>
        <U-Spacer>Роли</U-Spacer>
        <div v-if="roles">
            <div v-if="roles.data && roles.data.length > 0">
                <div class="flex justify-center items-center gap-2 bg-Dark p-2 my-2 rounded-md shadow-md">
                    <U-Input class="w-[300px]" text="Поиск роли" type="search" :padding="false" @res="resSearch" :val="search"></U-Input>
                    <U-Select
                        width="120"
                        text="Кол-во ролей"
                        :data="paginate"
                        :value="paginateSelect"
                        :multi="false"
                        @res="resPaginate"
                    ></U-Select>
                </div>
                <div v-for="item in roles.data" :key="item.id">
                    <div v-if="!checkEdit(item.id)" class="flex justify-between items-center gap-2 bg-Dark p-4 my-2 rounded-md shadow-md">
                        <div class="flex-1">
                            {{ item.name }}
                        </div>
                        <div class="flex-1">
                            {{ '#' + item.tag }}
                        </div>
                        <div class="flex gap-2">
                            <U-Button text="Изменить" color="warn" @click="addEdit(item.id)"></U-Button>
                            <U-Button text="Удалить" color="error" @click="deleteRole(item.id)"></U-Button>
                        </div>
                    </div>
                    <div v-else class="flex justify-between items-center gap-2 bg-Dark p-4 my-2 rounded-md shadow-md">
                        <U-Input text="Роль" :padding="false" :val="item.name" @res="resRoleEdit($event, item.id)"></U-Input>
                        <U-Input text="Метка" :padding="false" :val="item.tag" @res="resTagEdit($event, item.id)"></U-Input>
                        <div class="flex gap-2">
                            <U-Button text="Сохранить" color="done" @click="updateRole(item.id)"></U-Button>
                            <U-Button text="Отменить" @click="removeEdit(item.id)"></U-Button>
                        </div>
                    </div>
                </div>
                <U-Paginate :links="roles.links" :pagination="roles.meta" :web-path="'/admin'" @change="getRoles" class="mt-2"></U-Paginate>
            </div>
            <div v-else class="bg-Dark text-Dark-m text-center p-4 font-bold">
                Ролей нет
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "roles",
    components: {},

    data() {
      return {
          paginate: [{id:1, name: '8'}, {id:2, name: '16'}, {id:3, name: '24'}, {id:4, name: '32'}, {id:5, name: '40'}],
          paginateSelect: [{id:1, name:'8'}],
          search: '',
          edit: [],
          roles: [],
          role: '',
          tag: ''
      }
    },
    mounted() {
        this.getRoles();
    },
    methods: {
        ...mapActions(['SET_ALERT', 'GET_ROLES']),
        addRole() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post(`/api/admin/roles`, {name: this.role, tag: this.tag}).then(res => {
                    this.role = '';
                    this.tag = '';
                    this.getRoles();
                    this.setAlert(res.data.done, 'done');
                }).catch(err => {
                    this.setAlert(err.response.data.errors, 'error');
                });
            });
        },

        updateRole(id) {
            const role = this.edit.filter(i => i.id === id)[0];
            const data = new FormData();
            data.append('_method', 'PATCH');
            data.append('name', role.name);
            data.append('tag', role.tag);
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post(`/api/admin/roles/${id}/update`, data).then(res => {
                    this.edit = this.edit.filter(i => i.id !== id);
                    this.getRoles();
                    this.setAlert(res.data.done, 'done');
                }).catch(err => {
                    this.setAlert(err.response.data.errors, 'error');
                });
            });
        },

        deleteRole(id) {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.delete(`/api/admin/roles/${id}`).then(res => {
                    // this.edit = this.edit.filter(i => i.id !== item.id);
                    this.getRoles();
                    this.setAlert(res.data.done, 'done');
                }).catch(err => {
                    this.setAlert(err.response.data.errors, 'error');
                });
            });
        },

        getRoles() {
            let url = new URL(window.location.href);
            url.searchParams.set('s', 'roles');
            window.history.pushState(null, "", `${url}`);
            if(url.searchParams.has('paginate') && url.searchParams.get('paginate') !== this.paginateSelect[0].name) {
                this.paginateSelect = this.paginate.filter(i => i.name === url.searchParams.get('paginate'));
            }
            if(url.searchParams.has('search') && url.searchParams.get('search') !== this.search) {
                this.search = url.searchParams.get('search');
                console.log(this.search)
            }
            this.GET_ROLES(`page=${url.searchParams.get('page') ? url.searchParams.get('page') : 1}&paginate=${this.paginateSelect[0].name}${this.search ? `&search=${this.search}` : ``}`)
                .then(res => {
                    this.roles = res;
            });
        },

        addEdit(id) {
            const count = this.edit.filter(i => i === id).length;
            if(count <= 0) {
                this.edit.push({
                    id: id,
                    name: null,
                    tag: null
                });
            }
        },

        removeEdit(id) {
            this.edit = this.edit.filter(i => i.id !== id);
        },

        checkEdit(id) {
            for (let i in this.edit) {
                if (this.edit[i].id === id) {
                    return true;
                }
            }
            return false;
        },

        resSearch(r) {
            let url = new URL(window.location.href);
            if (this.search !== r) {
                this.search = r;
                url.searchParams.set('search', this.search);
                window.history.pushState(null, "", `${url}`);
            }
        },

        resPaginate(r) {
            let url = new URL(window.location.href);
            if (this.paginateSelect[0] !== r[0]) {
                this.paginateSelect = r
                url.searchParams.set('paginate', this.paginateSelect[0].name);
                window.history.pushState(null, "", `${url}`);
            }
        },

        resRole(r) {
            this.role = r;
        },

        resTag(r) {
            this.tag = r;
        },

        resRoleEdit(r, id) {
            const role = this.edit.filter(i => i.id === id);
            if(role.length > 0) {
                role[0].name = r;
            }
        },

        resTagEdit(r, id) {
            const role = this.edit.filter(i => i.id === id);
            if(role.length > 0) {
                role[0].tag = r;
            }
        },

        setAlert(alert, type) {
            for(let item in alert) {
                this.SET_ALERT({
                    name: item,
                    type: type,
                    massage: alert[item][0],
                    show: true,
                    button: true
                });
            }
        },
    },
    watch: {
        paginateSelect() {
            this.getRoles();
        },
        search() {
            this.getRoles();
        }
    }
}
</script>

<style scoped>

</style>
