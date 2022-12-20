export default {
    state: {
        main: {
            user: {},
            token: null,
        },
    },

    getters: {
        GET_USER: (state) => {
            return state.main.user;
        },

        GET_TOKEN: (state) => {
            return state.main.token;
        },
    },

    mutations: {
        SET_USER: (state, data) => {
            state.main.user = data;
        },

        SET_TOKEN: (state, data) => {
            state.main.token = data;
        },
    },

    actions: {
        SET_DATA: (ctx) => {
            if(localStorage.getItem('token')){
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`/api/main/resource`).then(res => {
                        ctx.commit('SET_USER', res.data.data.auth);
                        ctx.commit('SET_TOKEN', localStorage.getItem('token'));
                    }).catch(() => {});
                });
            }
        },

        GET_GAMES: (ctx, path = null) => {
            return new Promise((resolve, reject) => {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(path ? path : `/api/games`).then(res => {
                        resolve(path ? res.data : res.data.data);
                    }).catch((err) => {
                        reject(err);
                    });
                });
            });
        },

        GET_GAME: (ctx, id) => {
            return new Promise((resolve, reject) => {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`/api/games/get/${id}`).then(res => {
                        resolve(res.data.data);
                    }).catch((err) => {
                        reject(err);
                    });
                });
            });
        },

        GET_AVATAR_EDIT_OPTIONS: (ctx, id) => {
            return new Promise((resolve) => {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`/api/avatar/${id}`).then(res => {
                        resolve(res.data.data);
                    });
                });
            });
        },

        GET_PROFILE: (ctx, id) => {
            return new Promise((resolve, reject) => {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`/api/users/${id}`).then(res => {
                        resolve(res.data.data);
                    }).catch(e => {
                        reject(e)
                    })
                });
            });
        },

        EDIT_PROFILE: (ctx, data) => {
            return new Promise((resolve, reject) => {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post(`/api/users/${ctx.state.main.user.id}/edit`, data)
                        .then(res => {
                            resolve({
                                errors: res.data.done,
                                type: 'done'
                            });
                        })
                        .catch(err => {
                            reject({
                                errors: err.response.data.errors,
                                type: 'error'
                            });
                    });
                });
            })
        },

        GET_ROLES: (ctx, options) => {
            return new Promise((resolve, reject) => {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`/api/roles?${options}`).then(res => {
                        resolve(res.data);
                    }).catch(e => {
                        reject(e)
                    });
                });
            })
        }
    }
}
