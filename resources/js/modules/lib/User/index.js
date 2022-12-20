export default {
    state: {
        user: {
            data: {},
            auth: false,
            token: '',
        }
    },

    getters: {
        GET_AUTH: (state) => {
            return state.user;
        }
    },

    mutations: {

    },

    actions: {
        SET_AUTH: (ctx) => {
            if(localStorage.getItem('token')){
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`/api/main/resource`).then(res => {
                        ctx.state.user.data = res.data.data.auth;
                        ctx.state.user.token = localStorage.getItem('token');
                        if(ctx.state.user.token) ctx.state.user.auth = true;
                    }).catch(() => {});
                });
            }
        },

    }
}
