import { createRouter, createWebHistory } from 'vue-router';
import store from '../store'


import Home from "../views/Home.vue";
/** Login */
import ApplicationLogin from "../views/Logins/ApplicationLogin.vue";

/** Admin */
import AdminUsersIndex from "../views/Admin/Users/UsersIndex.vue";
import AdminCreateUser from "../views/Admin/Users/UsersCreate.vue";
import AdminDeleteUser from "../views/Admin/Users/UsersDelete.vue";
import AdminEditUser from "../views/Admin/Users/UsersEdit.vue";

import AdminHome from "../views/Admin/AdminHome.vue";

const router = createRouter({
    history: createWebHistory(store.getters['config/appBasePath']),
    routes: [
        {
            path: '',
            name: 'Home',
            component: Home,
            beforeEnter: (to, from, next) => {
                if (localStorage.getItem('pds-provisioning-token')) {
                    next();
                } else {
                    next({ name: 'ApplicationLogin' });
                }
            },
        },
        {
            path: '/admin',
            name: 'AdminHome',
            component: AdminHome,
            beforeEnter: (to, from, next) => {
                if (store.state.user.isAuthenticated === true) {
                    next();
                } else {
                    next({ name: 'Home' });
                }
            },
            children: [
                {
                    path: 'users',
                    name: 'AdminUsersIndex',
                    component: AdminUsersIndex,
                    children: [
                        {
                            path: "create",
                            name: "AdminCreateUser",
                            component: AdminCreateUser
                        },
                        {
                            path: "edit/:id",
                            name: "AdminEditUser",
                            component: AdminEditUser
                        },
                        {
                            path: "delete/:id",
                            name: "AdminDeleteUser",
                            component: AdminDeleteUser
                        }
                    ]
                },
            ]
        },
        {
            path: '/application-login',
            name: 'ApplicationLogin',
            component: ApplicationLogin
        },
        {
            path: '/:pathMatch(.*)*',
            redirect: { name: 'AdminHome', params: {} }
        }
    ],
});

export default router
