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
import moment from "moment";
import UsersIndex from "../views/Admin/Users/UsersIndex.vue";

const router = createRouter({
    history: createWebHistory(store.getters['config/appBasePath']),
    routes: [
        {
            path: '',
            name: 'Home',
            component: Home,
            beforeEnter: (to, from, next) => {
                let jwt = store.getters['user/getJwt'];
                if (jwt.access_token !== null) {
                    let expired = jwt.expired
                    let now = moment();
                   if(expired > now.format('DD/MM/YYYY HH:mm:ss'))
                    next();
                   else{
                       next({ name: 'ApplicationLogin',query:{logout: "Session exipred"} });
                   }
                } else {
                    next({ name: 'ApplicationLogin' });
                }
            },
            children: [
                {
                    path: 'user',
                    children: [
                        {
                            path:'details',
                            name:'UserIndex',
                            component: UsersIndex
                        }
                    ]
                }
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
