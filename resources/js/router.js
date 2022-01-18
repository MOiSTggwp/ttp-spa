import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home', component: () => import('./views/index'),
            name: 'home',
        },
        {
            path: '/test', component: () => import('./views/test'),
            name: 'test',
        },
        {
            path: '/users/:id', component: () => import('./views/users/show'),
            name: 'users.show',
        },
        {
            path: '/users/:id/edit', component: () => import('./views/users/edit'),
            name: 'users.edit',
        },
    ],
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');

    if (!token) {
        if (to.name === 'home') {
            return next();
        } else {
            return next({
                name: 'home'
            });
        }
    }

    next();

});

export default router;
