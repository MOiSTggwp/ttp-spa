import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/', component: () => import('../views/index'),
            name: 'home',
        },
        {
            path: '/test', component: () => import('../views/test'),
            name: 'test',
        },
        {
            path: '/users/:id', component: () => import('../views/users/show'),
            name: 'users.show',
        },
        {
            path: '/users/:id/edit', component: () => import('../views/users/edit'),
            name: 'users.edit',
        },
        {
            path: '/games/:count?', component: () => import('../views/games/index'),
            name: 'games',
        },
        {
            path: '/games/get/:id', component: () => import('../views/games/show'),
            name: 'games.show',
        },
        {
            path: '/admin', component: () => import('../views/admin/index'),
            name: 'admin',
        },
        {
            path: '/admin/lib', component: () => import('../views/admin/LIB'),
            name: 'admin.lib',
        },
        {
            path: '/admin/games', component: () => import('../views/admin/games'),
            name: 'admin.games',
        },
        {
            path: '/admin/mods', component: () => import('../views/admin/mods'),
            name: 'admin.mods',
        },
    ],
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    if (!token) {
        if(to.name !== 'home') {
            return next({ name: 'home' });
        }
    }
    next();
});

export default router;
